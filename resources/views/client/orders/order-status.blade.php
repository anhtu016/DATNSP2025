<p><strong>Trạng thái:</strong>
    <td>
        @switch($order->order_status)
            @case('pending')
                <span class="badge bg-warning">Chờ xử lý</span>
                @break
            @case('processing')
                <span class="badge bg-primary">Đang xử lý đơn hàng</span>
                @break
            @case('delivering')
                <span class="badge bg-secondary">Đang giao hàng</span>
                @break
            @case('shipped')
                <span class="badge bg-info">Đã giao hàng</span>
                @break
            @case('delivered')
                <span class="badge bg-success">Hoàn tất</span>
                @break
            @case('cancelled')
                <span class="badge bg-danger">Đã hủy</span>
                @break
            @case('cancel_requested')
                <span class="badge bg-dark">Yêu cầu hủy</span>
                @break
            @default
                <span class="badge bg-secondary">Không xác định</span>
        @endswitch
        
    </td>
</p>

<!-- Thông báo số ngày sau khi giao hàng -->
@if ($daysSinceDelivered !== null)
    <p><strong>Đơn hàng đã giao được {{ $daysSinceDelivered }} ngày.</strong></p>
@endif

<!-- Nút Xác nhận hoàn thành -->
@if ($order->order_status === 'delivered')
    @if (!$order->is_confirmed)
        <form action="{{ route('user.orders.confirm', $order->id) }}" method="POST"
            onsubmit="return confirm('Bạn xác nhận đơn hàng đã hoàn tất?')">
            @csrf
            @method('PUT')
            <button class="btn btn-success mt-2">✅ Xác nhận đã hoàn thành đơn hàng</button>
        </form>
    @else
        <p class="text-success mt-2">
            <strong>✅ Bạn đã xác nhận đơn hàng này hoàn tất vào
                {{ \Carbon\Carbon::parse($order->confirmed_at)->format('d/m/Y H:i') }}</strong>
        </p>
    @endif
@endif

<!-- Nút Hủy đơn hàng -->
@if ($order->order_status === 'pending')
    <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST"
        onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
        @csrf
        @method('PUT')
        <button class="btn btn-danger mt-3">❌ Hủy đơn hàng</button>
    </form>
@endif
