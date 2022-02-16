<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;

class ReservationController extends Controller
{
    
    public function getReservations(){
        $array = ['error' => ''];

        $areas = Area::where('allowed', 1)->get();

        $array['list'] = $areas;

        

        return $array;
    }

}
