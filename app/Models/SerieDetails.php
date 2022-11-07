<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerieDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'adult',
        'first_air_date',
        'last_air_date',
        'original_language',
        'status',
        'overview'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}
