<?php

namespace Database\Seeders;

use App\Models\Role;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Pembeli',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
