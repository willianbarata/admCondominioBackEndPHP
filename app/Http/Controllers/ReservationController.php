<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;

class ReservationController extends Controller
{
    
    public function getReservations(){
        $array = ['error' => ''];
        $daysHelper = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        $areas = Area::where('allowed', 1)->get();

        $array['list'] = $areas;

        foreach($areas as $area){
            $dayList = explode(',', $area['days']);

            $dayGroups = [];

            $lastDay = intval(current($dayList));
            $dayGroups[] = $daysHelper[$lastDay];

            array_shift($dayList);

            $dayGroups[] = $daysHelper[end($dayList)];

            echo "Area: ".$area['title']."\n";
            print_r($dayGroups);
            echo "\n----------";
        }

        return $array;
    }

}
