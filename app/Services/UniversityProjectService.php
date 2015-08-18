<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Faculty;
use App\Models\Logo;
use App\Models\ProjectStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rhumsaa\Uuid\Uuid;
use \Auth;


/**
 * Created by PhpStorm.
 * ProjectRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */
class UniversityProjectService extends ResearcherProjectService
{

    public function getUniversityStatusProjects()
    {

        $projects = Project::with(['createdBy', 'faculty','status'])->whereHas('status', function($q)
        {
            $q->where('key', '=', 'university');

        })->get();


        return $projects;
    }

    public function get($id){
        $project = Project::with(['createdBy', 'faculty','status'])->find($id);
        return $project;
    }

    public function submitProject($id,array $input){
        $project = Project::find($id);
        if($project){
            /* @var Project $project*/
            if($project->status->key =='university'){
                $this->linkToPublish($project,$input);
            }else{
                return \Response::json([
                    "error" => "There is something wrong, Please contact administrator."
                ],400);
            }

        }
    }
    private function linkToPublish(Project $project, array $input)
    {
        $published = ProjectStatus::where('key','=','published')->first();
        if($published){
            $project->status()->associate($published)->save();
        }
        return $project;
    }

    public function rejectProject($id,array $input){
        $project = Project::find($id);
        if ($project) {
            /* @var Project $project*/
            if($project->status->key == 'university'){
                $this->linkToFacultyStatus($project, $input);
            }else{
                return \Response::json([
                    "error" => "There is something wrong, Please contact administrator."
                ],400);
            }
        }
    }
}
