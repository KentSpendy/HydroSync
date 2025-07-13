<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hydrosync.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Employee
        User::create([
            'name' => 'Employee User',
            'email' => 'employee@hydrosync.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);
    }
}

