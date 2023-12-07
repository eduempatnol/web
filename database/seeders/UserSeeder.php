<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder admin
        $user = new User();
        $user->role_id = 1;
        $user->sub_role_id = 1;
        $user->name = "Agung Ardiyanto";
        $user->email = "agungd3v@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make("12345678");
        $user->save();

        // Seeder instruktur
        $user2 = new User();
        $user2->role_id = 3;
        $user2->sub_role_id = 5;
        $user2->name = "Instruktur Agung Ardiyanto";
        $user2->email = "instructor@gmail.com";
        $user2->email_verified_at = Carbon::now();
        $user2->password = Hash::make("12345678");
        $user2->save();
    }
}
