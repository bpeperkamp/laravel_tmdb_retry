<?php

namespace App\Actions\MovieDB;

use Illuminate\Support\Facades\Http;

class GetSeasonInfoWithEpisodes
{
    /**
     * Get details from a serie via tmdb_id - trying actions, might refactor later
     *
     * @return mixed
     */
    public function execute($tmdb_id, $seasonNumber)
    {
        $getSeasons = Http::get('https://api.themoviedb.org/3/tv/' . $tmdb_id . '/season/' . $seasonNumber . '?api_key=' . config('tmdb.api_key'));

        $details = json_decode($getSeasons->body());

        return $details;
    }
}
