<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;


class registrationTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    function registration_page_contatins_livewire_component()
    {
        $this->get('/register')->assertSeeLivewire('auth.registration');
    }

    /** @test */
   function can_register()
   {
       Livewire::test('auth.registration')
           ->set('name', 'Jamie')
           ->set('email', 'jamie@jamieshiers.co.uk')
           ->set('password', 'secret')
           ->set('passwordConfirmation', 'secret')
           ->call('register')
           ->assertRedirect('/');

       $this->assertTrue(User::whereEmail('jamie@jamieshiers.co.uk')->exists());
       $this->assertequals('jamie@jamieshiers.co.uk', auth()->user()->email);
   }

    /** @test */
    function email_is_required()
    {
        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', '')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_valid_email()
    {
        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', 'jamie')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    function email_is_unique()
    {
        User::create([
            'name' => 'Jamie',
            'email' => 'jamie@jamieshiers.co.uk',
            'password' => Hash::make('password'),
        ]);

        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', 'jamie@jamieshiers.co.uk')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function see_email_hasent_been_taken_validation_message_as_user_types()
    {
        User::create([
            'name' => 'Jamie',
            'email' => 'jamie@jamieshiers.co.uk',
            'password' => Hash::make('password'),
        ]);

        Livewire::test('auth.registration')
            ->set('email', 'jami@jamieshiers.co.uk')
            ->assertHasNoErrors()
            ->set('email', 'jamie@jamieshiers.co.uk')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function password_is_required()
    {
        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', 'jamie@jamieshiers.co.uk')
            ->set('password', '')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    function password_meets_minimum_length()
    {
        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', 'jamie@jamieshiers.co.uk')
            ->set('password', 'secre')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    function password_matches_password_confirmation()
    {
        Livewire::test('auth.registration')
            ->set('name', 'Jamie')
            ->set('email', 'jamie@jamieshiers.co.uk')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'not-secret')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }




}
