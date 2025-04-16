<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $fillable = [
        'task_name',
        'list_id',
        'priority',
        'status',
        'date'
    ];

    public function lists()
    {
        return $this->belongsTo(Lists::class, 'list_id', 'id');
    }
}
