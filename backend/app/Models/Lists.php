<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $table = 'lists';
    use HasFactory;
    public $fillable = [
        'list_name',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id', 'id');
    }
}
