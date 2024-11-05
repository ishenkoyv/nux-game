<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'link', 'expires_at', 'is_active'];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * isExpired
     *
     * @access public
     * @return bool
     */
    public function isExpired(): bool
    {
        return (new Carbon($this->expires_at))->isPast();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'link';
    }
}
