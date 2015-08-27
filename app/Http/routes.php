<?php

use Ramsey\Uuid\Uuid;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
\Blade::setContentTags('<%', '%>'); // for variables and all things Blade
\Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data

Route::get('/', 'WelcomeController@index');

Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::group([
        'middleware' => 'admin'
    ]
    , function () {
        Route::get('/admin', 'Admin\AdminController@index');
        Route::get('/admin/dashboard', 'Admin\AdminController@dashboard');
        Route::get('/admin/faculty', 'Admin\AdminController@faculty');
        Route::get('/admin/user', 'Admin\AdminController@user');
        Route::get('/admin/area', 'Admin\AdminController@area');
        Route::get('/admin/role', 'Admin\AdminController@role');
        Route::get('/admin/project', 'Admin\AdminController@project');
        Route::get('/admin/project-status', 'Admin\AdminController@projectStatus');
        Route::get('/admin/api-key', 'Admin\AdminController@apikey');

    });

    Route::get('/users', 'User\UserController@index');
    Route::get('/researcher', 'Researcher\ResearcherController@index');
    Route::get('/faculty', 'Faculty\FacultyController@index');
    Route::get('/university', 'University\UniversityController@index');


Route::group(['prefix' => 'api'], function () {

    //api for comment
    Route::get('comment/get-comment','API\ProjectCommentApiController@getComments');
    Route::post('comment/add-projectcomment','API\ProjectCommentApiController@addProjectComments');
    Route::post('comment/add-commentcomment','API\ProjectCommentApiController@addCommentComments');

    //api for faculty
    Route::get('faculty/projects','API\FacultyProjectApiController@getProjects');
    Route::get('faculty/get-project/{id}','API\FacultyProjectApiController@get');
    Route::post('faculty/submit-project/{id}','API\FacultyProjectApiController@submit');
    Route::post('faculty/reject-project/{id}','API\FacultyProjectApiController@rejectProject');

    //api for university
    Route::get('university/projects','API\UniversityProjectApiController@getProjects');
    Route::get('university/get-project/{id}','API\UniversityProjectApiController@get');
    Route::post('university/submit-project/{id}','API\UniversityProjectApiController@submit');
    Route::post('university/reject-project/{id}','API\UniversityProjectApiController@rejectProject');

    //api for researcher
    Route::get('researcher/projects','API\ResearcherProjectApiController@getProjects');
    Route::get('researcher/get-project/{id}','API\ResearcherProjectApiController@get');
    Route::post('researcher/update-project/{id}','API\ResearcherProjectApiController@update');
    Route::post('researcher/add-project','API\ResearcherProjectApiController@addProject');
    Route::post('researcher/submit-project/{id}','API\ResearcherProjectApiController@submit');

    //api for area
    Route::get('area', 'API\AreaApiController@index');
    Route::get('area/get/{id}', 'API\AreaApiController@getID');
    Route::post('area/add', 'API\AreaApiController@addArea');
    Route::get('area/update', 'API\AreaApiController@update');

    //api for published projects
    Route::get('publish/projects', 'API\PublishProjectApiController@getProjects');

    Route::resource('faculty', 'API\FacultyApiController');
    Route::resource('faculty.logo', 'API\FacultyLogoApiController');

    Route::post('faculty/{id}/saveLogo', 'Api\"FacultyApiController@saveLogo');

    Route::resource('faculty.user', 'API\FacultyUserApiController');

    Route::resource('user', 'API\UserApiController');
    Route::post('user/search', 'API\UserApiController@search');

    Route::resource('user.logo', 'API\UserLogoApiController');
    Route::resource('role', 'API\RoleApiController');

    Route::resource('project-status', 'API\ProjectStatusApiController');
    Route::resource('project', 'API\ProjectApiController');
    Route::resource('project.member', 'API\ProjectMemberApiController');
    Route::resource('project.image', 'API\ProjectImageApiController');
    Route::resource('project.youtube', 'API\ProjectYoutubeApiController');

    Route::resource('api-key', 'API\ApiKeyApiController');

    Route::get('project/{id}/previous-files', 'API\ProjectFileApiController@getPreviousFiles');
    Route::resource('project.file', 'API\ProjectFileApiController');
    Route::resource('project.status', 'API\ProjectProjectStatusApiController');




    Route::post('auth/login', 'API\AuthApiController@authenticate');
    Route::post('auth/logout', 'API\AuthApiController@unAuthenticate');
    Route::get('auth/user', 'API\AuthApiController@user');

    Route::get('chart/faculty-project', 'API\ChartApiController@facultyProjectChart');

});

Route::get('/img/{path}', function (League\Glide\Server $server, \Illuminate\Http\Request $request) {
    $server->outputImage($request);
})->where('path', '.*');

Route::get('/downloads/{name}/files/{path}', function ($name, $path) {
    $filePath = storage_path() . '/app/' . $path;
    return Response::download($filePath, $name);
})->where('path', '.*');

Route::get('/register', 'Guest\RegisterController@registerPage');

Route::get('test', function () {

    \App\Models\Project::reindex();

});

Route::post('tinymce-upload', function () {
    $uuid = Uuid::uuid4();
    $storage_path = "app/temp/";
    $destination_path = storage_path($storage_path);
    Input::file('file')->move($destination_path, $uuid);

    $url = "/img/temp/$uuid";
    $response = [
        'url' => $url,
        'base_url' => url()
    ];
    return $response;
});

