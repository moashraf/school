<?php

namespace App\Models\School\Meetings;

use App\Models\School\Manager;
use App\Models\School\School;
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
    ];

    public $timestamps = true;

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
