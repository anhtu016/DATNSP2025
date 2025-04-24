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
        public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}

public function paymentMethod()
{
    return $this->belongsTo(PaymentMethod::class);
}

public function shippingMethod()
{
    return $this->belongsTo(ShippingMethod::class);
}
public function getStatusBadgeClass()
{
    switch ($this->order_status) {
        case 'pending': return 'warning';
        case 'processing': return 'primary';
        case 'delivering': return 'secondary';
        case 'shipped': return 'info';
        case 'delivered': return 'success';
        case 'cancelled': return 'danger';
        case 'cancel_requested': return 'dark';
        default: return 'secondary';
    }
}

    
}
