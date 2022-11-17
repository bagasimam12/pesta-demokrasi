<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetVoting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:voting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset voting (development)';

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
     * @return int
     */
    public function handle()
    {
        $this->alert('WARNING THIS ACTION IS VERY DANGERIOUS ONLY USE IN DEVELOPEMENT');
        $x = $this->choice('Choose which votings will be reset', ['mpk','osis','all']);


        if ($this->confirm('This will reset voting status (TRUNCATE) continue?')) {
            if ($x === 'all') {
                $this->warn('Reseting all votings data....');
                sleep(1);

                $this->info('TRUNCATE table voting_mpk....');
                \App\Models\VotingMpk::truncate();

                sleep(1);

                $this->info('TRUNCATE table voting_osis....');
                \App\Models\VotingOsis::truncate();
            }

            if ($x === 'osis') {
                $this->warn('Reseting voting_osis data....');
                sleep(1);

                $this->info('TRUNCATE table voting_osis....');
                \App\Models\VotingOsis::truncate();
            } 

            if ($x === 'mpk') {
                $this->warn('Reseting voting_mpk data....');
                sleep(1);

                $this->info('TRUNCATE table voting_mpk....');
                \App\Models\VotingOsis::truncate();
            }

            $this->info('TRUNCATE table aspirasi....');
            \App\Models\Aspirasi::truncate();
        }

        return Command::SUCCESS;
    }
}
