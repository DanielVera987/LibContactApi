<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Contact::factory(500)->create();
        \App\Models\ContactPhone::factory(150)->create();
        \App\Models\ContactEmail::factory(150)->create();
        \App\Models\ContactAddress::factory(150)->create();
    }
}
