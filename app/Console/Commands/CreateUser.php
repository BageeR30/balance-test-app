<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class CreateUser extends Command
{
    protected $signature = 'app:create-user';
    
    protected $description = 'Create User';

    public function handle(): void
    {
        $name = $this->ask('Name:');
        $email = $this->ask('Email:');
        $password = $this->secret('Password:');

        $validator = Validator::make(compact('name', 'email', 'password'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully.');
    }
}
