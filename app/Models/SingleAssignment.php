<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'assignment_name',
        'assignment_start_date',
        'assignment_duration',
        'assignment_specialization',
        'assignment_goal',
        'is_committe_or_team',
    ];
    public $timestamps = true;
}
