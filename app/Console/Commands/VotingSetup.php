<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class VotingSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voting:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Voting Application';

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
        $this->warn('Voting setup....');
        $this->info('Application developed by RPL - 2019 XII RPL 1');
        $this->ask('Press any key to continue.....');

        if (Storage::disk('local')->exists('app_installed')) {
            $this->warn('Application is already installed, if you continue you will reset voting state!!');
            if (!$this->confirm('Continue ??', false)) {
                return Command::SUCCESS;
            }
            Storage::disk('local')->delete('app_installed');
        }
        
        sleep(1);


        if ($code = $this->call('migrate:fresh') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:config') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:siswa') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:guru') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:osis') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:mpk') !== 0) {
            return $code;
        }

        if ($code = $this->call('import:dpk') !== 0) {
            return $code;
        }

        if ($code = $this->call('generate:admin') !== 0) {
            return $code;
        }

        if ($code = $this->call('export:siswa') !== 0) {
            return $code;
        }

        if ($code = $this->call('export:guru') !== 0) {
            return $code;
        }

        $this->info('Setup done....');
        // Storage::disk('local')->delete('exported_siswa.json');
        Storage::disk('local')->put('app_installed', 'ok');

        return Command::SUCCESS;
    }
}
