<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Supervisor1',
            'email' => 'supervisor1@iot-web.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'CxRGWo3TBq',
            'api-key' => '6e3f9b-fd0dd7-3328a3-e51762-93a0d6-81951'
        ]);
        factory(App\User::class)->create([
            'name' => 'Supervisor2',
            'email' => 'supervisor2@iot-web.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'CxRGWo3TBs',
            'api-key' => '0e3d8e-2a80bd-caffd4-e45876-1c2b1a-24947'
        ]);
        factory(App\User::class, 30)->create();
    }
}
