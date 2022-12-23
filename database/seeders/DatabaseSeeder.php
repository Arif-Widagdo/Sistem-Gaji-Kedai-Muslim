<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
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
        //  Position Seed
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
        \App\Models\Position::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Pasang Kancing',
            'slug' => 'pasang-kancing',
            'status_act' => 1,
        ]);

        $positions = \App\Models\Position::all();

        foreach ($positions as $position) {
            \App\Models\User::factory()->create([
                'id' => Uuid::uuid4()->toString(),
                'id_position' => $position->id,
                'name' => fake()->name(),
                'email' => $position->slug . '@example.com',
                'status_act' => 1,
                'gender' => fake()->randomElement(['F', 'M']),
                'telp' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }

        $position_id = \App\Models\Position::where('slug', '=', 'finishing')->first();

        \App\Models\User::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'id_position' => $position_id->id,
            'name' => 'Arif Widagdo',
            'email' => 'arifwidagdo24@gmail.com',
            'status_act' => 1,
            'gender' => 'M',
            'telp' => '089623085349',
            'address' => 'Jl. Serdang Baru XII, RT.005/RW.05, Kec. Kemayoran, Kel.Serdang, DKI Jakarta, Jakarta Pusat (10650)',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'id_position' => $position_id->id,
            'name' => 'Agqila Fadiahaya',
            'email' => 'agqilafh@gmail.com',
            'status_act' => 1,
            'gender' => 'F',
            'telp' => '6288287853101',
            'address' => 'Jl. Kota Bandung',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);


        // Product Category Seed
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Gamis',
            'slug' => 'gamis',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Koko',
            'slug' => 'koko',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Sirwal Celana',
            'slug' => 'sirwal-celana',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Mukena',
            'slug' => 'mukena',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Hijab Syari',
            'slug' => 'hijab-syari',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Sarung',
            'slug' => 'sarung',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Manset',
            'slug' => 'manset',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Cadar',
            'slug' => 'cadar',
        ]);
        \App\Models\Category::factory()->create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Peci',
            'slug' => 'peci',
        ]);


        $categories = \App\Models\Category::all();

        // Service Seed
        foreach ($categories as $category) {
            foreach ($positions->where('slug', '!=', 'owner') as $position) {
                \App\Models\Service::factory()->create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_position' => $position->id,
                    'id_category' => $category->id,
                    'sallary' => mt_rand(500, 2500),
                ]);
            }
        }

        $users = \App\Models\User::where('name', '!=', 'Owner')->get();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                \App\Models\Product::factory()->create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_category' => $category->id,
                    'id_user' => $user->id,
                    'name' => $category->name . ' ' . fake()->colorName(),
                    'quantity' => mt_rand(5, 50),
                    'completed_date' => Carbon::today()->subDays(rand(0, 365))
                ]);

                \App\Models\Product::factory()->create([
                    'id' => Uuid::uuid4()->toString(),
                    'id_category' => $category->id,
                    'id_user' => $user->id,
                    'name' => $category->name . ' ' . fake()->colorName(),
                    'quantity' => mt_rand(5, 50),
                    'completed_date' => Carbon::today()->subDays(rand(0, 365))
                ]);
            }
        }
    }
}
