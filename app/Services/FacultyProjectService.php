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
class FacultyProjectService extends ResearcherProjectService
{

    public function getProjects()
    {
        $user = Auth::user();
        $fil_projects = [];
            /* @var User $user */
            /* @var Faculty $faculty */
            $faculty = $user->faculty;
            if($faculty){
                $projects = Project::with(['createdBy', 'faculty','status'])->whereHas('status', function($q)
                {
                    $q->where('key', '=', 'faculty');
                })->whereHas('faculty',function($q) use ($faculty)
                {
                    $q->where('name_th', '=', $faculty->name_th);
                })->get();

                return $projects;
            }

        return [];
    }

    public function get($id){
        $project = Project::with(['createdBy', 'faculty','status'])->find($id);
        return $project;
    }

    public function submitProject($id, array $input)
    {
        $project = Project::find($id);
        if ($project) {
            /* @var Project $project*/
            if($project->status->key =='faculty'){
                $this->linkToUniversityStatus($project, $input);
                $this->linkToSuggestion($project, $input);
                //ใส่suggesion
            }else{
                return \Response::json([
                    "error" => "There is something wrong, Please contact administrator."
                ],400);
            }
        }
    }

    private function linkToUniversityStatus(Project $project, array $input)
    {
        $university = ProjectStatus::where('key','=','university')->first();
        if($university){
            $project->status()->associate($university)->save();
        }
        return $project;
    }

    public function rejectProject($id, array $input)
    {
        $project = Project::find($id);
        if ($project) {
            /* @var Project $project*/
            if($project->status->key == 'faculty'){
                $this->linkToDraftStatus($project, $input);
                $this->linkToSuggestion($project, $input);
                //ใส่suggesion
            }else{
                return \Response::json([
                    "error" => "There is something wrong, Please contact administrator."
                ],400);
            }
        }
    }



}