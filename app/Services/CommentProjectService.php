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
class CommentProjectService extends ProjectService
{
    public  function  getCommentFromProject($id){

        $project = Project::find($id);
        if($project){
            $comments = Comment::all('*')->get($id);

            return $comments;
            }
        }

    public function addCommentToProject($id,array $input){
        $project = Project::find($id);
        $mainComment = new Comment();
        $mainComment->fill($input);

        $project->comments()->save($mainComment);
        $this->linkToCurrentUser($mainComment);

        return $mainComment;
    }


    private function  linkToCurrentUser(Comment $comment)
    {

        $user = Auth::user();
        if($user){

            $comment->createdBy()->associate($user)->save();
        }

        return $comment;
    }

    public function addCommentToComment($id,array $input){
        $comments = Comment::find($id);
        $comment = new Comment();
        $comment->fill($input);

        $comments->comments()->save($comment);
        $this->linkToCurrentUser($comment);

        return $comment;
    }

    public function delete($id){
        return Comment::find($id)->delete();
    }
}
