<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate admin account';

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
        $this->alert('Generate Admin Account....');

        $user = new \App\Models\User;
        
        $user->email = $this->ask('EMail', 'adm@pestademokrasi.skanza');
        $user->name  = $this->ask('Name', 'Kang Admin');
        $user->level = 'admin';
        $password    = $this->ask('Password');
        if (empty($password)) {
            $password = 'password@adm21';
        }

        $user->password = Hash::make($password);
        $user->email_verified_at = now();
        if ($user->save()) {
            $this->alert('Your account generated');
            $this->info('Login: ' . $user->email);
            $this->info('Password : ' . $password);
            $this->info('Login url: ' . route('admin.login'));
        } else {
            $this->error('Failed generate your account!');
            return Command::FAILURE;
        }

        $admin = [
            'name'     => $user->name,
            'login'    => $user->email,
            'password' => $password
        ];

        \Storage::disk('local')->put('generated_admin.json', json_encode($admin, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
