<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {email} {--name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user record';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name') ?: $this->ask('Set the name:');
        $password = $this->option('password') ?: $this->ask('Set password:');

        $admin = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'name' => $name,
        ]);        
    }
}
