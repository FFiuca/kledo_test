<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Status;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::truncate();

        $now = Carbon::now()->format('Y-m-d H:i:s');

        Status::insert([
            ['name' => 'waiting', 'created_at'=> $now],
            ['name' => 'approved', 'created_at'=> $now],
        ]);
    }
}
