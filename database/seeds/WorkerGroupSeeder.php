<?php

use Illuminate\Database\Seeder;

class WorkerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\WorkerGroup::class, 30)->create();
    }
}
