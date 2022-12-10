<?php

namespace App\Actions\MovieDB;

use Illuminate\Support\Facades\Http;

class GetChanges
{
    /**
     * Get changes from season. Meant to get the latest episodes for watched items
     *
     * @return mixed
     */
    public function execute($season_tmdb_id)
    {
        $getFreshContent = Http::get('https://api.themoviedb.org/3/tv/season/' . $season_tmdb_id . '/changes'.  '?api_key=' . config('tmdb.api_key'));

        $new = json_decode($getFreshContent->body());

        return $new;
    }
}
