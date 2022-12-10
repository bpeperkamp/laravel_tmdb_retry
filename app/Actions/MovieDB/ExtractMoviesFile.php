<?php

namespace App\Actions\MovieDB;

use Illuminate\Support\Facades\Storage;

class ExtractMoviesFile
{
    /**
     * Extract a zipped file with all series from tmdb - trying actions, might refactor later
     *
     * @return void
     */
    public function execute()
    {
        $filename = 'movie_ids_' . now()->format('m_d_Y') . '.json.gz';

        if (Storage::disk('local')->exists('tmdb_zipped/' . $filename)) {
            $out_file_name = str_replace('.gz', '', $filename);
            $gzdata = gzopen(storage_path('app/tmdb_zipped/' . $filename), 'rb');
            while(!gzeof($gzdata)) {
                Storage::disk('local')->put('/tmdb_zipped/' . $out_file_name, $gzdata);
            }
            gzclose($gzdata);
        }
    }
}
