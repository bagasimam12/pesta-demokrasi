<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetVotingUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:votinguser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset voting an user';

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
        $user = $this->ask('Input user id / uuid ');

        $find = \App\Models\User::where('id', $user)->orWhere('uuid', $user)->first();

        while (is_null($find)) {
            $this->warn('User not found....');

            $user = $this->ask('Input user id / email / uuid / name');

            $find = \App\Models\User::where('id', $user)->orWhere('uuid', $user)->first();
        }

        if ($this->confirm('User with name ' . $find->name . ' voting status will be reset, continue?')) {
            $osis = \App\Models\VotingOsis::where('user_id', $find->id)->first();
            $mpk  = \App\Models\VotingMpk::where('user_id', $find->id)->get();

            if ($osis) {
                $this->info('Reseting voting_osis status....');
                $ap = \App\Models\Aspirasi::where(['user_id' => $find->id, 'voting' => 'osis'])->first();
                if ($ap) {
                    $ap->delete();
                }
                $osis->delete();
            }

            if ($mpk->count() > 0) {
                $this->info('Reseting voting_mpk status....');
                foreach ($mpk as $row) {
                    \App\Models\VotingOsis::find($row->id)->delete();
                }

                $ap = \App\Models\Aspirasi::where(['user_id' => $find->id, 'voting' => 'mpk'])->first();
                if ($ap) {
                    $ap->delete();
                }
            }
        }

        return Command::SUCCESS;
    }
}
