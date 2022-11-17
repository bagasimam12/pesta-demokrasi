<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChangeVoting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:voting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toggle voting type';

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
        $this->alert('WARNING THIS ACTION IS VERY DANGERIOUS');
        $this->info('Current voting is for: ' . \ConfigVoting::getConfig()->voting);

        $change = \ConfigVoting::getConfig()->voting === 'osis' ? 'mpk' : 'osis';
        if ($this->confirm('Do you want change voting to ' . $change)) {
            $this->warn('Changing voting type...');

            $conf = \App\Models\Config::find(1);
            $conf->voting = $change;

            if ($conf->save()) {
                $this->info('Voting type changed to ' . $change . '....');
            } else {
                $this->error('Error while changing voting type....');
                return Command::FAILURE;
            }
        }
        return Command::SUCCESS;
    }
}
