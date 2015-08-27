<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\UserService;
use \Input;

class ProjectMemberApiController extends Controller {


    public function __construct(ProjectService $projectService, UserService $userService){
        $this->projectService = $projectService;
        $this->userService = $userService;
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
        $project = $this->projectService->get($projectId);
        $users = $project->members()->with('logo')->get();

        return $users;
	}

	/**
	 * Add User to the project.
     *
     * @param  int  $projectId
     * @return Response
	 */
	public function store($projectId)
	{
        $project = $this->projectService->get($projectId);
		$result =  $this->projectService->addMember($projectId, Input::all());
        if ($result){
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

	public function destroy($projectId,$userId)
	{
        $result =  $this->projectService->deleteMember($projectId, $userId);
        if ($result){
            return $result;
        }else {
            return response("There was an error. Please contact Administrator.",400);
        }
	}

}
