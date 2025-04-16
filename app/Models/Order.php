<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
class Order extends Model
{
        protected $table = 'order';

        protected $fillable = [
            'total_amount',
            'shipping_address',
            'order_date',
            'shipping_method_id',
            'payment_methods_id',
            'phone_number',
            'customer_id',
            'order_status',
        ];
    
        public $timestamps = true;
        public function orderDetail()
        {
            return $this->hasMany(OrderDetail::class);
        }
        
    
}
