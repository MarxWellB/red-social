<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeletionRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_account_id',
        'email',
        'reason',
    ];

    public function userAccount()
    {
        return $this->belongsTo(User::class);
    }
}
