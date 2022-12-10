<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'serie_id',
        'season_id',
        'name',
        'overview',
        'still_path_path',
        'air_date',
        'episode_number',
        'season_number',
        'runtime'
    ];

    /**
     * Get the season that belongs to this episode.
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}
