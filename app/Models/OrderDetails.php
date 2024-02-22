<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity'];
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
