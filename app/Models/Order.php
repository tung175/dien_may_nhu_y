<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'address', 'otherpeople_name', 'otherpeople_phone', 'otherpeople_gender', 'way_receive', 'payment', 'note', 'status'];
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public $timestamps = false;

    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function orderDetails() {
        return $this->hasMany('App\Models\OrderDetails', 'order_id');
    }
}
