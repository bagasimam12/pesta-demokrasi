<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImportSiswa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:siswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data siswa';

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
        $this->info('> Import data siswa ....');
        $this->info('> Checking excel data.... ');

        $files = Storage::disk('local')->allFiles();
        $found = [];
        foreach ($files as $excel) {
            if (
                strpos($excel, 'xlsx') === false || 
                strpos($excel, 'guru') !== false ||
                strpos($excel, 'data-peserta') === false ||
                strpos($excel, 'dpk') !== false
            ) {
                continue;
            }
            $found []= $excel;
        }
        $this->info('> Found ' . count($found) . ' excel data....');
        sleep(1);
        $this->info('> Parsing data kelas....');
        $toexport = [];
        foreach($found as $data) {
            $kelas = str_replace('data/data-peserta/', '', $data);
            $kelas = str_replace('.xlsx', '', $kelas);
            $kelas = str_replace(['10','11','12','13'], ['X','XI','XII', 'XIII'], $kelas);
            $kelas = str_replace(['X/','XI/','XII/','XIII/'], '', $kelas);
            $kelas = str_replace('_', ' ', $kelas);

            $this->info('> Inserting kelas ' . $kelas);
            if (!\App\Models\Kelas::insert([
                'name'       => $kelas,
                'created_at' => now()
            ])) {
                $this->error('> Kelas ' . $kelas . ' failed to insert!');
                continue;
            } else {
                $this->info('> Preparing inserting siswa kelas ' . $kelas);
                $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load(
                    storage_path('app/'.$data)
                );
                $sheet     = $excel->getActiveSheet()->toArray();
                $loaded    = 0;
                $inserted  = 0;
                $forexport = [];
                foreach ($sheet as $ps) {
                    if ($ps[0] !== null && $ps[1] !== null) {
                        $loaded += 1;
                        $gdtkn = [];
                        $token = $this->generateToken(6, $gdtkn);
                        $siswa = [
                            'email'     => $ps[1] . \ConfigVoting::getConfig()->email_prefix,
                            'uuid'      => $ps[1],
                            'name'      => $ps[0],
                            'level'     => 'user',
                            'kelas_id'  => \App\Models\Kelas::where('name', '=', $kelas)->first()->id,
                            'user_type' => 'siswa',
                            'password'  => Hash::make($token),
                            'email_verified_at' => now(),
                            'created_at' => now()
                        ];
                        $gdtkn []= $token;

                        if (!\App\Models\User::insert($siswa)) {
                            $this->error('Failed inserting ' . $ps[0] . ' at kelas ' . $kelas);
                        } else {
                            $this->info($ps[0] . ' (' . $ps[1] . ') Inserted to kelas ' . $kelas);
                            $inserted += 1;

                            $forexport []= [
                                'nama'  => $ps[0],
                                'nis'   => $ps[1],
                                'token' => $token
                            ];
                        }
                        // sleep(0.5);  
                    }
                }
                $toexport[$kelas] = $forexport;
                $this->info('Kelas ' . $kelas . ' Inserted ' . $inserted . ' Siswa');
                $this->info('Kelas ' . $kelas . ' Exported ' . count($forexport) . ' Siswa');
                $inserted  = 0;
                $forexport = [];
            }
        }

        $this->info('> Process done with result');
        $this->info('> Kelas inserted : ' . \App\Models\Kelas::count());
        $this->info('> Siswa inserted : ' . \App\Models\User::where([
            'level' => 'user', 'user_type' => 'siswa'
        ])->count());

        $this->info('> Exporting raw data....');
        Storage::disk('local')->put('exported_siswa.json', json_encode($toexport, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }

    private function generateToken(int $length, array $generated): string
    {
        $strrt = '01213456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = substr(str_shuffle($strrt), 0, $length);

        while (in_array($token, $generated)) {
            $token = substr(str_shuffle($strrt), 0, $length);
        }

        return $token;
    }
}
