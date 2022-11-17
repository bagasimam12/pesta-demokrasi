<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportMpk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mpk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data kandidat mpk';

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
        $this->info('> Checking kandidat data....');

        if (\App\Models\User::count() === 0) {
            $this->error('> must run artisan import:siswa first');
            return Command::FAILURE;
        }

        $file   = storage_path('app/data/data-kandidat/mpk.ods');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet  = $reader->getActiveSheet()->toArray();

        $kandidat = [];
        for ($i=1; $i<count($sheet); $i++) {
            $calon = [
                'user_id'     => $sheet[$i][0],
                'kandidat_no' => $sheet[$i][1],
                'type'        => $sheet[$i][2],
                'gambar'      => 'images/kandidat/mpk/' . $sheet[$i][3],
                'visi'        => $sheet[$i][4],
                'misi'        => $sheet[$i][5]
            ];

            $kandidat []= $calon;
        }

        $this->info('> Validating data...');

        foreach ($kandidat as $row) {
            $this->warn('> Kandidat ' . $row['kandidat_no']);
            $calon = \App\Models\User::find($row['user_id']);
            $this->table(['No Urut', 'Nama', 'Nis', 'Kelas', 'Calon'], [
                [ $row['kandidat_no'], $calon->name, $calon->uuid, \App\Models\Kelas::find($calon->kelas_id)->name, $row['type'] ],
            ]);
            if (!$this->confirm('> Valid ?', true)) {
                $this->info('Please edit kandidat detail....');
                return Command::FAILURE;
            }

            $this->info('> Inserting kandidat....');
            if (\App\Models\KandidatMpk::insert($row)) {
                $this->info('> Kandidat ' . $row['type'] . ' No Urut ' . $row['kandidat_no'] . ' Inserted...');
            } else {
                $this->error('> Kandidat ' . $row['type'] . ' No Urut ' .  $row['kandidat_no'] . ' Not Inserted...');
            }
        } 

        return Command::SUCCESS;
    }
}
