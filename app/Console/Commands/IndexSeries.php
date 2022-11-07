<?php

namespace App\Console\Commands;

use App\Models\Serie;
use Exception;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class IndexSeries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:index_series';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all the series to Elastic';

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
        $series = Serie::all();

        $bar = $this->output->createProgressBar(count($series));

        foreach ($series as $serie) {
            try {
                $this->elasticsearch->index([
                    'id' => $serie->getKey(),
                    'index' => $serie->getTable(),
                    'body' => $serie->toArray()
                ]);
                // $this->output->write('.');
                $bar->advance();
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $bar->finish();

        $this->newLine();

        $this->info("Series were successfully indexed");
    }
}
