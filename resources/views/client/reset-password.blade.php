@extends('client.layout.default')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 12px;">
        <div class="card-header bg-success text-white text-center py-3">
            <h4 class="mb-0">🔑 Đặt Lại Mật Khẩu</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label class="form-label fw-bold">📧 Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">🔒 Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control rounded-pill" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">🔄 Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-pill" required>
                </div>
                <button type="submit" class="btn btn-success w-100 rounded-pill py-2">
                    Đặt Lại Mật Khẩu
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
