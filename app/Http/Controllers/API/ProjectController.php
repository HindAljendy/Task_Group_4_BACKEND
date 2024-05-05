<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectController extends Controller
{
    use ImageTrait, ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Project::all();
            return $this->customeResponse(ProjectResource::collection($projects), 'Success', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->responseJson(null, "Failed", 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        try {

            DB::beginTransaction();

            //store image path using ImageTrait Function
            $image_path = $this->storeImage($request->image, '/images/');

            $project = Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'year' => $request->year,
                'image' => $image_path,
                'category' => $request->category
            ]);
            DB::commit();
            return $this->customeResponse(new ProjectResource($project), 'Store Success', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->customeResponse(null, 'Store Failed', 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            return $this->customeResponse(new ProjectResource($project), 'Show Success', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Show Failed', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();
            $newData = [];

            if (isset($request->title)) {
                $newData['title'] = $request->title;
            }
            if (isset($request->description)) {
                $newData['description'] = $request->description;
            }
            if (isset($request->year)) {
                $newData['year'] = $request->year;
            }
            if (isset($request->image)) {

                //delete the old image using ImageTrait Functions
                $this->deleteImage($project->image, public_path());

                //save new image
                $image_path = $this->storeImage($request->image, '\\images\\');

                //add new image to list
                $newData['image'] = $image_path;
            }
            if (isset($request->category)) {
                $newData['category'] = $request->category;
            }
            $project->update($newData);

            DB::commit();
            return $this->customeResponse(new ProjectResource($project), 'Update Success', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);

            return $this->customeResponse(null, 'Update Failed', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            //delete the old image
            $this->deleteImage($project->image, public_path());

            //delete project
            $project->delete();
            return $this->customeResponse("", 'Delete Success', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Delete Failed', 500);
        }
    }
}
