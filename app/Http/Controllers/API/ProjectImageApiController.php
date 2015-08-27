<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\UserService;
use \Input;

class ProjectImageApiController extends Controller {


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

        $images = $this->projectService->getProjectImages($projectId);

        return $images;
	}

	/**
	 * Add User to the project.
     *
     * @param  int  $projectId
     * @return Response
	 */
	public function store($projectId)
	{
		$result =  $this->projectService->saveImage($projectId,Input::instance());
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

	public function destroy($projectId,$imageId)
	{
        $result =  $this->projectService->deleteImage($projectId,$imageId);
        if ($result){
            return $result;
        }else {
            return response("There was an error. Please contact Administrator.",400);
        }
	}

}
