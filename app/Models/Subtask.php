<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $table = "subtask";

    protected $fillable = [
        'id', 'task_id', 'subtasktitle', 'subtaskdescription', 'subtaskstatus',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    protected $hidden = [];
}
