<?php

namespace App\Console\Commands;

use App\Models\Serie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class ReadSeriesFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'series:import_series';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read series from file and import to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function formatBytes($bytes, $precision = 2) {
        $units = array("b", "kb", "mb", "gb", "tb");

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . " " . $units[$pow];
    }

    /**
     * Read a file line by line and save memory
     */
    public function readFile($path) {
        $handle = fopen($path, "r");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }

    /**
     */
    public function handle()
    {
        $filename = 'tv_series_ids_' . now()->format('m_d_Y') . '.json';

        $fileExists = Storage::disk('local')->exists('tmdb_zipped/' . $filename);

        $bar = $this->output->createProgressBar(count(file(storage_path('app/tmdb_zipped/' . $filename))));

        if ($fileExists) {
            $iterator = $this->readFile(storage_path('app/tmdb_zipped/' . $filename));

            foreach ($iterator as $iteration) {
                $data = json_decode($iteration);

                $bar->advance();

                if (isset($data->id)) {
                    $serie = Serie::updateOrCreate(
                        [
                            'tmdb_id' => $data->id
                        ], [
                            'title' => $data->original_name,
                            'rating' => $data->popularity
                        ]
                    );
                }
            }
        }

        $bar->finish();

        $this->newLine();

        $this->info("Series were successfully imported");
    }
}
