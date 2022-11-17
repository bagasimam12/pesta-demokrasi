<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportGuru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:guru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export data guru';

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
        $this->info('> Export data guru....');
        $this->info('> Setup directory to store....');

        Storage::disk('local')->makeDirectory('data/data-voting/guru');

        $json = Storage::disk('local')->get('exported_guru.json');
        $data = json_decode($json, true);

        $this->info('> Loaded ' . count($data) . ' data guru...');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $activesheet = $spreadsheet->getActiveSheet();
        
        $j = 1;
        foreach(["NAMA", "LOGIN_ID", "TOKEN"] as $header) {
            $activesheet->setCellValueByColumnAndRow($j,1,$header);
            $j += 1;
        }

        for ($i=0; $i<count($data); $i++) {
            $row = $data[$i];
            $itr = 1;
            
            foreach ($row as $k => $v) {
                $activesheet->setCellValueByColumnAndRow($itr, $i+2, $v);
                $itr += 1;
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(storage_path('app/data/data-voting/guru/guru.xlsx'));
        if (file_exists(storage_path('app/data/data-voting/guru/guru.xlsx'))) {
            $this->info('> Exported data guru....');
        } else {
            $this->error('> Exported data guru....');
        }

        return Command::SUCCESS;
    }
}
