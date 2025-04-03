@extends('client.layout.default')

@section('content')
<main class="d-flex align-items-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-primary text-white text-center py-3 rounded-top">
                        <h4 class="mb-0">🎉 Tạo Tài Khoản</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">👤 Họ và tên</label>
                                <input type="text" name="name" class="form-control rounded-3" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">📧 Email</label>
                                <input type="email" name="email" class="form-control rounded-3" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">🔑 Mật khẩu</label>
                                <input type="password" name="password" class="form-control rounded-3" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">🔄 Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-3 shadow-sm">
                                🚀 Đăng ký ngay
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <p class="mb-0">Bạn đã có tài khoản? 
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Đăng nhập ngay</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">Bằng cách đăng ký, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản & Chính sách bảo mật</a>.</small>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
