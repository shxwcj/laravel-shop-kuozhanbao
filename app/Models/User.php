<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\HashIdHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Watson\Rememberable\Rememberable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    //id->hash数据ID
    use HashIdHelper;
    //全局搜索过滤
    use Filterable;
    //数据缓存
    use Rememberable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const FILTERABLE = [
        'name',
    ];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'user_favorite_products')
            ->withTimestamps()
            ->orderBy('user_favorite_products.created_at', 'desc');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function filterName(Builder $query, $name)
    {
        return $query->where('name', 'like',"%$name%");
    }

    public function getAllCached()
    {
        return $this->remember($this->cache_expire_in_minutes)->get();
    }
}
