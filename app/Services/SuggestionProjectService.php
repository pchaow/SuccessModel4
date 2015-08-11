<?php
namespace App\Services;

use App\Models\Comment;
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
class SuggestionProjectService extends ProjectService
{
    public  function  getSuggestionFromProject($id){

        $project = Project::find($id);
        if($project){
            $Suggestion = Suggestion::with($this->withArr)->get();

            return $Suggestion;
            }
        }

    public function addSuggestionToProject($id,array $input){
        $project = $this->get($id);
        $suggestion = new Suggestion();
        $suggestion->fill($input);

        $project->suggestions()->save($suggestion);
        $this->linkToCurrentUser($suggestion);

        return $suggestion;
    }


    private function  linkToCurrentUser(Suggestion $suggestion)
    {

        $user = Auth::user();
        if($user){

            $suggestion->createdBy()->associate($user)->save();
        }

        return $suggestion;
    }

    public function delete($id){
        return Suggestion::find($id)->delete();
    }
}
