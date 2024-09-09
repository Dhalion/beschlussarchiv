<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:pw-ch {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes the password of a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        $user = User::where('name', $username)->first();
        if (!$user) {
            $user = User::where('email', $username)->first();
        }
        if (!$user) {
            $this->error("User not found");
            return 1;
        }

        $password = $this->secret('Enter the new password');

        if ($user) {
            $user->password = bcrypt($password);
            $user->save();
            $this->info('Password changed successfully');
        } else {
            $this->error('User not found');
        }
    }
}
