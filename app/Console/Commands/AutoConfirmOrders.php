<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class AutoConfirmOrders extends Command
{
    protected $signature = 'orders:auto-complete';
    protected $description = 'Tự động đánh dấu đơn hàng là completed sau 7 ngày nếu user không xác nhận';

    public function handle()
    {
        $orders = Order::where('order_status', 'delivered')
            ->whereNotNull('delivered_at')
            ->where('delivered_at', '<=', Carbon::now()->subDays(7))
            ->get();

        foreach ($orders as $order) {
            $order->update([
                'order_status' => 'completed',
            ]);
            $this->info("Đơn hàng #{$order->id} đã được tự động chuyển sang 'completed'");
        }

        $this->info("Hoàn tất xử lý đơn hàng.");
    }
}

