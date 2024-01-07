<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Incoming;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'surname' => 'Compagnoni',
            'name' => 'Paolo',
            'email' => 'compagnonipaolo95@gmail.com',
            'password' => Hash::make('qwerty'),
        ]);

        Category::create([
                'name' => 'Cibo',
                'description' => 'Spese al supermercato ed altri',
                'type' => 'Primaria',
        ]);    
        
        Category::create([
            'name' => 'Stipendio',
            'description' => 'Stipendio lavoro',
            'type' => 'Primaria',
        ]);  
        
        Incoming::create([
            'category_id' => 2,
            'user_id' => 1,
            'title' => 'Stipendio SELDA',
            'amount' => 1400.00,
        ]);

        Expense::create([
            'category_id' => 1,
            'user_id' => 1,
            'title'=> 'Spesa al supermercato',
            'amount' => 14.00,
        ]);
        
    }
}
