<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --table-mode --tables=users --limit=200
         *
         */

        $dataTables = [
            [
                'id' => 1,
                'name' => 'Wael',
                'avatar' => 'default.png',
                'email' => 'wael10@hotmail.com',
                'email_verified_at' => '2023-12-05 14:27:09',
                'password' => '$2y$10$sYXAoOCBXQI57REJH.bhCOZIwv0tyNxYo7lpRECL1mKhDV1sM4RjG',
                'remember_token' => NULL,
                'created_at' => '2025-09-10 18:27:29',
                'updated_at' => NULL,
            ],
            [
                'id' => 2,
                'name' => 'ziad',
                'avatar' => NULL,
                'email' => 'ziadm0176@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$r3Zsmuve/PdNPzBah0UlJuLKBjh03yNr9pzwdPLo66j4voduOvzg.',
                'remember_token' => NULL,
                'created_at' => '2025-09-11 09:55:45',
                'updated_at' => '2025-09-11 09:55:45',
            ]
        ];
        
        DB::table("users")->insert($dataTables);
    }
}