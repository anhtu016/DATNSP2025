<?php 
namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdatedListener implements ShouldQueue
{
    public function handle(OrderStatusUpdated $event)
    {
        Log::info('Trạng thái đơn hàng đã thay đổi:', [
            'order_id' => $event->order->id,
            'order_status' => $event->order->order_status,
        ]);
    }
}
