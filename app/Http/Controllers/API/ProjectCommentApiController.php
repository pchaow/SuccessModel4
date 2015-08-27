<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Faculty;
use App\Models\Project;
use App\Services\FacultyService;
use App\Services\ProjectService;
use App\Services\ResearcherProjectService;
use App\Services\CommentProjectService;
use Illuminate\Http\Request;
use \Input;
use Vinelab\NeoEloquent\Tests\Functional\Relations\HyperMorphTo\Comment;

class ProjectCommentApiController extends Controller {


    function __construct(CommentProjectService $commentProjectService)
    {
        $this->commentProjectService = $commentProjectService;
    }

    public function getComments($id){

        return $this->commentProjectService->getCommentFromProject($id);

    }

    public function addProjectComment($projectId)
    {
      return $this->commentProjectService->addCommentToProject($projectId,Input::all());

    }

    public function addCommentComment($commentId)
    {
        return $this->commentProjectService->addCommentToComment($commentId,Input::all());

    }

    public function delete($id){
        return $this->commentProjectService->delete($id);
    }


}
