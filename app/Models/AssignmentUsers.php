<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'single_assignment_id',
        'user_id',
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
