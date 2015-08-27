<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Faculty;
use App\Models\Logo;
use App\Models\ProjectStatus;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use \Auth;


/**
 * Created by PhpStorm.
 * ProjectRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */
class ResearcherProjectService extends ProjectService
{


    public function getProjects()
    {
        $projects = \App\Models\Project::with(['createdBy', 'faculty','status'])->get();

        $fil_projects = [];

        foreach ($projects as $project) {
            if ($project->createdBy) {
                if ($project->createdBy->id == Auth::user()->id) {
                        array_push($fil_projects, $project);
                }
            }
        }

        return $fil_projects;
    }
    public function get($id){
        $project = Project::with(['createdBy', 'faculty','status'])->find($id);
        return $project;
    }

    public function addProject(array $input){
        $project = new Project();
        $project->fill($input);
        $project->save();
        $this->linkToCurrentUser($project, $input);
        $this->linkToFaculty($project, $input);
        $this->linkToDraftStatus($project, $input);

        return $project;
    }

    protected  function linkToDraftStatus(Project $project, array $input)
    {
        $draft = ProjectStatus::where('key','=','draft')->first();
        if($draft){
            $project->status()->associate($draft)->save();
        }
        return $project;
    }

    private function  linkToCurrentUser(Project $project, array $input)
    {

        $user = Auth::user();

        if($user){

            $project->createdBy()->associate($user)->save();
        }

        return $project;
    }

//    private function  linkToCurrentUserSuggestion(Suggestion $suggestion, array $input)
//    {
//
//        $user = Auth::user();
//
//        if($user){
//
//            $suggestion->createdBy()->associate($user)->save();
//        }
//
//        return $suggestion;
//    }

    private function linkToFaculty(Project $project, array $input)
    {
        $faculty = $project->createdBy->faculty;
        if($faculty){
            $project->faculty()->associate($faculty)->save();
        }

        return $project;
    }

    public function submitProject($id,array $input){
        $project = Project::find($id);
        if($project){
            /* @var Project $project*/
            //return $project->status;
            if($project->status->key =='draft'){
                $this->linkToFacultyStatus($project,$input);
                $this->linkToSuggestion($project,$input);
            }else{
                return \Response::json([
                    "error" => "There is something wrong, Please contact administrator."
                ],400);
            }
        }
    }

    protected  function linkToFacultyStatus(Project $project, array $input)
    {
        $faculty = ProjectStatus::where('key','=','faculty')->first();
        if($faculty){
            $project->status()->associate($faculty)->save();
        }
        return $project;
    }

    public function delete($id){
        return Project::find($id)->delete();
    }

    protected function linkToSuggestion($project,array $input){
        //มีการตรวจสอบก่อนว่ามีคำแนะนำรึเปล่า


        if(isset($input['suggestion'])){
            $suggestion = new Suggestion();
            $suggestion->fill($input);
            $project->suggestion()->save($suggestion);
            //$this->linkToCurrentUserSuggestion($suggestion, $input);
        }

        return $project;
    }

    public function update(array $input){
        if(array_has($input,'id')){
            $id = $input['id'];
            /* @var Project $project */
            $project = Project::find($id);
            $project->fill($input);
            $project->save();

            return $project;
        }
    }

}
