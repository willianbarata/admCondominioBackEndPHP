<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\UnitVehicles;
use App\Models\UnitPets;

class UnitController extends Controller
{
    
    public function getInfo($id){
        $array = ['error' => ''];

        $unit = Unit::find($id);
        if($unit){

            $peoples = UnitPeople::where('id_unit', $id)->get();
            $vehicles = UnitVehicles::where('id_unit', $id)->get();
            $pets = UnitPets::where('id_unit', $id)->get();

            foreach($peoples as $pKey => $pValue){
                $peoples[$pKey]['birthdate'] = date('d/m/Y', strtotime($pValue));
            }

            $array['peoples'] = $peoples;
            $array['vehicles'] = $vehicles;
            $array['pets'] = $pets;

        }else{
            $array['error'] = 'Propriedade inexistente';
            return $array;
        }

        return $array;
    }

}
