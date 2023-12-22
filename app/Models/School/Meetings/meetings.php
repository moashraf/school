<?php

namespace App\Models\School\Meetings;

use App\Http\Controllers\meetingRecommendations;
use App\Models\School\Manager;
use App\Models\School\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class meetings extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'committees_and_teams_id',
        'Number_of_attendees',
        'Target_group',
        'Semester',
        'status',
        'location',
        'stage',
        'start_date',
        'start_time',
        'type',
        'end_date',
        'end_time',
        'title',
    ];

    public $timestamps = true;
    public function meeting_agenda()
    {
        return $this->hasMany(meeting_agenda::class, 'meeting_id');
    }

    // Relationship to MeetingRecommendation
    public function meeting_recommendations()
    {
        return $this->hasMany(meeting_recommendations::class, 'meeting_id');
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
