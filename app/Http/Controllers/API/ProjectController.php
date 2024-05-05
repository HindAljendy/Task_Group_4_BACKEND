<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectStoreRequest;

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
