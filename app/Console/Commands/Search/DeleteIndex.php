<?php

namespace App\Console\Commands\Search;

use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Console\Command;

class DeleteIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:clear-index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new SearchClient(config('scout.algolia.id'), config('scout.algolia.secret'));

        $client->initIndex($this->argument('index'))->delete();
    }
}
