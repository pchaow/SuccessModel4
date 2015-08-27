<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\UserService;
use \Input;

class ProjectYoutubeApiController extends Controller {


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

        $youtubes = $this->projectService->getYoutube($projectId);

        return $youtubes;
	}

	/**
	 * Add User to the project.
     *
     * @param  int  $projectId
     * @return Response
	 */
	public function store($projectId)
	{
		return $this->projectService->addYoutube($projectId,Input::all());
	}

    /**
     * Remove User form project
     * @param  int  $projectId
     * @return Response
     */

	public function destroy($projectId,$youtubeId)
	{
        return $this->projectService->deleteYoutube($projectId,$youtubeId);
	}

}
