<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'organizational_connection',
        'assignment_goal',
        'model_number',
        'job_title',
    ];
    public $timestamps = true;
}
