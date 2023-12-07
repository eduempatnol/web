<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\SubRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ["Administrator", "User", "Instructor"];
        foreach ($roles as $key => $role) {
            $nr = new Role();
            $nr->role_name = $role;
            $nr->role_slug = Str::slug($role, "-");
            $nr->save();
        }

        $subRoles = ["Superadmin", "Community", "School", "Organization", "Individual"];
        foreach ($subRoles as $key => $subRole) {
            $sbr = new SubRole();
            $sbr->sub_role_name = $subRole;
            $sbr->sub_role_slug = Str::slug($subRole, "-");
            $sbr->save();
        }
    }
}
