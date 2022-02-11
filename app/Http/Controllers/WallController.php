<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Wall;
use App\Models\WallLike;

class WallController extends Controller
{
    public function getAll(){
        $array = ['error' => '','list' => []];

        $user = auth()->user();

        $walls = Wall::all();

        foreach($walls as $wallkey => $wallvalue){
            $walls[$wallkey]['likes'] = 0;
            $walls[$wallkey]['liked'] = false;

            $likes = WallLike::where('id_wall', $wallValue['id'])->count();
            $walls[$wallkey]['likes'] = $likes;

            $meLikes = WallLike::where('id_wall', $wallValue['id'])
                ->where('id_user', $user['id'])
                ->count();

            if($meLikes > 0){
                $walls[$wallkey]['liked'] = true;
            }
        }

        $array['list'] = $walls;

        return $array;
    }
}
