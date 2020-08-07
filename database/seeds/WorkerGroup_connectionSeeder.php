<?php

use Illuminate\Database\Seeder;

class WorkerGroupconnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\WorkerGroup::all() as $group){
            for ($i=0; $i<rand(0,50);$i++){
                \App\Worker::all()->random()->groups()->attach($group);
                \App\Lock::all()->random()->groups()->attach($group);
            }
        }
    }
}
