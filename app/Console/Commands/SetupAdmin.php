<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SetupAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an administrator account.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {
            $username = $this->ask('Choose a username', 'admin');

            try {
                Validator::make(['username' => $username], [
                    'username' => 'required|between:3,20|alpha_dash:ascii|unique:users,username',
                ])->validate();
            } catch (ValidationException $e) {
                $this->error($e->getMessage());
                continue;
            }

            break;
        }

        while (true) {
            $email = $this->ask('Input an email address');

            try {
                Validator::make(['email' => $email], [
                    'email' => 'required|email|max:255|unique:users,email',
                ])->validate();
            } catch (ValidationException $e) {
                $this->error($e->getMessage());
                continue;
            }

            break;
        }

        while (true) {
            $password = $this->secret('Choose a password');
            $password_v = $this->secret('Repeat the password');

            try {
                Validator::make(['password' => $password, 'password_confirmation' => $password_v], [
                    'password' => ['required', 'string', Password::default(), 'confirmed'],
                ])->validate();
            } catch (ValidationException $e) {
                $this->error($e->getMessage());
                continue;
            }

            break;
        }

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];

        try {
            DB::transaction(function () use ($data) {
                /** @var User $user */
                $user = User::create($data);
                $user->markEmailAsVerified();
                $user->assignRole('admin');
            });
        } catch (\Exception $e) {
            report($e);
            $this->fail('There was an error creating the user. Please check the log.');
        }

        $this->info('Admin user created.');
    }
}
