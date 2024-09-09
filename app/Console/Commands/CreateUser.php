<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {username?} {email?} {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Backend User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $admin = $this->option('admin');

        if (!$username) {
            $username = $this->ask('Enter the username');
        }
        if (!$username) {
            $this->error('Username is required');
            return 1;
        }
        if (!$this->argument('email')) {
            $email = $this->ask('Enter the email');
        }
        if (!$email) {
            $email = $username;
        }
        if (!$admin) {
            $admin = $this->confirm('Is this an admin user?');
        }

        $password = $this->secret('Enter the password');

        if (!$password) {
            $this->error('Password is required');
            return 1;
        }

        $user = new User();
        $user->name = $username;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->admin = $admin;
        $user->saveOrFail();

        $this->info("User {$username} created successfully");
    }
}
