<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'serie_id',
        'name',
        'overview',
        'poster_path',
        'air_date',
        'episode_count',
        'season_number',
        'tmdb_id',
    ];

    /**
     * Get the series that belongs to the season.
     */
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    /**
     * Get the episodes associated with the season.
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
