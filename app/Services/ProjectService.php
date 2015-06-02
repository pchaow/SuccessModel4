<?php
namespace App\Services;

use App\Models\Project;
use App\Models\Faculty;
use App\Models\Logo;
use App\Models\ProjectStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rhumsaa\Uuid\Uuid;

/**
 * Created by PhpStorm.
 * ProjectRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */
class ProjectService extends Service
{

    var $withArr = ['faculty', 'createdBy', 'cover', 'logo', 'status'];

    function __construct(ProjectStatusService $projectStatusService)
    {
        $this->projectStatusService = $projectStatusService;
    }


    public function getAll()
    {
        return Project::with($this->withArr)->get();
    }

    public function get($id)
    {
        $project = Project::with($this->withArr)->find($id);
        return $project;
    }

    private function linkToStatus(Project $project, array $input)
    {
        if (isset($input['status'])) {
            $id = $input['status']['id'];
            $status = ProjectStatus::find($id);
            $project->status()->dissociate();
            $project->status()->associate($status)->save();
        }
    }

    private function  linkToUser(Project $project, array $input)
    {
        if (isset($input['created_by'])) {
            $id = $input['created_by']['id'];
            $user = User::find($id);
            $project->createdBy()->dissociate()->save();
            $project->createdBy()->associate($user)->save();

        } else {
            /* @var User $user */
            $user = $project->createdBy;
            $user = User::find($user->id);
            $user->createProject()->detach($project->id);
        }
    }

    private function linkToFaculty(Project $project, array $input)
    {
        if (isset($input['faculty'])) {
            $id = $input['faculty']['id'];
            $faculty = Faculty::find($id);
            $project->faculty()->dissociate();
            $project->faculty()->associate($faculty)->save();
        }

        return $project;
    }

    public function store(array $input)
    {

        $project = new Project();
        $project->fill($input);
        $project->save();
        $this->linkToFaculty($project, $input);
        $this->linkToStatus($project, $input);
        $this->linkToUser($project, $input);
        return $project;
    }

    public function save(array $input)
    {

        if (array_has($input, 'id')) {
            $id = $input['id'];
            /* @var Project $project */
            $project = Project::find($id);
            $project->fill($input);
            $project->save();
            $this->linkToFaculty($project, $input);
            $this->linkToStatus($project, $input);
            $this->linkToUser($project, $input);
            return $project;
        } else {
            return $this->store($input);
        }
    }

    public function create()
    {
        return new Project();
    }

    public function delete($id)
    {
        return [Project::find($id)->delete()];
    }

    public function saveLogo($id, Request $input)
    {
        /* @var Project $project */
        $project = $this->get($id);
        $uuid = Uuid::uuid4();
        $storage_path = "app/projects/$id/logo/";
        $destination_path = storage_path($storage_path);
        $input->file('file')->move($destination_path, $uuid);

        $logo = $this->getLogoFromModel($project);
        $logo->url = "/img/projects/$id/logo/$uuid";
        $project->logo()->save($logo);
        return $logo;
    }

    public function saveCover($id, Request $input)
    {
        /* @var Project $project */
        $project = $this->get($id);
        $uuid = Uuid::uuid4();
        $storage_path = "app/projects/$id/cover/";
        $destination_path = storage_path($storage_path);
        $input->file('file')->move($destination_path, $uuid);

        $logo = $this->getCoverFromModel($project);
        $logo->url = "/img/projects/$id/logo/$uuid";
        $project->logo()->save($logo);
        return $logo;
    }

    public function addMember($proejctId, array $input)
    {
        /* @var Faculty $faculty */
        $project = $this->get($proejctId);
        $user = User::find($input['id']);

        if ($user) {
            $project->members()->attach($user->id);
            return $user;
        } else {
            return null;
        }

    }

    public function deleteMember($proejctId, $userId)
    {
        /* @var Faculty $faculty */
        $project = $this->get($proejctId);
        $user = User::find($userId);

        if ($user) {
            $project->members()->detach([$user->id]);
            return $user;
        } else {
            return null;
        }
    }


}
