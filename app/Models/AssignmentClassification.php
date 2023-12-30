<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentClassification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'school_id',
    ];

    public $timestamps = true;
}
