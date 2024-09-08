<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;

class Login extends Component
{

    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('error', 'Invalid email or password');
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
