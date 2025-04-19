<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 95vh;">
        <div class="col-lg-10 col-xl-9 shadow-lg rounded-4 overflow-hidden d-flex p-0 bg-white">
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('./client/img/blog-3.jpg') }}" 
                     alt="Forgot Password" 
                     class="img-fluid h-100 w-100 object-fit-cover" 
                     style="object-fit: cover;">
            </div>
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center" style="min-height: 500px;">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">🔒 Quên Mật Khẩu</h3>
                    <p class="text-muted mb-0 fs-6">Nhập email để nhận liên kết đặt lại mật khẩu</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">📧 Email</label>
                        <input type="email" name="email" class="form-control rounded-pill fs-6" placeholder="Nhập email của bạn" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold fs-6">
                        📬 Gửi Link Đặt Lại Mật Khẩu
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold fs-6">
                        ← Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


