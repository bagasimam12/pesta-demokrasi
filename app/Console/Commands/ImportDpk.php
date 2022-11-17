<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportDpk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dpk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data anggota dpk';

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
        $this->info('Importing data anggota dpk....');
        $this->info('Checking excel data....');

        $file  = storage_path('app/data/data-peserta/dpk/dpk.ods');
        $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $excel->getActiveSheet()->toArray();

        foreach ($sheet as $row) {
            if (is_null($row[0]) || is_null($row[1])) {
                continue;
            }

            $user = \App\Models\User::where(['uuid' => (string)$row[1], 'level' => 'user'])->first();

            if (\App\Models\AnggotaDpk::insert(['user_id' => $user->id])) {
                $this->info('User ' . $user->uuid . ' inserted to anggota dpk....');
            } else {
                $this->error('User ' . $user->uuid . ' error inserted to anggota dpk....');
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
