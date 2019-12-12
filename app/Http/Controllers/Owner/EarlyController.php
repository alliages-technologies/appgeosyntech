<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Bilan;
use App\Models\ChoicesEarlie;
use App\Models\ChoicesProjet;
use App\Models\Concurrent;
use App\Models\Devise;
use App\Models\Earlie;
use App\Models\EarliesProduit;
use App\Models\Environnement;
use App\Models\Investissement;
use App\Models\Modele;
use App\Models\Moi;
use App\Models\ProduitsProjet;
use App\Models\Projet;
use App\Models\Reportbilan;
use App\Models\Reportresultat;
use App\Models\Resultat;
use App\Models\Segment;
use App\Models\Tags;
use App\Models\TagsProjet;
use App\Models\Tinvestissement;
use App\Models\Tprojet;
use App\Models\Variante;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prevbilan;
use App\Models\Prevresultat;
use App\Models\Prevtresorerie;
use PHPUnit\Framework\Exception;

class EarlyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dossiers = Earlie::orderBy('created_at','desc')->where('owner_id',Auth::user()->id)->paginate(8);
        return view('/Owner/Earlies/index')->with(compact('dossiers'));
    }

	public function getChoicesJson(Request $request){
		$projet = Earlie::find($request->id);
		$choices = $projet->choices;

		$choix = [];
		foreach($choices as $choice){
			$choix[] = $choice->choice_id;
		}
		return response()->json($choix);
	}

	//Creation du diagnostic externe
	public function createDiagExterne($token){
		$projet = Earlie::where('token',$token)->first();
		return view('/Consultant/Earlies/create_diag_externe')->with(compact('projet'));
	}

	//Sauvegarde du diagnostic externe
	public function saveDiagExterne(Request $request){

		$dossier = Earlie::where('token',$request->token)->first();
		$segments = $request->segments;
		$concurrents=$request->concurrents;

		//dd($request->env);

		if($dossier){
			if($dossier->concurrents){
				Concurrent::where('earlie_id',$dossier->id)->delete();
			}
			for($i=0; $i<count($concurrents); $i++){
				$concurrent = new Concurrent();
				$concurrent->earlie_id=$dossier->id;
				$concurrent->name=$concurrents[$i]['qui'];
				$concurrent->quoi=$concurrents[$i]['quoi'];
				$concurrent->quand=$concurrents[$i]['quand'];
				$concurrent->ou=$concurrents[$i]['ou'];
				$concurrent->combien=$concurrents[$i]['combien'];
				$concurrent->fournisseur=$concurrents[$i]['fournisseur'];
				$concurrent->comment=$concurrents[$i]['comment'];
				$concurrent->fidelisation=$concurrents[$i]['fidelisation'];
				$concurrent->communication=$concurrents[$i]['communication'];
				$concurrent->ca=$concurrents[$i]['ca'];
				$concurrent->salaires=$concurrents[$i]['sal'];
				//$concurrent->ebe=$concurrents[$i]['ebe'];
				//$concurrent->va=$concurrents[$i]['va'];
				$concurrent->cv=$concurrents[$i]['cv'];
				$concurrent->cf=$concurrents[$i]['cf'];
				//$concurrent->marge_brute=$concurrents[$i]['mb'];
				$concurrent = $concurrent->save();
			}
			//dd($concurrent);
			if($dossier->segments){
				Segment::where('earlie_id',$dossier->id)->delete();
			}
			for($i=0; $i<count($segments); $i++){
				$concurrent = new Segment();
				$concurrent->earlie_id=$dossier->id;
				$concurrent->name=$segments[$i]['qui'];
				$concurrent->quoi=$segments[$i]['quoi'];
				$concurrent->quand=$segments[$i]['quand'];
				$concurrent->ou=$segments[$i]['ou'];
				$concurrent->combien=$segments[$i]['combien'];
				$concurrent->pourquoi=$segments[$i]['pourquoi'];
				$segment = $concurrent->save();
			}

			if($dossier->environnement){
				Environnement::where('earlie_id',$dossier->id)->delete();
			}

			$env = $request->env;
			$environnement = new Environnement();
			$env['earlie_id'] = $dossier->id;
			$env['user_id'] = Auth::user()->id;
			$environnement = Environnement::create($env);
			if($environnement){
				$dossier->etape=2;
				$dossier->save();
			}
		}
		// $id=$dossier->id;
		return response()->json($dossier);

	}


	public function openDataroom($token){
		$invest = Investissement::updateOrCreate(['token'=>$token],['validated'=>1]);
		return back();
	}

	public function closeDataroom($token){
		$invest = Investissement::updateOrCreate(['token'=>$token],['validated'=>0]);
		return back();
	}

	public function createLetter($token){
		$invest = Investissement::where('token',$token)->first();
		$letter = $invest->lettre;
		if($letter){
			// Creating the new document...
			$phpWord = new \PhpOffice\PhpWord\PhpWord();

			/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
			$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...

			$section->addText(
				'La présente lettre d’intention décrit les principales conditions et '
				.'modalités selon lesquelles l’investissement envisagé dans le projet'. $invest->projet->name .'pourrait être réalisé. '
			);

			$section->addText(
				'Elle ne constitue en aucun cas un engagement ferme et irrévocable des parties de procéder à cet investissement. '
			);

			$section->addText(
				'Cette lettre d’intention a été préparée sur la base et en l’état des informations reçues de la Société à ce jour, et particulièrement du business plan qui ont été préparés par les Fondateurs.'
			);

			$section->addText(
				'Le montant total de l’investissement étant estimé à '. $invest->projet->montant .' ' . $invest->projet->devise->name.','
				.'je, soussigné, '. $invest->angel->name .', agissant pour'. $invest->lettre->personnel?' Mon propre compte':' le compte de '.$invest->angel->entreprise?$invest->angel->entreprise->name:$invest->angel->organisme->name .', manifeste le souhait de participer à cette opération
				sous forme de '. $invest->lettre->type->name .'  à hauteur de '.$invest->lettre->montant .' ' . $invest->lettre->devise->name
			);



			// Saving the document as OOXML file...
			$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
			try{
				$objWriter->save(public_path('files/docs').'/Lettre_intention.docx');
			}catch (Exception $e){

			}

			return response()->download(public_path('files/docs').'/Lettre_intention.docx');


		}else{
			return back();
		}

	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

	    $villes = Ville::all()->where('pay_id',Auth::user()->pay_id);

	    $devises = Devise::all();

        return view('/Owner/Earlies/create')->with(compact('villes','devises'));
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 * edit a field with a new value
	 */

	public function editFieldJson(Request $request){
		$model = $request->model;
		$id = $request->id;
		$name = $request->name;
		$value = $request->value;
		$search = null;
		if($model=='Prevbilan'){
			$search = Prevbilan::find($id);
			$search->$name=$value;
			$search->save();
			return response()->json($search);
		}

		//dd($model);

		//$search = App\Models\$model::find($id);
		dd($search);
	}

	public function addTags(Request $request){
		//dd(public_path('img'));

		$projet = Projet::where('token',$request->projet_token)->first();
		$tag = TagsProjet::all()->where('tag_id',$request->tag_id)->where('projet_id',$projet->id)->first();
		if(!$tag){
			$tag = new TagsProjet();
			$tag->tag_id = $request->tag_id;
			$tag->projet_id = $projet->id;
			$tag->save();
		}
		return back();
	}


	public function editReport(Request $request){
		//dd(public_path('img'));

		$projet = Earlie::where('token',$request->projet_token)->first();
		$resultat = ['ca','cf','cv','ape','pi','ps','sp','taxes','dap','impots','pf','cfi','ce','pe','salaires','participations'];
		$rs = $resultat;
		$rs[] = 'moi_id';
		$inputs = $request->only($rs);
		$inputs['annee']=date('Y');
		$inputs['projet_id']=$projet->id;
		$inputs['token']=sha1(Auth::user()->id. date('Yhmids'));
		$inputs['user_id'] = Auth::user()->id;
		$reportrslt = Reportresultat::updateOrCreate(['projet_id'=>$projet->id,'moi_id'=>$request->moi_id,'annee'=>date('Y')],$inputs);
		$resultat[]='projet_token';
		$inputs = $request->except($resultat);
		$inputs['annee']=date('Y');
		$inputs['projet_id']=$projet->id;
		$inputs['token']=sha1(Auth::user()->id. date('Yhmids'));
		$inputs['user_id'] = Auth::user()->id;
		$reportbilan = Reportbilan::updateOrCreate(['projet_id'=>$projet->id,'moi_id'=>$request->moi_id,'annee'=>date('Y')],$inputs);
		return back();
	}


	public function uploadImage(Request $request){

		//dd(public_path('img'));
		$projet = Projet::where('token',$request->projet_token)->first();
		$file = $request->imageUri;
		$ext = $file->getClientOriginalExtension();
		$arr_ext = array('jpg','png','jpeg','gif');
		if(in_array($ext,$arr_ext)){
			if(!file_exists(public_path('img').'/projets')){
				mkdir(public_path('img').'/projets');
			}
			//dd($projet);
			if(file_exists(public_path('img').'/projets/'.$projet->token.'.'.$ext)){
				unlink(public_path('img').'/projets/'.$projet->token.'.'.$ext);
			}
			$name = $projet->token.'.'.$ext;
			$file->move(public_path('img/projets'), $name);
			//move_uploaded_file($file['tmp_name'], WWW_ROOT.'img'.DS.'membres'.DS.$name.'.'.$ext);
			$projet->imageUri = 'projets/'.$name;
			$projet->save();
		}
		return redirect()->back();
	}

	/*
	 *  Chargement de l'ordre de virement
	 */

	public function editDocs(Request $request){

		//dd(public_path('img'));
		$projet = Earlie::where('token',$request->projet_token)->first();

		$ordre = $request->ordre;
		if($ordre){
			$ext = $ordre->getClientOriginalExtension();
			$arr_ext = array('jpg','png','jpeg','gif','pdf');
			if(in_array($ext,$arr_ext)){
				if(!file_exists(public_path('files'))){
					mkdir(public_path('files'));
				}
				if(!file_exists(public_path('files'))){
					mkdir(public_path('files/earlies'));
				}
				if (!file_exists(public_path('files/earlies/ordres_virement'))) {
					mkdir(public_path('files/earlies/ordres_virement'));
				}

				if (file_exists(public_path('files/earlies/ordres_virement/') . $projet->token.'.' . $ext)) {
					unlink(public_path('files/earlies/ordres_virement/') . $projet->token .  '.' . $ext);
				}
				$name =  $projet->token .'.'. $ext;
				$ordre->move(public_path('files/earlies/ordres_virement'), $name);
				Earlie::updateOrCreate(['token'=>$projet->token],['ordrevirementUri'=>$name]);
			}

		}

		$pacte = $request->pacte;
		if($pacte){
			$ext = $pacte->getClientOriginalExtension();
			$arr_ext = array('odt','docx','doc','pdf');
			if(in_array($ext,$arr_ext)){
				if(!file_exists(public_path('files'))){
					mkdir(public_path('files'));
				}
				if(!file_exists(public_path('files/earlies'))){
					mkdir(public_path('files/earlies'));
				}
				if (!file_exists(public_path('files/earlies/pactes_actionnaires'))) {
					mkdir(public_path('files/earlies/pactes_actionnaires'));
				}

				if (file_exists(public_path('files/earlies/pactes_actionnaires/') . $projet->token.'.' . $ext)) {
					unlink(public_path('files/earlies/pactes_actionnaires/') . $projet->token .  '.' . $ext);
				}
				$name =  $projet->token .'.'. $ext;
				$pacte->move(public_path('files/earlies/pactes_actionnaires'), $name);
				Earlie::updateOrCreate(['token'=>$projet->token],['pacte_associesUri'=>$name]);
			}

		}

		$pret = $request->pret;
		if($pret){
			$ext = $pret->getClientOriginalExtension();
			$arr_ext = array('doc','docx','pdf','odt');
			if(in_array($ext,$arr_ext)){
				if(!file_exists(public_path('files'))){
					mkdir(public_path('files'));
				}
				if(!file_exists(public_path('files/earlies'))){
					mkdir(public_path('files/earlies'));
				}
				if (!file_exists(public_path('files/earlies/contrats_pret'))) {
					mkdir(public_path('files/earlies/contrats_pret'));
				}

				if (file_exists(public_path('files/earlies/contrats_pret/') . $projet->token.'.' . $ext)) {
					unlink(public_path('files/earlies/contrats_pret/') . $projet->token .  '.' . $ext);
				}
				$name =  $projet->token .'.'. $ext;
				$pret->move(public_path('files/earlies/contrats_pret'), $name);
				Earlie::updateOrCreate(['token'=>$projet->token],['contrat_pretUri'=>$name]);
			}

		}
		return back();

	}


	// Premiere sauvegarde du dossier

	public function initJson(Request $request){
		//$dossier = new Projet();

		//dd(json_decode($request->all()['dossier'])->name);
		$dossier = json_decode($request->all()['dossier'],true);
		$answers = isset($request->all()['answers'])?json_decode($request->all()['answers'],true):null;
		$produits = isset($request->all()['produits'])?json_decode($request->all()['produits'],true):null;
		$modele = isset($request->all()['modele'])?json_decode($request->all()['modele'],true):null;

		//$dossier = $request->all()['dossier'];

		$dossier['moi_id'] = date('m');
		$dossier['annee'] = date('Y');
		$dossier['author_id']= Auth::user()->id;
		$dossier['owner_id']=Auth::user()->id;
		$dossier['description_modele_economique'] = isset($request->all()['bm'])?$request->bm:'pas de modele';
		$token = sha1(date('ymdhs').$dossier['owner_id']);
		$dossier['token'] = $token;

		$file = $request->imageUri;
		if($file){
			$ext = $file->getClientOriginalExtension();
			$arr_ext = array('jpg','png','jpeg','gif');
			if(in_array($ext,$arr_ext)){
				if(!file_exists(public_path('img').'/earlies')){
					mkdir(public_path('img').'/earlies');
				}
				//dd($projet);
				if(file_exists(public_path('img').'/earlies/'.$token.'.'.$ext)){
					unlink(public_path('img').'/earlies/'.$token.'.'.$ext);
				}
				$name = $token.'.'.$ext;
				$file->move(public_path('img/earlies'), $name);
				//move_uploaded_file($file['tmp_name'], WWW_ROOT.'img'.DS.'membres'.DS.$name.'.'.$ext);
				$dossier['imageUri'] = 'earlies/'.$name;
			}
		}


		$dossier = Earlie::create($dossier);
		if($dossier){
			if($produits){
				for($i = 0; $i<count($produits);$i++){
					$dp = new EarliesProduit();
					//$dp->produi_id =
					$dp->produit_id = $produits[$i];
					$dp->earlie_id = $dossier->id;
					$dp->save();
				}
			}


			if($answers){
				foreach($answers as $answer){
					$an= new ChoicesEarlie();
					$an->choice_id=$answer['choice_id'];
					$an->earlie_id=$dossier->id;
					$an->save();
				}
			}

			if($modele){
				$modele['earlie_id'] = $dossier->id;
				$modele['token'] =sha1(date('myhsiyd').Auth::user()->id);
				$modele = Modele::create($modele);

			}


		}

		return response()->json($dossier);
		//dd($request->all());
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        //
		$tags = Tags::all();
	    $projet = Earlie::where(['token'=>$token])->first();
	    $mois = Moi::all();
	    //dd($dossier->bilans);
	    return view('Owner/Earlies/show')->with(compact('projet','tags','mois'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit(Projet $projet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projet $projet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projet $projet)
    {
        //
    }
}
