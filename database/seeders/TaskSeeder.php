<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener algunos proyectos creados por el ProjectSeeder
        $projects = Project::all();

        foreach ($projects as $project) {
            Task::create([
                'id' => (string) Str::uuid(),
                'project_id' => $project->id,
                'title' => 'Configurar entorno para ' . $project->name,
                'description' => 'Instalar dependencias y preparar el entorno de desarrollo',
                'status' => 'pending',
                'priority' => 'high',
                'due_date' => now()->addDays(7)->toDateString(),
            ]);

            Task::create([
                'id' => (string) Str::uuid(),
                'project_id' => $project->id,
                'title' => 'Documentar ' . $project->name,
                'description' => 'Crear documentación inicial del proyecto',
                'status' => 'in_progress',
                'priority' => 'medium',
                'due_date' => now()->addDays(14)->toDateString(),
            ]);

            Task::create([
                'id' => (string) Str::uuid(),
                'project_id' => $project->id,
                'title' => 'Pruebas iniciales en ' . $project->name,
                'description' => 'Ejecutar pruebas unitarias y de integración',
                'status' => 'done',
                'priority' => 'low',
                'due_date' => now()->addDays(3)->toDateString(),
            ]);
        }
    }
}
