<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use App\User;
use Livewire\Component;

class Registration extends Component
{

    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    public function register()
    {
        User::create([
            'email' => $this->email, 
            'password' => Hash::make($this->password),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.registration');
    }
}
