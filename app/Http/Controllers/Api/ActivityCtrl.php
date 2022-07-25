<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\Activity;

class ActivityCtrl extends Controller
{
    //Lấy toàn bộ hoạt động
    public function GetActivities(){
        $activities = Activity::all();
        return response()->json([
            'alert' => 200,
            'data' => $activities, 
        ]);
    }
}
