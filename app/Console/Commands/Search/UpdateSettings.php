<?php

namespace App\Console\Commands\Search;

use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Console\Command;

class UpdateSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:update-settings {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update algolia settings';

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
        $client = SearchClient::create(config('scout.algolia.id'), config('scout.algolia.secret'));

        $client->initIndex($this->argument('index'))
            ->setSettings(config('scout.algolia.indexes.' . $this->argument('index') . '.settings'));
    }
}
