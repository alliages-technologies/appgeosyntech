<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pay;
use App\Models\Projet;
use App\Models\Ville;
use Illuminate\Http\Request;

use PDF;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        //
        $villes = Ville::all();
	    $pays = Pay::all();
       // dd($villes);
       // echo "Bonjour tout le monde!!";
       // $request->session()->flash('message','Liste des villes!!!');
        return view('Admin/Villes/index')->with(compact('villes','pays'))->with('success','Liste des villes');

    }


	public function makePdf()
	{
		$data = [
			'title' => 'Mon document en Pdf',
			'heading' => 'OBAC ALERT - By Alliages Technologies',
			'content' => 'Le contenu du document'
		];


		$pdf = PDF::loadView('pdf_view',$data);
		return $pdf->download('medium.pdf');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pays = Pay::all();
        return view('Admin/Villes/create')->with(compact('pays'));
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
        //dd($request->imageUri);
        $ville = new Ville();
        $ville->name = $request['name'];
        $ville->pay_id = $request['pay_id'];
	    $ville->longitude = $request['longitude'];
	    $ville->latitude = $request['latitude'];
	    if($request->imageUri){
		    $file = $request->imageUri;
		    $ext = $file->getClientOriginalExtension();
		    $arr_ext = array('jpg','png','jpeg','gif');
		    if(in_array($ext,$arr_ext)) {
			    if (!file_exists(public_path('img') . '/villes')) {
				    mkdir(public_path('img') . '/villes');
			    }
			    $token = sha1(date('ydmhis'));
			    if (file_exists(public_path('img') . '/villes/' . $token . '.' . $ext)) {
				    unlink(public_path('img') . '/villes/' . $token . '.' . $ext);
			    }
			    $name = $token . '.' . $ext;
			    $file->move(public_path('img/villes'), $name);
			    $ville->imageUri = 'villes/' . $name;
		    }

	    }

        $ville->save();
            $request->session()->flash('success','La ville a été correctement enregistrée !!!');
            return redirect('/admin/villes');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function show($ville)
    {
        //
	    //dd($ville);
        $ville = Ville::find($ville);
	    $projets = Projet::all()->where('active',1)->where('ville_id',$ville->id);
        return view('Front/Villes/show')->with(compact('ville','projets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function edit(Ville $ville)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ville $ville)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ville $ville)
    {
        //
    }
}
