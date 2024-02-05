<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectBriefResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::withSum('tasks', 'time')
                ->withCount('tasks')
                ->withCount(['tasks as active_tasks_count' => function ($query) {
                                $query->whereNotNull('started_at');
                            }])
                ->get();

            return response()->json(ProjectBriefResource::collection($projects));
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $project = Project::create($data);

            return response()->json(['id' => $project->id]);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function show(string $id)
    {
        try {
            $project = Project::with(['tasks'])
                ->withSum('tasks', 'time')
                ->find((int)$id);

            if (!$project)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);

            return response()->json((new ProjectResource($project))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function update(Request $request, string $id)
    {
        $data = $request->all();

        try {
            $project = Project::find((int)$id);

            if (!$project)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);
            
            $project->update($data);

            return response()->json(['id' => $project->id]);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function destroy(string $id)
    {
        try {
            $project = Project::find((int)$id);

            $project->delete();

            return response()->json(['result' => 'success']);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
