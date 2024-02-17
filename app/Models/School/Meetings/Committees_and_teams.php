<?php

namespace App\Models\School\Meetings;

use App\Http\Controllers\School\SingleAssignmentController;
use App\Models\School\Manager;
use App\Models\School\School;
use App\Models\SingleAssignment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committees_and_teams extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'author',
        'school_id',
        'classification',
        'committe_formation_rules',
        'goals'

    ];

    public $timestamps = true;

        public function get_meetings()
    {
        return $this->hasMany(meetings::class, 'committees_and_teams_id', 'id');
    }


    public function get_single_assignment()
    {
       return $this->hasOne(SingleAssignment::class, 'is_committe_or_team', 'id');
     }

//    public function manager()
//    {
//        return $this->belongsTo(Manager::class, 'manager_id', 'id');
//    }
//
//    public function school()
//    {
//        return $this->belongsTo(School::class, 'school_id', 'id');
//    }
//
//    public function grade()
//    {
//        return $this->belongsTo(School_grade::class, 'school_grade_id', 'id');
//    }
//
//    public function students()
//    {
//        return $this->hasMany(Student::class, 'school_grade_class_id', 'id')->withTrashed();
//    }
}
