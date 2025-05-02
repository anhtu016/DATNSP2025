<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 95vh;">
        <div class="col-lg-10 shadow-lg rounded-4 overflow-hidden d-flex p-0 bg-white">
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('./client/img/blog-3.jpg') }}" 
                     alt="Login Image" 
                     class="img-fluid h-100 w-100" 
                     style="object-fit: cover;">
            </div>
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center" style="min-height: 500px;">
                <div class="text-center mb-4">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
        
                <!-- Thông báo thành công -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <h3 class="fw-bold text-primary">🔐 Đăng nhập</h3>
                    <p class="text-muted">Vui lòng nhập thông tin tài khoản của bạn</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">📧 Email</label>
                        <input type="email" name="email" class="form-control rounded-pill" placeholder="Nhập email của bạn" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">🔑 Mật khẩu</label>
                        <input type="password" name="password" class="form-control rounded-pill" placeholder="********" required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                        🚪 Đăng nhập
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-warning fw-semibold">❓ Quên mật khẩu?</a>
                    <br>
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold mt-2 d-inline-block">📌 Chưa có tài khoản? Đăng ký</a>
                    <br>
                    <a href="{{ route('home') }}" class="text-decoration-none text-primary fw-semibold mt-2 d-inline-block">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
