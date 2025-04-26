<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Order;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    // Kiểm tra nếu người dùng có quyền xem đơn hàng này
    return $user->id === Order::find($orderId)->user_id; // Chỉ cho phép người dùng có id trùng với người đặt hàng
});







