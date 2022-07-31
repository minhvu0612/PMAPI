<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $var = Str::random(5);
        // Nếu không tìm thấy team thì tạo team mới
        $team = new Team();
        $team->code = $var;
        $team->name = $request->name;
        $team->carry = 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $team->created_at = date("Y-m-d H:i:s");
        $team->updated_at = date("Y-m-d H:i:s");
        $team->save();
        // Thêm hoạt động
        $activity = new Activity();
        $activity->user_id = $request->user_id;
        $activity->teamcode = $var;
        $activity->state = "Create team ".$request->name;
        $activity->save();
        // Thêm thành viên vào team
        $arr = [];
        $arr = json_decode($request->arr);
        for ($x = 0; $x < count($arr); $x++){
            $uit = new Uit();
            $uit->teamcode = $var;
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
            'alert' => "success",
            'data' => $teams, 
        ]);
    }

    // Lấy dữ liệu tất cả các người dùng trong project
    public function GetUits($code){
        $uits = Uit::where('teamcode', $code)->get(); // Lấy tất cả các project
        return response()->json([
            'alert' => "success",
            'data' => $uits, 
        ]);
    }

    public function GetAllUits(){
        $uits = Uit::all(); // Lấy tất cả các project
        return response()->json([
            'alert' => "success",
            'data' => $uits, 
        ]);
    }

    // Lấy dữ liệu một team
    public function GetTeam($id){
        $team = Team::find($id); // Tìm Team theo mã Team
        return response()->json([
            'alert' => "success",
            'data' => $team, 
        ]);
    }

    // Cập nhật team
    public function UpdateTeam(Request $request)
    {
        $team = Team::where('code', $request->code)->value('name');
        if ($team != null){
            // Cập nhật team
            if ($team != $request->name){
                DB::table('teams')->where('code', $request->code)->update(['name' => $request->name]);
                // Thêm hoạt động
                $activity = new Activity();
                $activity->user_id = $request->user_id;
                $activity->teamcode = $request->code;
                $activity->state = "Update team "." ".$team." rename to ".$request->name;
                $activity->save();
                
            }
            // Xóa tất cả các thành viên trong team
            DB::table('userinteams')->where('teamcode', $request->code)->delete();
            // Thêm nhân viên vào team
            $arr = [];
            $arr = json_decode($request->arr);
            for ($x = 0; $x < count($arr); $x++){
                $uit = new Uit();
                $uit->teamcode = $request->code;
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

    // Xóa một team
    public function DeleteTeam($id){
        DB::table('teams')->delete($id); // Xóa team
        if (Project::where('team_id', $id)->exists()) {
            // Gửi thông báo team đã tồn tại
            DB:table('projects')->where('team_id', $id);
        }
        return response()->json([
            'alert' => "success",
        ]);
    }
}
