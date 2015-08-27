<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Faculty;
use App\Models\Project;
use App\Services\FacultyService;
use App\Services\ProjectService;
use App\Services\ResearcherProjectService;
use Illuminate\Http\Request;
use \Input;

class ResearcherProjectApiController extends Controller {


    function __construct(ResearcherProjectService $researcherProjectService)
    {
        $this->researcherProjectService = $researcherProjectService;
    }

    public function addProject()
    {
        return $this->researcherProjectService->addProject(Input::all());
    }

    public function getProjects(){
        return $this->researcherProjectService->getProjects();
    }

    public function submit($id){
        return $this->researcherProjectService->submitProject($id,Input::all());
    }

    public function delete($id){
        return $this->researcherProjectService->delete($id);
    }
    public function get($id){
        return $this->researcherProjectService->get($id);
    }

    public function update($id){
        return $this->researcherProjectService->update(Input::all());

    }
}
