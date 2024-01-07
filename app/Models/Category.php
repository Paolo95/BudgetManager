<?php

namespace App\Models;

use App\Models\Incoming;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function incomings(): HasMany
    {
        return $this->hasMany(Incoming::class);
    }
}
