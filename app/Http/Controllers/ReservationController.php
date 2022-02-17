<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Area;

class ReservationController extends Controller
{
    
    public function getReservations(){
        $array = ['error' => '', 'list' => []];
        $daysHelper = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        $areas = Area::where('allowed', 1)->get();

        $array['list'] = $areas;

        foreach($areas as $area){
            $dayList = explode(',', $area['days']);

            $dayGroups = [];

            $lastDay = intval(current($dayList));
            $dayGroups[] = $daysHelper[$lastDay];

            array_shift($dayList);

            foreach($dayList as $day){
                if(intval($day) != $lastDay+1){
                    $dayGroups[] = $daysHelper[$lastDay];
                    $dayGroups[] = $daysHelper[$day];
                }
                $lastDay = intval($day);
            }
            
            $dayGroups[] = $daysHelper[end($dayList)];

            $dates = '';
            $close = 0;
            foreach($dayGroups as $group){
                if($close === 0){
                    $dates .= $group;
                }else{
                    $dates .= '-'.$group.',';
                }

                $close = 1 - $close;
            }

            $dates = explode(',', $dates);
            array_pop($dates);

            $start = date('H:i', strtotime($area['start_time']));
            $end = date('H:i', strtotime($area['end_time']));

            foreach($dates as $dKey => $dValue){
                $dates[$dKey] .= ' '.$start.' às '.$end;
            }

            $dayGroups[] = $daysHelper[end($dayList)];

            $array['list'][] = [
                'id' => $area['id'],
                'cover' => asset('storage/'.$area['cover']),
                'title' => $area['title'],
                'dates' => $dates
            ];
        }

        return $array;
    }

}
