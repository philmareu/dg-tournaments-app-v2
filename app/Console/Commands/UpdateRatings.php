<?php

namespace App\Console\Commands;

use App\Events\RatingUpdatedEvent;
use App\Models\User\User;
use App\Services\Pdga\PdgaApi;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class UpdateRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all user\'s PDGA ratings';

    protected $user;

    protected $pdgaApi;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user, PdgaApi $pdgaApi)
    {
        parent::__construct();
        $this->user = $user;
        $this->pdgaApi = $pdgaApi;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get all users with pdga numbers
        $users = $this->getUsers();

        $users->each(function (User $user) {
            $pdgaData = $this->pdgaApi->getPlayerByPdgaNumber($user->pdga_number);

            if (! is_null($pdgaData)) {
                if ($user->pdga_rating != $pdgaData['rating']) {
                    event(new RatingUpdatedEvent($user, $user->pdga_rating, $pdgaData['rating']));
                }

                $user->update(['pdga_rating' => $pdgaData['rating']]);
            }
        });
    }

    /**
     * @return mixed
     */
    public function getUsers(): Collection
    {
        $users = $this->user->whereNotNull('pdga_number')->get();

        return $users;
    }
}
