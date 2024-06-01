<?php

namespace App\Models;

use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\IncomingCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incoming extends Model
{
    protected $table = 'incomings';

    public $timestamps = false;

    use HasFactory;

    public function incomingCategory(): BelongsTo
    {
        return $this->belongsTo(IncomingCategory::class);
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

  
}
