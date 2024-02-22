<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    public function types()
    {
        return $this->hasMany('App\Models\Type', 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany('App\Models\Brand', 'category_id', 'id');
    }
}
