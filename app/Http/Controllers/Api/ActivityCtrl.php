<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\Activity;
use App\Models\Api\ManageProject;

class ActivityCtrl extends Controller
{
    //Lấy toàn bộ hoạt động
    public function GetActivities(){
        $activities = Activity::all();
        return response()->json([
            'alert' => "success",
            'data' => $activities, 
        ]);
    }

    
    public function GetActProject(){
        $pms = ManageProject::all();
        return response()->json([
            'alert' => "success",
            'data' => $pms, 
        ]);
    }
}
