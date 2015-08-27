<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Faculty;
use App\Models\Project;
use App\Services\FacultyProjectService;
use App\Services\FacultyService;
use App\Services\ProjectService;
use App\Services\ResearcherProjectService;
use Illuminate\Http\Request;
use \Input;

class FacultyProjectApiController extends Controller {


    function __construct(FacultyProjectService $facultyProjectService)
    {
        $this->facultyProjectService = $facultyProjectService;
    }

    public function getProjects()
    {
        return $this->facultyProjectService->getProjects();
    }

    public function get($id){
        return $this->facultyProjectService->get($id);
    }

    public function submit($id){
        return $this->facultyProjectService->submitProject($id,Input::all());
    }
    public function rejectProject($id){
        return $this->facultyProjectService->rejectProject($id,Input::all());
    }

}
