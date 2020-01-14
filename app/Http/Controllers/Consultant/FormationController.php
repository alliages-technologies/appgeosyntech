<?php

namespace App\Http\Controllers\Consultant;

use App\Http\Controllers\Controller;
use App\Models\Cour;
use App\Models\Entreprise;
use App\Models\Formation;
use App\Models\Module;
use App\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Organisme;
use App\Models\Pay;
use App\Models\Torganisme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $formations = Formation::all()->where('chaire_obac',0)->sortByDesc('created_at')->paginate(10);

	    return view('Consultant/Formations/index')->with(compact('formations'));
    }

	public function chaire()
	{
		$formations = Formation::all()->where('chaire_obac',1)->sortByDesc('created_at')->paginate(10);
		return view('Consultant/Formations/index')->with(compact('formations'));
	}


	public function disable($token){
		$user = Formation::updateOrCreate(['token'=>$token],['active'=>0]);

		return back();
	}

	public function enable($token){
		$user = Formation::updateOrCreate(['token'=>$token],['active'=>1]);

		return back();
	}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */











    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        //
	    $formation = Formation::where('token',$token)->first();

	    return view('Consultant/Formations/show')->with(compact('formation'));
    }



	public function showModule($token)
	{
		//
		$module = Module::where('token',$token)->first();

		return view('Consultant/Formations/show_module')->with(compact('module'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay $pay)
    {
        //
    }

	public function getModuleTest($token){
		$module = Module::where('token',$token)->first();

		return view('Consultant/Formations/module_test')->with(compact('module'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pay $pay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay $pay)
    {
        //
    }
}
