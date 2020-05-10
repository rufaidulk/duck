<?php

use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $k = [2, 4, 5];
        for ($i = 0; $i < 50; $i++) {
            DB::table('chats')->insert([
            'room_id' => rand(1, 4),
            'sender_id' => $k[array_rand($k)],
            'message' => Str::random(10),
        ]);
        }
    }
}
