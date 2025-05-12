<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Lead;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $lead = Lead::create([
            'name' => 'John Doe'
        ]);

        $service = Service::create([
            'name' => 'Website'
        ]);

        $sale = $lead->sales()->create([
            'service_id' => $service->id,
            'value' => 1000,
            'user_id' => '1',
        ]);
    }
}
