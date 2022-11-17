<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default config';

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
        $this->info('Import default config....');

        $config = [
            'title'        => 'PESTA DEMOKRASI ' . now()->format('Y'),
            'title_prefix' => 'SMK NEGERI 1 BAWANG',
            'email_prefix' => '@pestademokrasi'.now()->format('Y').'.skanza',
            'periode'      => now()->format('Y') . '/' . (now()->format('Y') + 1),
            'voting'       => 'mpk'
        ];

        if (\App\Models\Config::count() > 0) {
            return Command::SUCCESS;
        }

        if (\App\Models\Config::insert($config)) {
            $this->info('Config imported ....');
            dump($config);
        } else {
            $this->error('Config not imported....');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
