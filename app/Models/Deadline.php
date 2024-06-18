<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deadline extends Model
{
    use HasFactory;

    protected $table = 'deadlines';

    public $timestamps = false;

    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    
}
