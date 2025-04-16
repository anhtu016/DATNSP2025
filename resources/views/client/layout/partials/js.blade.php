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