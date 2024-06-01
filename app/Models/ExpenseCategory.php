<?php

namespace App\Models;

use App\Models\Incoming;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $table = 'expense_categories';

    public $timestamps = false;

    public function incomings(): HasMany
    {
        return $this->hasMany(Incoming::class);
    }
}
