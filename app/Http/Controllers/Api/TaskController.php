<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Listar tareas con filtros dinámicos",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="status", in="query", description="Filtrar por estado (pending, in_progress, done)", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="priority", in="query", description="Filtrar por prioridad (low, medium, high)", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="due_date", in="query", description="Filtrar por fecha de entrega", required=false, @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="project_id", in="query", description="Filtrar por ID de proyecto", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Lista de tareas paginada")
     * )
     */

    public function index(Request $request)
    {
        $tasks = Task::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
            ->when($request->due_date, fn($q) => $q->whereDate('due_date', $request->due_date))
            ->when($request->project_id, fn($q) => $q->where('project_id', $request->project_id))
            ->paginate(10);

        return response()->json($tasks);
    }

        /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Crear nueva tarea",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"project_id","title","status","priority","due_date"},
     *             @OA\Property(property="project_id", type="string", example="uuid-proyecto"),
     *             @OA\Property(property="title", type="string", example="Configurar entorno"),
     *             @OA\Property(property="description", type="string", example="Instalar dependencias"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="priority", type="string", example="high"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-08-25")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Tarea creada correctamente")
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return response()->json([
            'message' => 'Tarea creada correctamente',
            'data' => $task
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Mostrar detalle de una tarea",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID de la tarea", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Detalle de la tarea")
     * )
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Actualizar una tarea",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID de la tarea", @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","status","priority","due_date"},
     *             @OA\Property(property="title", type="string", example="Configurar entorno actualizado"),
     *             @OA\Property(property="description", type="string", example="Actualizar dependencias"),
     *             @OA\Property(property="status", type="string", example="in_progress"),
     *             @OA\Property(property="priority", type="string", example="medium"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-08-30")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Tarea actualizada correctamente")
     * )
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'message' => 'Tarea actualizada correctamente',
            'data' => $task
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Eliminar una tarea",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID de la tarea", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Tarea eliminada correctamente")
     * )
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Tarea eliminada correctamente'
        ]);
    }
}
