<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Faculty;
use App\Models\Project;
use App\Services\FacultyProjectService;
use App\Services\FacultyService;
use App\Services\ProjectService;
use App\Services\ResearcherProjectService;
use App\Services\UniversityProjectService;
use Illuminate\Http\Request;
use \Input;

class UniversityProjectApiController extends Controller {


    function __construct(UniversityProjectService $universityProjectService)
    {
        $this->universityProjectService = $universityProjectService;
    }

    public function getProjects()
    {
        return $this->universityProjectService->getUniversityStatusProjects();
    }

    public function get($id){
        return $this->universityProjectService->get($id);
    }

    public function submit($id){
        return $this->universityProjectService->submitProject($id,Input::all());
    }
    public function rejectProject($id){
        return $this->universityProjectService->rejectProject($id,Input::all());
    }

}
