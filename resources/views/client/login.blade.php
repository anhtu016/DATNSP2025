@extends('client.layout.default')

@section('content')
<main class="d-flex align-items-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-primary text-white text-center py-3 rounded-top">
                        <h4 class="mb-0">Đăng Nhập</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
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

                            <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
                                <i class="ti-unlock"></i> Đăng nhập
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{route('password.request')}}" class="text-decoration-none">🔄 Quên mật khẩu?</a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <p class="mb-0">Chưa có tài khoản? 
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
