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
class FacultyProjectService extends ProjectService
{


    public function getProjects()
    {
        $user = Auth::user();
        $fil_projects = [];
        if($user){
            /* @var User $user */
            /* @var Faculty $faculty */
            $faculty = $user->faculty;
            if($faculty){

                $projects = $faculty->projects()->with(['status','createdBy'])->get();
                foreach ($projects as $project) {
                    /* @var Project $project */
                        if ($project->status->key != 'draft'){
                            array_push($fil_projects, $project);
                        }
                    }
                }
            }
        return $fil_projects;
    }
    public function acceptProject($id,array $input){
        $project = Project::find($id);
        if($project){
            $this->linkToUniversityStatus($project,$input);
        }
    }
    private function linkToUniversityStatus(Project $project, array $input)
    {
        $university = ProjectStatus::where('key','=','university');
        if($university){
            $project->status()->associate($university)->save();
        }
        return $project;
    }

    public function rejectProject($id,array $input){
        $project = Project::find($id);
        if($project){
            $this->linkToDraftStatus($project,$input);
        }
    }

}