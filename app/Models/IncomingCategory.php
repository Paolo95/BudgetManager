<?php

namespace App\Models;

use App\Models\Incoming;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomingCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'incoming_categories';

    public function incomings(): HasMany
    {
        return $this->hasMany(Incoming::class);
    }
}
