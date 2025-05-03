@extends('client.layout.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h4 class="card-title mb-0"><i class="fas fa-star me-2"></i>Đánh giá đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('orders.reviews.create', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 120px">Sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Biến thể</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                            <th>Đánh giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . ($item->product->thumbnail ?? 'default.png')) }}"
                                                    class="img-thumbnail" width="100px" alt="">
                                            </td>
                                            <td class="align-middle">{{ $item->product->name ?? 'N/A' }}</td>
                                            <td class="align-middle">
                                                @if ($item->variant && $item->variant->attributeValues)
                                                    @foreach ($item->variant->attributeValues as $value)
                                                        <span class="badge bg-info">{{ $value->attribute->name }}:
                                                            {{ $value->value }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">---</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ number_format($item->price) }}đ</td>
                                            <td class="align-middle">{{ $item->quantity }}</td>
                                            <td class="align-middle">{{ number_format($item->price * $item->quantity) }}đ</td>
                                            <td class="align-middle">
                                                <div class="review-section">
                                                    <div class="rating-container">
                                                        
                                                        <div class="rating d-flex justify-content-center">
                                                            <select name="rating[{{ $item->id }}]" class="form-select" style="width: auto;">
                                                                <option value="">-- Chọn số sao --</option>
                                                                <option value="1">⭐ </option>
                                                                <option value="2">⭐⭐ </option>
                                                                <option value="3">⭐⭐⭐ </option>
                                                                <option value="4">⭐⭐⭐⭐ </option>
                                                                <option value="5">⭐⭐⭐⭐⭐ </option>
                                                            </select>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="comment-section">
                                                        <div class="comment-header">
                                                            <i class="fas fa-comment-alt text-primary me-2"></i>
                                                            <span class="comment-title" name="description">Bình luận của bạn</span>
                                                        </div>
                                                        <textarea name="description[{{ $item->id }}]" 
                                                            class="form-control" 
                                                            rows="5"
                                                            cols="40" 
                                                            style="overflow :hidden;
                                                            resize: none;"
                                                            
                                                            placeholder="Nhập bình luận của bạn về sản phẩm này..."></textarea>
                                                            <div class="mt-3">
                                                                <label for="" class="form-label">Tải ảnh đánh giá (nếu có):</label>
                                                                <input type="file" name="image[{{ $item->id }}]">

                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')
    <script>
        // Tự động ẩn thông báo sau 5 giây
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    </script>
@endpush
