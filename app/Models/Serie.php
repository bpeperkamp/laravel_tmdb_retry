<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'tmdb_id',
        'title',
        'rating',
        'detailed_info'
    ];

    /**
     * Get the details associated with the serie.
     */
    public function details()
    {
        return $this->hasOne(SerieDetails::class);
    }
}
