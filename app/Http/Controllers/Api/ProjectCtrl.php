<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Api\Project;
use App\Models\Api\ManageProject;
use App\Models\Api\Rank;

class ProjectCtrl extends Controller
{
    // Tạo project mới
    public function CreateNewProject(Request $request)
    {
        if (Project::where('name', '=', $request->name)->exists()) {
            // Gửi thông báo project đã tồn tại
            return response()->json([
                'alert' => "existed",
            ]);
        }
        $var = Str::random(7);
        // Nếu không tìm thấy project thì tạo project mới
        $project = new Project();
        $project->code = $var;
        $project->name = $request->name;
        $project->content  = $request->description;
        $project->startline = $request->startline;
        $project->deadline = $request->deadline;
        $project->time = $request->time;
        $project->state = 0;
        $project->teamcode = $request->teamcode;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $project->created_at = date("Y-m-d H:i:s");
        $project->updated_at = date("Y-m-d H:i:s");
        $project->save();
        // Cập nhật thông báo 
        DB::table('teams')->where('code', $request->teamcode)->update(array('carry' => 1));
        // Thêm hoạt động tạo team
        $activity = new ManageProject();
        $activity->user_id = $request->user_id;
        $activity->projectcode = $var;
        $activity->state = "Create project ".$request->name;
        $activity->save();
        return response()->json([
            'alert' => "success",
        ]);
    }

    // Lấy dữ liệu tất cả các project
    public function GetProjects(){
        $projects = Project::all(); // Lấy tất cả các project
        return response()->json([
            'alert' => "success",
            'data' => $projects, 
        ]);
    }

    // Lấy dữ liệu một project
    public function GetProject($id){
        $project = Project::find($id); // Tìm project theo mã project
        return response()->json([
            'alert' => "success",
            'data' => $project, 
        ]);
    }

    // Hoàn thành project
    public function CompleteProject(Request $request){
        DB::table('projects')->where('code', $request->code)->update(['state' => 1]);
        $project = Project::where('code', $request->code)->first();
        if ($request->arctime > $project->time){
            $rank = new Rank();
            $rank->teamcode = $project->teamcode;
            $rank->vote = -5;
            $rank->save();
        }
        if ($request->arctime == $project->time){
            $rank = new Rank();
            $rank->teamcode = $project->teamcode;
            $rank->vote = 3;
            $rank->save();
        }
        if ($request->arctime < $project->time){
            $rank = new Rank();
            $rank->teamcode = $project->teamcode;
            $rank->vote = 5;
            $rank->save();
        }
        return response()->json([
            'alert' => "success", 
        ]);
    }

    // xác nhận hoàn thành project
    public function ConfirmProject(Request $request){
        $project = Project::where('code', $request->code)->first();
        DB::table('projects')->where('code', $request->code)->update(['state' => 2]);
        DB::table('teams')->where('code', $project->teamcode)->update(array('carry' => 0));
        return response()->json([
            'alert' => "success", 
        ]);
    }

    // Cập nhật project
    public function UpdateProject(Request $request)
    {
        $ck = Project::where('code', $request->code)
                    ->where('content', $request->description)
                    ->where('startline', $request->startline)
                    ->where('deadline', $request->deadline)
                    ->where('teamcode', $request->teamcode)
                    ->first();
        if ($ck == null){ 
            $project = Project::where('code', $request->code)->first();
            if ($project != null){
                // Cập nhật team đảm nhiệm
                DB::table('teams')->where('code', $project->teamcode)->update(array('carry' => 0));
                DB::table('teams')->where('code', $request->teamcode)->update(array('carry' => 1));
                // Cập nhật project
                DB::table('projects')->where('code', $request->code)
                ->update([
                      'content' => $request->description,
                      'startline' => $request->startline,
                      'deadline' => $request->deadline,
                      'teamcode' => $request->teamcode,
                      'time' => $request->time 
                    ]);
                // Thêm hoạt động cập nhật team
                $activity = new ManageProject();
                $activity->user_id = $request->user_id;
                $activity->projectcode = $request->code;
                $activity->state = "Update project ".$project->name;
                $activity->save();
                return response()->json([
                    'alert' => "success",
                ]);
            }
            else{
                return response()->json([
                    'alert' => "not existed",
                ]); 
            }
        }
        return response()->json([
            'alert' => "not changed",
        ]);
    }
}
