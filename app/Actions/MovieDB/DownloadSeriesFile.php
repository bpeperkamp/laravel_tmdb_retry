<?php

namespace App\Actions\MovieDB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class DownloadSeriesFile
{
    /**
     * Download a zipped file with all series from tmdb - trying actions, might refactor later
     *
     * @return void
     */
    public function execute()
    {
        $filename = 'tv_series_ids_' . now()->format('m_d_Y') . '.json.gz';
        $path = 'http://files.tmdb.org/p/exports/' . $filename;

        $contents = Http::get($path)->body();

        Storage::disk('local')->put('/tmdb_zipped/' . $filename, $contents);
    }
}
