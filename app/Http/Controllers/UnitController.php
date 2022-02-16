<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function addPerson($id, Request $request){
        $array = ['error' => ''];

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'birthdate' => 'required|date'
        ]);
      
        if( !$validator->fails() ){
            $name = $request->input('name');
            $birthdate = $request->input('birthdate');
            
            $newPerson = new UnitPeople();
            $newPerson->id_unit = $id;
            $newPerson->name = $name;
            $newPerson->birthdate = $birthdate;
            $newPerson->save();
        }else{
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

}
