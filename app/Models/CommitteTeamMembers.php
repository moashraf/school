<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteTeamMembers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'committe_team_id',
        'user_id',
        'assigned_role',
        'work_assigned_to_user',
    ];
    public $timestamps = true;
}
