<!-- COMMON SCRIPTS -->
<script src="{{asset('client/js/common_scripts.min.js')}}"></script>
<script src="{{asset('client/js/main.js')}}"></script>

<!-- SPECIFIC SCRIPTS -->
<script src="{{asset('client/js/carousel-home.min.js')}}"></script>
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notyf = new Notyf({
            duration: 3000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'top'
            }

        });


        notyf.success(`{!! session('success') !!}`);
    });
</script>
<style>
    .notyf {
        z-index: 99999 !important;
        position: fixed !important;
        top: 80px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>
@endif



{{-- mã giảm giá --}}
<script>
    function copyToClipboard(id) {
        const code = document.getElementById(`code-${id}`).innerText;

        // Cố gắng sao chép mã vào clipboard
        navigator.clipboard.writeText(code).then(function () {
            // Hiển thị thông báo thành công bằng SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Sao chép thành công!',
                text: 'Mã giảm giá: ' + code,
                showConfirmButton: false,
                timer: 2000 // Thông báo sẽ tự động đóng sau 2 giây
            });
        }, function () {
            // Nếu thất bại, hiển thị thông báo lỗi
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Không thể sao chép mã giảm giá.',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>


