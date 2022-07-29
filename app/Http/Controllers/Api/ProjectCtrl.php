<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Api\Project;

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

        // Nếu không tìm thấy project thì tạo project mới
        $project = new Project();
        $project->name = $request->name;
        $project->content = $request->description;
        $project->deadline = $request->deadline;
        $project->team_id = $request->team_id;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $project->created_at = date("Y-m-d H:i:s");
        $project->updated_at = date("Y-m-d H:i:s");
        $project->save();

        // Cập nhật thông báo 
        DB::table('teams')->where('id', $request->team_id)->update(array('carry' => 1));

        // Thêm hoạt động tạo team
        $activity = new Activity();
        $activity->user_id = $request->user_id;
        $activity->team_id = null;
        $activity->project_id = $project->id;
        $activity->state = "Create project " + $request->name;
        $activity->save();
        return response()->json([
            'alert' => "success",
        ]);
    }

    // Lấy dữ liệu tất cả các project
    public function GetProjects(){
        $projects = Project::all(); // Lấy tất cả các project
        return response()->json([
            'alert' => 200,
            'data' => $projects, 
        ]);
    }

    // Lấy dữ liệu một project
    public function GetProject($id){
        $project = Project::find($id); // Tìm project theo mã project
        return response()->json([
            'alert' => 200,
            'data' => $project, 
        ]);
    }

    // Cập nhật project
    public function UpdateProject(Request $request)
    {
        $project = Project::where('name', '=', $request->name)->get();// Lấy project theo tên
        if ($project != null) { // Nếu project tồn tại trong database
            // Nếu không tìm thấy project thì tạo project mới
            $project->name = $request->name;
            $project->content = $request->description;
            $project->startline = $request->startline;
            $project->deadline = $request->deadline;
            $project->team_id = $request->team_id;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $project->created_at = date("Y-m-d H:i:s");
            $project->updated_at = date("Y-m-d H:i:s");
            $project->save();

            // Thêm hoạt động cập nhật project
            $activity = new Activity();
            $activity->user_id = $request->user_id;
            $activity->team_id = null;
            $activity->project_id = $project->id;
            $activity->state = "Update project " + $request->name;
            $activity->save();

            // Trả về phản hồi từ 
            return response()->json([
                'alert' => "success",
            ]);
        }
        // Nếu project không tồn tại trong database thì trả về phản hòi là không tồn tại
        return response()->json([
            'alert' => "not existed",
        ]);
    }
}
