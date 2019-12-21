<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fincredsignature extends Model
{
    //
	protected  $guarded = [];
	public function projet(){
		return $this->belongsTo('App\Models\Projet');
	}

	public function earlie(){
		return $this->belongsTo('App\Models\Earlie');
	}

	public function infrastructure(){
		return $this->belongsTo('App\Models\Infrastructure');
	}

	public function dossier(){

		if($this->projet_id){
			return Projet::find($this->projet_id);
		}
		if($this->earlie_id){
			return Earlie::find($this->earlie_id);
		}
		if($this->infrastructure_id){
			return Infrastructure::find($this->infrastructure_id);
		}
		return null;
	}

	//------------------------------------- Calcul du montant des commissions ------------------------------------------
	public  function getMtComAttribute(){
		return $this->mt_credit * $this->taux_com;
	}

}