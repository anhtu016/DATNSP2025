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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('orders.reviews.create', $order->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            @foreach ($order->orderDetails as $item)
                                <div class="card mb-4 shadow-sm">
                                    <div class="row g-3 p-3 align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/' . ($item->product->thumbnail ?? 'default.png')) }}"
                                                alt="{{ $item->product->name }}" class="img-fluid rounded"
                                                style="max-height: 150px; object-fit: contain;">
                                        </div>
                                        <div class="col-md-9">
                                            <h5 class="mb-1">{{ $item->product->name ?? 'N/A' }}</h5>
                                            <p class="mb-1">
                                                @if ($item->variant && $item->variant->attributeValues)
                                                    @foreach ($item->variant->attributeValues as $value)
                                                        <span
                                                            class="badge bg-info text-dark me-1">{{ $value->attribute->name }}:
                                                            {{ $value->value }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có biến thể</span>
                                                @endif
                                            </p>
                                            <p class="mb-1">Giá: <strong>{{ number_format($item->price) }}đ</strong></p>
                                            <p class="mb-3">Số lượng: <strong>{{ $item->quantity }}</strong></p>

                                            <!-- Đánh giá sao -->
                                            <div class="mb-3 d-flex align-items-center gap-2">
                                                <label class="form-label fw-bold">Đánh giá sao:</label>
                                                <div class="star-rating">
                                                    @for ($star = 5; $star >= 1; $star--)
                                                        <input type="radio"
                                                            id="star{{ $star }}-{{ $item->id }}"
                                                            name="rating[{{ $item->id }}]"
                                                            value="{{ $star }}">
                                                        <label
                                                            for="star{{ $star }}-{{ $item->id }}">&#9733;</label>
                                                    @endfor
                                                </div>

                                            </div>

                                            <!-- Bình luận -->
                                            <div class="mb-3">
                                                <label for="description-{{ $item->id }}"
                                                    class="form-label fw-bold">Bình luận của bạn</label>
                                                <textarea name="description[{{ $item->id }}]" id="description-{{ $item->id }}" class="form-control"
                                                    rows="4" placeholder="Nhập bình luận của bạn về sản phẩm này..."></textarea>
                                            </div>

                                            <!-- Ảnh đánh giá -->
                                            <div class="mb-3">
                                                <label for="image-{{ $item->id }}" class="form-label fw-bold">Tải ảnh
                                                    đánh giá (nếu có)</label>
                                                <input class="form-control" type="file" id="image-{{ $item->id }}"
                                                    name="image[{{ $item->id }}]" accept="image/*">
                                            </div>

                                            <input type="hidden" name="variants_id[{{ $item->id }}]"
                                                value="{{ $item->variant_id }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Gửi đánh giá
                                </button>
                            </div>
                        </form>

                        <!-- CSS thêm cho hiệu ứng sao -->
                        <style>
             .star-rating {
    display: flex;
    flex-direction: row-reverse; /* GIỮ nguyên nếu bạn render từ 5->1 */
    justify-content: flex-start; /* <== cái này đảm bảo nằm bên trái */
    gap: 0.3rem;
    font-size: 1.8rem;
}


                            .star-rating input[type="radio"] {
                                display: none;
                            }

                            .star-rating label {
                                color: #ddd;
                                cursor: pointer;
                                transition: color 0.2s;
                            }

                            .star-rating input[type="radio"]:checked~label {
                                color: #ddd;
                                /* reset lại các sao sau */
                            }

                            .star-rating input[type="radio"]:checked+label,
                            .star-rating input[type="radio"]:checked+label~label {
                                color: #ffc107;
                            }

                            .star-rating label:hover,
                            .star-rating label:hover~label {
                                color: #ffdb70;
                            }
                        </style>


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
