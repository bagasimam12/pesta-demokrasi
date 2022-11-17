<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ImportGuru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:guru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data guru';

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
        $this->info('Import data guru....');
        $this->info('Checking excel data....');

        $excel = storage_path('app/data/data-peserta/guru/guru.xlsx');
        $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($excel);

        $sheet = $excel->getActiveSheet()->toArray();

        $forexport = [];
        $j = 1;
        foreach ($sheet as $row) {
            if (is_null($row[0]) && is_null($row[1])) {
                continue;
            }

            $row[1] = $this->generateUUID($j++);

            $gdtkn = [];
            $token = $this->generateToken(6, $gdtkn);

            $data = [
                'email'     => $row[1] . \ConfigVoting::getConfig()->email_prefix,
                'name'      => $row[0],
                'uuid'      => $row[1],
                'password'  => Hash::make($token),
                'email_verified_at' => now(),
                'level'     => 'user',
                'user_type' => 'guru'
            ];

            array_push($gdtkn, $token);

            if (\App\Models\User::insert($data)) {
                $this->info('Guru ' . $row[0] . ' Inserted ....');
            } else {
                $this->error('Guru ' . $row[0] . ' Not Inserted ...');
            }

            $export = [
                'nama'  => $row[0],
                'uuid'  => $row[1],
                'token' => $token
            ];

            $forexport []= $export;

        }

        Storage::disk('local')->put('exported_guru.json', json_encode($forexport, JSON_PRETTY_PRINT));

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

    private function generateUUID($index = 1) {
        $uuid  = '0' . $index; 
        while (strlen($uuid) < 5 ) {
            $uuid = str_repeat(0, 6 - strlen($uuid)) . $index;
            $index += 1;
        }
        
        return $uuid;
    } 
}
