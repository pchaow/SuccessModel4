<?php
namespace App\Services;

use App\Models\File;
use App\Models\Image;
use App\Models\Project;
use App\Models\Faculty;
use App\Models\Logo;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use \Auth;


/**
 * Created by PhpStorm.
 * ProjectRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */
class ProjectService extends Service
{

    var $withArr = [
        'faculty','current_file', 'createdBy', 'cover', 'logo', 'status','createdBy'
    ];

    function __construct(ProjectStatusService $projectStatusService)
    {
        $this->projectStatusService = $projectStatusService;
    }


    public function getAll()
    {
        return Project::with(['createdBy', 'faculty','status'])->get();
        //return Project::with($this->withArr)->orderBy('created_at','desc')->get();
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
            if($user){
                $user = User::find($user->id);
                $user->createProject()->detach($project->id);
            }

        }
    }

    private function linkToFaculty(Project $project, array $input)
    {
        if (isset($input['faculty'])) {
            $id = $input['faculty']['id'];
            $faculty = Faculty::find($id);
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

    public function getProjectImages($projectId){
        /* @var Project $project */
        $project = Project::find($projectId);
        $images = $project->images()->orderBy('created_at','asc')->get();
        return $images;
    }

    public function getProjectFile($projectId){
        /* @var Project $project */
        $project = Project::find($projectId);
        $files = $project->current_file;
        return $files;
    }

    public function getPreviousFiles($projectId){
        /* @var Project $project */
        $project = Project::find($projectId);
        $files = $project->files()->orderBy('created_at','desc')->get();
        return $files;
    }

    public function saveFile($id,Request $input){

        /* @var Project $project */
        $project = $this->get($id);
        $uuid = Uuid::uuid4();
        $storage_path = "app/projects/$id/files/";
        $destination_path = storage_path($storage_path);
        $input->file('file')->move($destination_path, $uuid);

        $origin_name = $input->file('file')->getClientOriginalName();
        $origin_ext = $input->file('file')->getClientOriginalExtension();
        $origin_mime = $input->file('file')->getClientMimeType();

        $file = new File();
        $file->url = "/files/projects/$id/files/$uuid";
        $file->origin_name = $origin_name;
        $file->origin_ext = $origin_ext;
        $file->mime_type = $origin_mime;
        $oldFile = $project->current_file()->first();
        if($oldFile != null){
            $project->files()->save($oldFile);
        }

        $project->current_file()->save($file);

        return $file;
    }

    public function saveImage($id, Request $input)
    {
        /* @var Project $project */
        $project = $this->get($id);
        $uuid = Uuid::uuid4();
        $storage_path = "app/projects/$id/images/";
        $destination_path = storage_path($storage_path);
        $input->file('file')->move($destination_path, $uuid);

        $image = new Image();
        $image->url = "/img/projects/$id/images/$uuid";
        $project->images()->save($image);
        return $image;
    }

    public function deleteImage($projectId,$imageId)
    {
        /* @var Project $project */
        /* @var Image $image */
        $project = Project::find($projectId);
        $image = Image::find($imageId);
        $project->images()->detach($image->id);
        if($image->delete()){
            return $image;
        }
        return response("Cannot Delete image",400);
    }

    public function deleteFile($projectId,$fileId)
    {
        /* @var Project $project */
        /* @var File $file */
        $project = Project::find($projectId);
        $file = File::find($fileId);
        $project->files()->detach($file->id);
        if($file->delete()){
            return $file;
        }
        return response("Cannot Delete File",400);
    }

    public function getYoutube($projectId){
        return Project::find($projectId)->youtubes()->orderBy('created_at','desc')->get();
    }

    public function addYoutube($projectId,array $input){
        /* @var Project $project */
        $youtube = new Youtube();
        $youtube->fill($input);

        $project = Project::find($projectId);
        $project->youtubes()->save($youtube);

        return $youtube;
    }

    public function deleteYoutube($projectId,$youtubeId){

        /* @var Project $project */
        $project = Project::find($projectId);
        $youtube = Youtube::find($youtubeId);
        $project->youtubes()->detach($youtube->id);
        return [$youtube->delete()];
    }


}
