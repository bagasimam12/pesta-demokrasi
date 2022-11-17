<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportOsis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:osis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data kandidat osis';

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

        $file   = storage_path('app/data/data-kandidat/osis.ods');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet  = $reader->getActiveSheet()->toArray();

        $kandidat = [];
        for ($i=1; $i<count($sheet); $i++) {
            $paslon = [
                'paslon_no' => $sheet[$i][0],
                'ketua'     => $sheet[$i][1],
                'wakil'     => $sheet[$i][2],
                'gambar'    => 'images/kandidat/osis/' . $sheet[$i][3],
                'visi'      => $sheet[$i][4],
                'misi'      => $sheet[$i][5]
            ];

            $kandidat []= $paslon;
        }

        $this->info('> Validating data...');

        foreach ($kandidat as $row) {
            $this->warn('> Paslon No ' . $row['paslon_no']);
            $ketua = \App\Models\User::find($row['ketua']);
            $wakil = \App\Models\User::find($row['wakil']);
            $this->table(['Nama', 'Nis', 'Kelas'], [
                [ $ketua->name, $ketua->uuid, \App\Models\Kelas::find($ketua->kelas_id)->name ],
                [ $wakil->name, $wakil->uuid, \App\Models\Kelas::find($wakil->kelas_id)->name ]
            ]);
            if (!$this->confirm('> Valid ?', true)) {
                $this->info('Please edit kandidat detail....');
                return Command::FAILURE;
            }

            $this->info('> Inserting kandidat....');
            if (\App\Models\KandidatOsis::insert($row)) {
                $this->info('> Kandidat osis paslon ' . $row['paslon_no'] . ' Inserted...');
            } else {
                $this->error('> Kandidat osis paslon ' . $row['paslon_no'] . ' Not Inserted...');
            }
        } 

        return Command::SUCCESS;
    }
}
