<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $testingSeeders = [UserSeeder::class];

        $callingSeeders = [];

        if (App::environment('testing')) {
            $callingSeeders = [...$callingSeeders, ...$testingSeeders];
        }

        $this->call($callingSeeders);
    }
}
