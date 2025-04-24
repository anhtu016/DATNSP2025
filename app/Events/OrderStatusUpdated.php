<?php
namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // nếu muốn gửi ngay

class OrderStatusUpdated implements ShouldBroadcastNow{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('orders.' . $this->order->id);
    }

    public function broadcastAs()
    {
        return 'OrderStatusUpdated';
    }

    public function broadcastWith()
    {
        $statusLabels = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý đơn hàng',
            'delivering' => 'Đang giao hàng',
            'shipped' => 'Đã giao hàng',
            'delivered' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            'cancel_requested' => 'Yêu cầu hủy',
        ];
    
        return [
            'order_id' => $this->order->id,
            'order_status' => $statusLabels[$this->order->order_status] ?? 'Không xác định',
            'is_confirmed' => $this->order->is_confirmed, 
        ];
    }    
    
}
