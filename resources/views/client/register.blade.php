<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 95vh;">
        <div class="col-lg-10 shadow-lg rounded-4 overflow-hidden d-flex p-0 bg-white">
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('./client/img/blog-3.jpg') }}" 
                     alt="Register Illustration" 
                     class="img-fluid h-100 w-100" 
                     style="object-fit: cover;">
            </div>
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">🎉 Tạo Tài Khoản</h2>
                    <p>Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Đăng nhập ngay</a>
                    </p>
                </div>

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

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success rounded-3 shadow-sm fw-bold py-2">
                            🚀 Đăng ký ngay
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Bằng cách đăng ký, bạn đồng ý với 
                        <a href="#" class="text-decoration-none">Điều khoản & Chính sách bảo mật</a>.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

