<?php

namespace App\Models\School\Meetings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class meeting_recommendations extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id',
        'Item',
        'reason',
        'status',
        'meeting_id',
        'entity_responsible_implementation',
        'Implementation_period',
        'entity_responsible_implementation_related',
    ];
    // Define inverse relationship to Meetings
    public function meetings(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(meetings::class, 'meeting_id');
    }
    public $timestamps = true;
}
