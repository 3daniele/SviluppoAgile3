<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InsertAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array(
            'username' => 'administrator',
            'email' => 'admin@sharedmusic.it',
            'password' => '$2y$10$3LathfKQzKZ0ggb8dEh1AOCgncIVYbw8gNBHO4cVvE8TQ4o/hqx/6',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('users')->insert($user);

        $daniele = array(
            'username' => 'daniele',
            'email' => 'daniele@danieledd.it',
            'password' => '$2y$10$3LathfKQzKZ0ggb8dEh1AOCgncIVYbw8gNBHO4cVvE8TQ4o/hqx/6',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('users')->insert($daniele);

        $domenico = array(
            'username' => 'domenico',
            'email' => 'domenico597@live.it',
            'password' => '$2y$10$zJQ27n4GzjU.AIIVGZNCo.8h3CAtgQYcEsYABvBHM8M2hgMTN6eDa',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('users')->insert($domenico);

        $francy = array(
            'username' => 'francy',
            'email' => 'francy.nuova@hotmail.it',
            'password' => '$2y$10$R1xyHzPtv1ZBL6WXh1ItYe31TxrroY2iFMCQIPXQ4NLDcZ2y7AB5a',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('users')->insert($francy);

        $chiara = array(
            'username' => 'chiara',
            'email' => 'chiara.19mich@gmail.com',
            'password' => '$2y$10$3LathfKQzKZ0ggb8dEh1AOCgncIVYbw8gNBHO4cVvE8TQ4o/hqx/6',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        DB::table('users')->insert($chiara);
    }
}
