<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // reset
        $createdAt = Carbon::now();

        DB::table('oauth_clients')->truncate();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $team = Team::factory()->create([
            'user_id' => 1,
            'name' => '테스트팀',
            'personal_team' => 1,
        ]);

        $user = User::factory()->create([
            'name' => '채우형',
            'email' => 'chaewh@ppickup.net',
            'password' => '$2y$10$JTB5E6P1yQi7bhOz5O2dGeW06hy7g2O5Y5E98w1C.IcLFkFnync52',
            'current_team_id' => $team->id,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
       ]);

//        User::factory()->create([
//            'name' => '채우형',
//            'email' => 'hongs@ppickup.net',
//            'password' => '$2y$10$fWX1p14mUzOjjCJ3TWr8te6XTQlfPikzOibnoGXAzuw.fjNEX5lAK',
//       ]);

        DB::table('oauth_clients')->insert([
            ['id' => 1, 'user_id' => $user->id, 'name' => $user->email, 'secret' => 'DT9bPjML6DIY6R66I02z5wq9kwvEHLF8OMy41P8N', 'provider' => '', 'redirect' => 'http://localhost/auth/callback', 'personal_access_client' => 0, 'password_client' => 0, 'revoked' => 0, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['id' => 2, 'user_id' => $user->id, 'name' => $user->email, 'secret' => 'p8kKQCqGiGeq5SRVhAa7LI0lPSfpvFbcpHykNOmO', 'provider' => '', 'redirect' => 'http://localhost/auth/callback', 'personal_access_client' => 0, 'password_client' => 0, 'revoked' => 0, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['id' => 3, 'user_id' => $user->id, 'name' => $user->email, 'secret' => 'nQnNkzESIZAkHbzJdGtmxFmL8yTQJQ2quYNgJerg', 'provider' => 'users', 'redirect' => 'http://localhost/auth/callback', 'personal_access_client' => 0, 'password_client' => 1, 'revoked' => 0, 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
