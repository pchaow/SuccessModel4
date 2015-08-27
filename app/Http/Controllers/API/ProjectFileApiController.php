<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\UserService;
use \Input;

class ProjectFileApiController extends Controller {


    public function __construct(ProjectService $projectService, UserService $userService){
        $this->projectService = $projectService;
    }

	/**
	 * Display a listing of the resource.
	 *
     * @param  int  $projectId
	 * @return Response
	 */
	public function index($projectId)
	{
        /* @var Project $project */

        $files = $this->projectService->getProjectFile($projectId);

        return $files;
	}

	/**
	 * Add User to the project.
     *
     * @param  int  $projectId
     * @return Response
	 */
	public function store($projectId)
	{
		$result =  $this->projectService->saveFile($projectId,Input::instance());
        if($result){
            return $result;
        }else {
            return response("There was an error. Please contact Administrator.",400);
        }
	}

    /**
     * Remove User form project
     * @param  int  $projectId
     * @return Response
     */

	public function destroy($projectId,$fileId)
	{
        $result =  $this->projectService->deleteFile($projectId,$fileId);
        if ($result){
            return $result;
        }else {
            return response("There was an error. Please contact Administrator.",400);
        }
	}

    public function getPreviousFiles($projectId){
        return $this->projectService->getPreviousFiles($projectId);
    }

}
