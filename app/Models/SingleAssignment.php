<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleAssignment extends Model
{
    protected $table = 'single_assignment';

    use HasFactory;
    protected $fillable = [
        'id',
        'assignment_name',
        'assignment_start_date',
        'assignment_duration',
        'assignment_specialization',
        'assignment_goal',
        'is_committe_or_team',
        'assignment_item_id',
    ];
    public $timestamps = true;

    public function assignedUsers()
    {
        return $this->hasMany(AssignmentUsers::class, 'single_assignment_id', 'id');
    }

}
