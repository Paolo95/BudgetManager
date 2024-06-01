<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deadline extends Model
{
    use HasFactory;

    protected $table = 'deadlines';

    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    
}
