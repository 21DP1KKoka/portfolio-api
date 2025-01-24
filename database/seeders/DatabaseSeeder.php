<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PersonalInfo;
use App\Models\ProjectInfo;
use App\Models\StackInfo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([  
            'name' => 'Tester',
            'email' => 'test@test.t',
            'password' => Hash::make('test1234'),
        ]);
        User::create([  
            'name' => 'Tester',
            'email' => 't@t.t',
            'password' => Hash::make('12345678'),
        ]);

        PersonalInfo::create([
            'user_id' => 1,
            'name' => 'Kristiāns Kokars',
            'contents' => 'Sveiki, esmu programmēšanas tehniķis no Rīgas Valsts tehnikuma grupas DP4-1.',
        ]);

        StackInfo::create([
            'user_id' => 1,
            'technology_name' => 'PHP',
            'proficiency' => 'Advanced',
        ]);

        ProjectInfo::create([
            'user_id' => 1,
            'project_name' => 'Internetveikals "Murrātava"',
            'project_description' => 'Internetveikals kaķu entuziastiem, kur iespējams iegādāties visu kaķim nepieciešamo, pat pašu kaķi!'
        ]);

        PersonalInfo::create([
            'user_id' => 2,
            'name' => 'test1',
            'contents' => 't1t1t1t11t1t1tt1t',
        ]);

        StackInfo::create([
            'user_id' => 2,
            'technology_name' => 'PHP',
            'proficiency' => 'Eksperts',
        ]);
        StackInfo::create([
            'user_id' => 2,
            'technology_name' => 'Laravel',
            'proficiency' => 'Iesācējs',
        ]);

        ProjectInfo::create([
            'user_id' => 2,
            'project_name' => 'Veikals',
            'project_description' => 'shoping time'
        ]);
        ProjectInfo::create([
            'user_id' => 2,
            'project_name' => 'Bode',
            'project_description' => 'Boding time'
        ]);
        
    }
}
