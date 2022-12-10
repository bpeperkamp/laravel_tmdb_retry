<?php

namespace App\Jobs;

use App\Models\Season;
use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\RateLimited;

class GetEpisodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // /**
    //  * The number of times the job may be attempted.
    //  *
    //  * @var int
    //  */
    // public $tries = 25;

    // /**
    //  * Indicate if the job should be marked as failed on timeout.
    //  *
    //  * @var bool
    //  */
    // public $failOnTimeout = false;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new RateLimited('tmdb_ratelimit')];
    }

    /**
     * The podcast instance.
     *
     * @var \App\Models\Season
     */
    public $season;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $serieTmdbId = $this->season->serie->tmdb_id;

        if ($this->season->serie->tmdb_id) {
            $episodes = new \App\Actions\MovieDB\GetSeasonInfoWithEpisodes();
            $episodes = $episodes->execute($serieTmdbId, $this->season->season_number);
            if ($episodes->episodes) {
                foreach ($episodes->episodes as $episode) {
                    $newEpisode = Episode::updateOrCreate(
                        [
                            'season_id' => $this->season->id,
                            'name' => $episode->name
                        ], [
                            'serie_id' => $this->season->serie->id,
                            'overview' => $episode->overview ?? null,
                            'still_path' => $episode->still_path ?? null,
                            'air_date' => $episode->air_date ? \Carbon\Carbon::parse($episode->air_date) : null,
                            'season_number' => $episode->season_number ?? null,
                            'runtime' => $episode->runtime ?? null,
                        ]
                    );
                }
            }
        }
    }

    public function retryUntil()
    {
        // will keep retrying, by backoff logic below
        // until 12 hours from first run.
        // After that, if it fails it will go
        // to the failed_jobs table
        return now()->addHours(12);
    }
}
