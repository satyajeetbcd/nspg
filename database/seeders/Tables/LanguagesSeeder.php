<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
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
         * artisan seed:generate --table-mode --tables=languages,settings --limit=200
         *
         */

        $currentTime = now();

        $dataTables = [
            [
                'id' => 1,
                'code' => 'en',
                'full_name' => 'English',
                'created_at' => $currentTime,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'code' => 'ar',
                'full_name' => 'عربي',
                'created_at' => $currentTime,
                'updated_at' => null,
            ]
        ];

        DB::table("languages")->insert($dataTables);
    }
}
