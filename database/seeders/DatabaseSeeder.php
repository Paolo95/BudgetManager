<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CreditDebit;
use App\Models\Deadline;
use App\Models\User;
use App\Models\IncomingCategory;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Incoming;
use App\Models\UserTodo;
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
        
        ExpenseCategory::create([
            'type' => 'Necessità',
            'subtype' => 'Spese auto annuali',
            'description' => 'Spese per auto come RC Auto, Bollo',
        ]);  

        ExpenseCategory::create([
            'type' => 'Necessità',
            'subtype' => 'Benzina',
            'description' => 'Spese per rifornimento',
        ]); 
        
        ExpenseCategory::create([
            'type' => 'Desideri',
            'subtype' => 'Cena fuori',
            'description' => 'Cene ai ristoranti',
        ]);  

        IncomingCategory::create([
            'type' => 'Primaria',
            'subtype' => 'Stipendio',
            'description' => 'Stipendio lavoro',
        ]);  
        
        Incoming::create([
            'date' => '2024-06-12',
            'incoming_category_id' => 1,
            'user_id' => 1,
            'title' => 'Stipendio SELDA',
            'amount' => 1400.50,
        ]);

        Expense::create([
            'date' => '2024-06-15',
            'expense_category_id' => 1,
            'user_id' => 1,
            'title'=> 'Bollo',
            'amount' => 230.90,
        ]);

        Expense::create([
            'date' => '2024-06-05',
            'expense_category_id' => 1,
            'user_id' => 1,
            'title'=> 'Bollo',
            'amount' => 23.90,
        ]);

        Expense::create([
            'date' => '2024-06-25',
            'expense_category_id' => 1,
            'user_id' => 1,
            'title'=> 'Bollo',
            'amount' => 3.90,
        ]);

        Expense::create([
            'date' => '2024-06-16',
            'expense_category_id' => 2,
            'user_id' => 1,
            'title'=> 'Benzina',
            'amount' => 20.00,
        ]);

        Expense::create([
            'date' => '2024-05-19',
            'expense_category_id' => 3,
            'user_id' => 1,
            'title'=> 'Cena Sushi',
            'amount' => 50.00,
        ]);

        UserTodo::create([
            'user_id' => 1,
            'title' => 'Bollo',
            'date' => '2024-05-10',
            'amount' => 240.45,
            'isDone' => false,
        ]);

        UserTodo::create([
            'user_id' => 1,
            'title' => 'Marmitta',
            'date' => '2024-05-06',
            'amount' => 40.45,
            'isDone' => false,
        ]);

        UserTodo::create([
            'user_id' => 1,
            'title' => 'Bolletta',
            'date' => '2024-05-20',
            'amount' => 20.45,
            'isDone' => true,
        ]);

        UserTodo::create([
            'user_id' => 1,
            'title' => 'PC',
            'date' => '2024-05-20',
            'amount' => 200,
            'isDone' => true,
        ]);

        UserTodo::create([
            'user_id' => 1,
            'title' => 'Telefono',
            'date' => '2024-06-20',
            'amount' => 20.45,
            'isDone' => false,
        ]);

        CreditDebit::create([
            'user_id' => 1,
            'date' => '2024-06-20',
            'amount' => 20.45,
            'type' => 'Credito',
            'description' => 'Soldi DK'
        ]);

        Deadline::create([
            'user_id' => 1,
            'date' => '2024-06-20',
            'title' => 'Bollo',            
            'description' => 'Soldi DK',
            'amount' => 20.45,
        ]);
        
    }
}
