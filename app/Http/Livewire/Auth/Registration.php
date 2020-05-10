<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use App\User;
use Livewire\Component;

class Registration extends Component
{

    public $name = "";
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    public function updatedEmail()
    {
        $this->validate(['email' => 'unique:users']);
    }


    public function register()
    {
        $data = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:passwordConfirmation',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        auth()->login($user);

        return redirect('/');

    }

    public function render()
    {
        return view('livewire.auth.registration');
    }
}
