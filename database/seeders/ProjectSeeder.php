<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'API REST de Prueba',
                'description' => 'Proyecto principal para la prueba técnica',
                'status' => 'active',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Sistema de Inventario',
                'description' => 'Control de productos y stock',
                'status' => 'inactive',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Gestión de Usuarios',
                'description' => 'Proyecto para manejo de usuarios y roles',
                'status' => 'active',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
