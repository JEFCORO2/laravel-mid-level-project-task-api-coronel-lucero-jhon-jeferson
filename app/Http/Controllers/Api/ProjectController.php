<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Listar proyectos con filtros dinámicos",
     *     tags={"Projects"},
     *     @OA\Parameter(name="status", in="query", description="Filtrar por estado (active, inactive)", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="name", in="query", description="Buscar por nombre", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="from", in="query", description="Fecha inicio rango (YYYY-MM-DD)", required=false, @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="to", in="query", description="Fecha fin rango (YYYY-MM-DD)", required=false, @OA\Schema(type="string", format="date")),
     *     @OA\Response(response=200, description="Lista de proyectos paginada")
     * )
     */
    public function index(Request $request)
    {
        $projects = Project::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->name, fn($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->from && $request->to, fn($q) => 
                $q->whereBetween('created_at', [$request->from, $request->to])
            )
            ->paginate(10);

        return response()->json($projects);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Crear un nuevo proyecto",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","status"},
     *             @OA\Property(property="name", type="string", example="Proyecto API"),
     *             @OA\Property(property="description", type="string", example="Proyecto de ejemplo"),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Proyecto creado correctamente")
     * )
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return response()->json([
            'message' => 'Proyecto creado correctamente',
            'data' => $project
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Mostrar detalle de un proyecto",
     *     tags={"Projects"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del proyecto", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Detalle del proyecto")
     * )
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Actualizar un proyecto existente",
     *     tags={"Projects"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del proyecto", @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","status"},
     *             @OA\Property(property="name", type="string", example="Proyecto Actualizado"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada"),
     *             @OA\Property(property="status", type="string", example="inactive")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Proyecto actualizado correctamente")
     * )
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return response()->json([
            'message' => 'Proyecto actualizado correctamente',
            'data' => $project
        ]);
    }
    
    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Eliminar un proyecto",
     *     tags={"Projects"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del proyecto", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Proyecto eliminado correctamente")
     * )
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Proyecto eliminado correctamente'
        ]);
    }
}
