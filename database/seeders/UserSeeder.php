<?php

namespace Database\Seeders;

use App\Models\InstructorWallet;
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
        $user->email = "admin@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make("12345678");
        $user->save();

        // Seeder instruktur
        $user2 = new User();
        $user2->role_id = 3;
        $user2->sub_role_id = 5;
        $user2->name = "Agung Ardiyanto Instruktur";
        $user2->email = "instructor@gmail.com";
        $user2->email_verified_at = Carbon::now();
        $user2->password = Hash::make("12345678");
        $user2->save();

        $wallet2 = new InstructorWallet();
        $wallet2->user_id = $user2->id;
        $wallet2->type = "Primary";
        $wallet2->save();

        // Seeder Student
        $user2 = new User();
        $user2->role_id = 2;
        $user2->sub_role_id = 5;
        $user2->name = "Agung Ardiyanto Student";
        $user2->email = "student@gmail.com";
        $user2->email_verified_at = Carbon::now();
        $user2->password = Hash::make("12345678");
        $user2->save();
    }
}
