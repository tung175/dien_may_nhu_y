<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'category_id', 'brand_id', 'type_id', 'description', 'image', 'price', 'warranty'];
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type', 'type_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany('App\Models\Color', 'products_colors');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image', 'product_id', 'id');
    }

    public function post() 
    {
        return $this->hasOne('App\Models\Post');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'product_id', 'id');
    }
}
