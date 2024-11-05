<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'phonenumber',
    ];

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    /**
     * getLastActiveLink
     *
     * @access public
     * @return ?Link
     */
    public function getLastActiveLink(): ?Link
    {
        return $this->hasOne('App\Models\Link')
            ->where([['is_active', true]])
            ->latest()
            ->first();
    } // End function getLastActiveLink

    /**
     * generateLink
     *
     * @access public
     * @return Link
     */
    public function generateLink(): Link
    {
        Link::where(['user_id' => $this->getKey(), 'is_active'=> true])->update(['is_active' => 'false']);

        return $this->links()->create([
            'link' => \Str::random(32),
            'expires_at' => now()->addDays(7),
        ]);
    }
}
