<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "task";

    protected $fillable = [
        'id', 'user_id','tasktitle','taskdescription','taskfinishdate', 'taskstatus'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subtasks(){
        return $this->hasMany(Subtask::class, 'task_id', 'id');
    }
    
    protected $hidden = [
        
    ];
}
