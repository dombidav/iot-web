<?php

use Illuminate\Database\Seeder;

class GroupConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Group::all() as $group){
            for ($i=0; $i<rand(1,50);$i++){
                \App\Worker::all()->random()->groups()->attach($group);
                \App\Lock::all()->random()->groups()->attach($group);
            }
        }
    }
}
