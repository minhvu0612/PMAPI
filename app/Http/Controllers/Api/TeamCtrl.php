<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// team model
use App\Models\Api\Team;
use App\Models\Api\Uit;
use App\Models\Api\Activity;

class TeamCtrl extends Controller
{
    // Tạo team mới
    public function CreateNewTeam(Request $request)
    {
        if (Team::where('name', '=', $request->name)->exists()) {
            // Gửi thông báo team đã tồn tại
            return response()->json([
                'alert' => "existed",
            ]);
        }
        // Nếu không tìm thấy team thì tạo team mới
        $team = new Team();
        $team->name = $request->name;
        $team->carry = 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $team->created_at = date("Y-m-d H:i:s");
        $team->updated_at = date("Y-m-d H:i:s");
        $team->save();
        // add activity
        $activity = new Activity();
        $activity->user_id = $request->user_id;
        $activity->team_id = $team->id;
        $activity->project_id = null;
        $activity->state = "Create team " + $request->name;
        $activity->save();
        // add user in team
        $arr = [];
        $arr = json_decode($request->arr);
        for ($x = 0; $x < count($arr); $x++){
            $uit = new Uit();
            $uit->team_id = $team->id;
            $uit->user_id = $arr[$x];
            $uit->save();
        }
        return response()->json([
            'alert' => "success",
        ]);
    }
    // Lấy dữ liệu tất cả các team
    public function GetTeams(){
        $teams = Team::all(); // Lấy tất cả các team
        return response()->json([
            'alert' => 200,
            'data' => $teams, 
        ]);
    }
    // Lấy dữ liệu một team
    public function GetTeam($id){
        $team = Team::find($id); // Tìm Team theo mã Team
        return response()->json([
            'alert' => 200,
            'data' => $team, 
        ]);
    }
    // Cập nhật team
    public function UpdateTeam(Request $request)
    {
        if (Team::where('name', '=', $request->name)->exists()) {
            // Nếu không tìm thấy team thì tạo team mới
            $team = new Team();
            $team->name = $request->name;
            $team->carry = 0;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $team->created_at = date("Y-m-d H:i:s");
            $team->updated_at = date("Y-m-d H:i:s");
            $team->save();
            // add activity
            $activity = new Activity();
            $activity->user_id = $request->user_id;
            $activity->team_id = $team->id;
            $activity->project_id = null;
            $activity->state = "Update team " + $request->name;
            $activity->save();
            // add user in team
            $arr = [];
            $arr = json_decode($request->arr);
            for ($x = 0; $x < count($arr); $x++){
                $uit = new Uit();
                $uit->team_id = $team->id;
                $uit->user_id = $arr[$x];
                $uit->save();
            }
            return response()->json([
                'alert' => "success",
            ]);
        }
        return response()->json([
            'alert' => "not existed",
        ]);
        
    }
}
