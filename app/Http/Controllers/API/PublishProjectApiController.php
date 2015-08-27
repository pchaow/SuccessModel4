<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Faculty;
use App\Models\Project;
use App\Services\FacultyProjectService;
use App\Services\FacultyService;
use App\Services\ProjectService;
use App\Services\PublishProjectService;
use App\Services\ResearcherProjectService;
use App\Services\UniversityProjectService;
use Illuminate\Http\Request;
use \Input;

class PublishProjectApiController extends Controller {


    function __construct(PublishProjectService $publishProjectService)
    {
        $this->publishProjectService = $publishProjectService;
    }

    public function getProjects()
    {
        return $this->publishProjectService->PublishProject();
    }

}
