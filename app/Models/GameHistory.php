<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    use HasFactory;

    const WINNINGS_WIN = 'Win';
    const WINNINGS_LOSE = 'Lose';

    protected $fillable = [
        'user_id',
        'played_at',
        'number',
        'result',
        'winnings',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
