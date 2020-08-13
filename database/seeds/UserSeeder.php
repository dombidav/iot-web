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
            'api-key' => '0755f8-7a1044-6f23f8-f5b4db-24371b-06998'
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
