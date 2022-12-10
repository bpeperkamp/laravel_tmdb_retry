<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Exception;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class IndexMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:index_movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all the movies to Elastic';

    /**
     * @var \Elastic\Elasticsearch\Client
     */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    /**
     */
    public function handle()
    {
        $movies = Movie::all();

        $bar = $this->output->createProgressBar(count($movies));

        // Delete the entire index first. @todo - delta indices?
        $deleteRequest = Http::delete('localhost:9200/' . $movies[0]->getTable());

        $this->info("The index was emptied");

        $this->newLine();

        foreach ($movies as $movie) {
            try {
                $this->elasticsearch->index([
                    'id' => $movie->getKey(),
                    'index' => $movie->getTable(),
                    'body' => $movie->toArray()
                ]);
                // $this->output->write('.');
                $bar->advance();
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $bar->finish();

        $this->newLine();

        $this->info("Movies were successfully indexed");
    }
}
