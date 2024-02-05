<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($project_id)
    {
        try {
            $tasks = Task::where('project_id', (int)$project_id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json(TaskResource::collection($tasks));
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $task = Task::create($data);

            return response()->json((new TaskResource($task))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function show(string $id)
    {
        try {
            $task = Task::find((int)$id);

            if (!$task)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);

            return response()->json((new TaskResource($task))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function update(Request $request, string $id)
    {
        $data = $request->all();

        try {
            $task = Task::find((int)$id);

            if (!$task)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);
            
            $task->update($data);

            return response()->json((new TaskResource($task))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function destroy(string $id)
    {
        try {
            $task = Task::find((int)$id);

            $task->delete();

            return response()->json(['result' => 'success']);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }


    public function start(Request $request, string $id) {
        try {
            $task = Task::find((int)$id);

            if (!$task)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);
            
            if (!$task->started_at) {
                $task->started_at = Carbon::now();
                $task->save();
            }

            return response()->json((new TaskResource($task))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    
    public function stop(Request $request, string $id) {
        try {
            $task = Task::find((int)$id);

            if (!$task)
                return response()->json(['message' => 'Не найдено записи с номером ' . $id], 404);
            
            if ($task->started_at) {
                $difference = Carbon::now()->getTimestamp() - Carbon::parse($task->started_at)->getTimestamp();
                $task->time += $difference;
                $task->started_at = null;
                $task->save();
            }

            return response()->json((new TaskResource($task))->resolve());
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
