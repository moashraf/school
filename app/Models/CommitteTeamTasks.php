<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteTeamTasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'committe_team_id',
        'task_description',
    ];
    public $timestamps = true;
}
