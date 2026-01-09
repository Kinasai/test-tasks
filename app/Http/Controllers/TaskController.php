<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        //POST /api/tasks

        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

            Task::query()->create($validated);

            return response()->json([
                'success' => true,
                'message' => "Task created",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        //PUT /api/tasks
        try {
            $validated = $request->validate([
                'title' => ['sometimes', 'string', 'max:255'],
                'description' => ['sometimes', 'string', 'max:255'],
                'status' => ['sometimes', Rule::enum(TaskStatus::class)],
            ]);

            $task = Task::query()->findOrFail($id);
            $task->update($validated);

            return response()->json([
                'success' => true,
                'message' => "Task updated successfully",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function index(Request $request)
    {
        //GET /api/tasks
        $tasks = Task::query()->orderBy('created_at', 'desc')->paginate(20);

        return TaskResource::collection($tasks)
            ->additional(['success' => true])
            ->response()
            ->getData(true);

    }
    public function show(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        //GET /api/tasks/{id}
        try {
            $task = Task::query()->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => TaskResource::make($task)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy(Request $request, $id) {
        //DELETE /api/tasks/{id}

        try {
            $task = Task::query()->findOrFail($id);

            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

}
