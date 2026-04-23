<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FootballMatch extends Model
{
    protected $fillable = [
        'api_id',
        'competition_id',
        'home_team_api_id',
        'away_team_api_id',
        'home_team_name',
        'away_team_name',
        'utc_date',
        'status',
        'matchday',
        'home_score',
        'away_score',
    ];

    protected $casts = [
        'utc_date' => 'datetime',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
