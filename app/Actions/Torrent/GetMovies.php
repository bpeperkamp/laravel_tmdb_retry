<?php

namespace App\Actions\Torrent;

use Illuminate\Support\Facades\Http;

class GetMovies
{
    /**
     * Get changes from season. Meant to get the latest episodes for watched items
     *
     * @return mixed
     */
    public function execute($title, $year = null)
    {
        $getData = Http::get("http://localhost:8080/api/v1/category?site=1337x&query='". $title . ($year ? ' ' : '') . ($year ? $year : '') . "'&category=movies");

        $data = json_decode($getData->body());

        return $data->data ?? [];
    }
}
