@extends('client.layout.default')

@section('content')
<div class="container margin_60_35">
    <h2 class="text-center">Mã giảm giá</h2>
    @if ($coupons->isNotEmpty())
        <div class="coupons-container">
            @foreach ($coupons as $coupon)
            <div class="coupon-card {{ \Carbon\Carbon::parse($coupon->end_date)->isPast() ? 'expired' : '' }}">
                <div class="coupon-image">
                    <img src="{{ asset('client/img/coupon.jpg') }}"/>
                </div>
                <div class="coupon-info">
                    <h3>
                        Mã:
                        <strong id="code-{{ $coupon->id }}">{{ $coupon->code }}</strong>
                        @if (!\Carbon\Carbon::parse($coupon->end_date)->isPast())
                            <button class="copy-btn" onclick="copyToClipboard('{{ $coupon->id }}')">Sao chép</button>
                        @else
                            <span class="expired-label">(Hết hạn)</span>
                        @endif
                    </h3>
                    <p>
                        Giảm giá:
                        @if ($coupon->type === 'percentage')
                            {{ $coupon->value }}%
                        @elseif($coupon->type === 'fixed')
                            {{ number_format($coupon->value, 0, ',', '.') }}₫
                        @endif
                    </p>
                    @if ($coupon->min_order_value)
                        <p>Đơn tối thiểu: {{ number_format($coupon->min_order_value, 0, ',', '.') }}₫</p>
                    @endif
                    @if ($coupon->max_discount_value)
                        <p>Giảm tối đa: {{ number_format($coupon->max_discount_value, 0, ',', '.') }}₫</p>
                    @endif
            
                    <p>Hết hạn: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</p>
                    <p>Đã sử dụng: {{ $coupon->usage_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}</p>
                    <p>Còn lại: {{ isset($coupon->usage_limit) ? max(0, $coupon->usage_limit - ($coupon->usage_count ?? 0)) : '∞' }}</p>
                </div>
            </div>
            
            @endforeach
        </div>
    @else
        <p>Hiện tại chưa có mã giảm giá nào.</p>
    @endif
</div>

    
@endsection
