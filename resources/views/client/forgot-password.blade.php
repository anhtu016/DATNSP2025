@extends('client.layout.default')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 12px;">
        <div class="card-header bg-primary text-white text-center py-3" style="border-radius: 8px 8px 0 0;">
            <h4 class="mb-0">🔒 Quên Mật Khẩu</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <p class="text-muted text-center">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">📧 Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" placeholder="Nhập email của bạn" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                    Gửi Link Đặt Lại Mật Khẩu
                </button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-primary">
                    <i class="bi bi-arrow-left"></i> Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
