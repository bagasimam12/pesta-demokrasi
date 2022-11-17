<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportSiswa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:siswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export data siswa';

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
        $this->info('> Export data siswa....');
        $this->info('> Setup directory to store....');

        if (Storage::disk('local')->exists('data/data-voting')) {
            Storage::disk('local')->deleteDirectory('data/data-voting');
        }

        if (!Storage::disk('local')->exists('exported_siswa.json')) {
            $this->error('Exported data siswa not found!');
            return Command::FAILURE;
        }

        Storage::disk('local')->makeDirectory('data/data-voting');
        Storage::disk('local')->makeDirectory('data/data-voting/X');
        Storage::disk('local')->makeDirectory('data/data-voting/XI');
        Storage::disk('local')->makeDirectory('data/data-voting/XII');
        Storage::disk('local')->makeDirectory('data/data-voting/XIII');

        $json = Storage::disk('local')->get('exported_siswa.json');
        $data = json_decode($json, true);

        $this->info('> Loaded ' . count($data) . ' kelas...');

        foreach ($data as $kelas => $siswa) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $activesheet = $spreadsheet->getActiveSheet();

            $j = 1;
            foreach(["NAMA", "NIS", "TOKEN"] as $header) {
                $activesheet->setCellValueByColumnAndRow($j,1,$header);
                $j += 1;
            }

            for ($i=0; $i<count($siswa); $i++) {
                $row = $siswa[$i];
                $itr = 1;

                foreach ($row as $k => $v) {
                    $activesheet->setCellValueByColumnAndRow($itr, $i+2, $v);
                    $itr += 1;
                }
            }

            $kelas = str_replace(' ', '_', $kelas);
            if (strpos($kelas, 'XIII') !== false) {
                $path = 'XIII';
            } elseif (strpos($kelas, 'XII') !== false) {
                $path = 'XII';
            } elseif (strpos($kelas, 'XI') !== false) {
                $path = 'XI';
            } else {
                $path = 'X';
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save(storage_path('app/data/data-voting/'.$path.'/'.$kelas.'.xlsx'));
            if (file_exists(storage_path('app/data/data-voting/'.$path.'/'.$kelas.'.xlsx'))) {
                $this->info('> Exported data siswa kelas ' . str_replace('_', ' ', $kelas));
            } else {
                $this->error('> Exported data siswa kelas ' . str_replace('_', ' ', $kelas));
            }
        }

        $this->info('> Export done....');
        $this->info('> Getting generated data....');

        return Command::SUCCESS;
    }
}
