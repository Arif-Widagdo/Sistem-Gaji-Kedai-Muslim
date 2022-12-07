<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Position::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Owner',
            'slug' => 'owner',
            'status_act' => 1,
        ]);
        \App\Models\Position::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Setrika',
            'slug' => 'setrika',
            'status_act' => 1,
        ]);
        \App\Models\Position::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Finishing',
            'slug' => 'finishing',
            'status_act' => 1,
        ]);
        \App\Models\Position::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Packing',
            'slug' => 'packing',
            'status_act' => 1,
        ]);

        $positions = \App\Models\Position::all();

        foreach ($positions as $position) {
            \App\Models\User::factory()->create([
                'id' => Uuid::uuid4()->toString(),
                'id_position' => $position->id,
                'name' => $position->name,
                'email' => $position->name . '@example.com',
                'status_act' => 1,
                'gender' => 'M',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
