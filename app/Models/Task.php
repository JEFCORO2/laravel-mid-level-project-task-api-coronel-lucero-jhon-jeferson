<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tasks';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    // Relación: una tarea pertenece a un proyecto
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Generar UUID al crear
    protected static function booted()
    {
        static::creating(function ($task) {
            if (empty($task->id)) {
                $task->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
