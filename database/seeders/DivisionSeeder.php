<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Division::find(1) === null) {
            Division::create(
                [
                    'id' => 1,
                    'name' => 'Дивизион A'
                ]
            );
        }

        if(Division::find(2) === null) {
            Division::create(
                [
                    'id' => 2,
                    'name' => 'Дивизион B'
                ]
            );
        }
    }
}
