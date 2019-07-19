<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AdminSeeder::class);

        if (App::environment(['local', 'staging'])) {
            // This Seeder Would Not Be Run on Production
            $this->call(DummyUserSeeder::class);
            Storage::deleteDirectory('receipts');
        }
    }

}
