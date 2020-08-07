<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
        $this->call(DeviceSeeder::class);
        $this->call(WorkerSeeder::class);
        $this->call(WorkerGroupSeeder::class);
        $this->call(LogSeeder::class);
        $this->call(LockSeeder::class);
        $this->call(WorkerGroupConnectionSeeder::class);
    }
}
