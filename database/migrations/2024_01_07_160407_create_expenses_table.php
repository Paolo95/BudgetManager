<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('expense_category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('deadline_id')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->float('amount');

            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
              
            $table->foreign('deadline_id')
                ->references('id')
                ->on('deadlines')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
