<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'projects';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
    ];

    // Relación: un proyecto tiene muchas tareas
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    // Generar UUID al crear
    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->id)) {
                $project->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
