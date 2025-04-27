@extends('client.layout.default')
@section('content')
<div class="container my-5">
    <div class="card shadow-lg rounded-4 p-4">
        <h1 class="text-center mb-5" style="font-weight: bold;">Chính Sách Đổi Trả & Hoàn Tiền</h1>

        <div class="mb-5">
            <h4 class="">I. Đối tượng áp dụng</h4>
            <p>Các khách hàng mua hàng online hoặc mua hàng tại hệ thống Allaia trên toàn quốc.</p>
            <p>Vui lòng đọc kĩ chính sách và điều khoản trước khi trả hàng ! Cảm ơn bạn đã ghé shop</p>
            <p ><a href="" class="text-primary">click vào đây !</a> nếu bạn muốn đổi trả</p>
        </div>

        <div class="mb-5">
            <h4 class="">II. Chính sách đổi trả và hoàn tiền</h4>

     
            <div class="mb-4">
                <h5 class="">1. Quy định đổi hàng</h5>

                <h6 class="mt-3">1.1 Nội dung</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Sản phẩm nguyên giá & giảm giá đến 30% được đổi size/màu hoặc sản phẩm khác (nếu còn hàng), áp dụng 1 đổi 1, đổi 1 lần/1 đơn hàng.</li>
                    <li class="list-group-item">Tổng giá trị các mặt hàng muốn đổi phải tương đương hoặc lớn hơn với mặt hàng trả lại. Shop không hoàn lại tiền thừa nếu sản phẩm mới có giá trị thấp hơn.</li>
                    <li class="list-group-item">Sản phẩm giảm giá trên 30% chỉ được đổi size (nếu còn hàng), áp dụng 1 đổi 1, đổi 1 lần/1 đơn hàng.</li>
                    <li class="list-group-item">Sản phẩm không áp dụng đổi bao gồm: đồ lót, sản phẩm tặng kèm.</li>
                    <li class="list-group-item">Khách hàng đổi sản phẩm tại cửa hàng đã mua hàng.</li>
                </ul>

                <h6 class="mt-4">1.2 Điều kiện đổi sản phẩm</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Đổi hàng trong vòng 07 ngày kể từ ngày nhận sản phẩm.</li>
                    <li class="list-group-item">Sản phẩm còn nguyên tem, nhãn mác, chưa qua giặt ủi hoặc bẩn, chưa sử dụng.</li>
                    <li class="list-group-item">Không có mùi lạ (nước hoa, cơ thể...), không bị hư hỏng.</li>
                    <li class="list-group-item">Có hóa đơn mua hàng còn nguyên vẹn.</li>
                </ul>
            </div>


            <div class="mb-4">
                <h5 class="">2. Quy định trả hàng</h5>

                <h6 class="mt-3">2.1 Chính sách trả hàng</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Khách hàng được trả sản phẩm nếu sản phẩm lỗi từ nhà sản xuất và không có nhu cầu đổi sang sản phẩm khác.</li>
                    <li class="list-group-item">Lỗi bao gồm: phai/loang màu, in bong tróc, lỗi đường may.</li>
                    <li class="list-group-item">Hoàn tiền sản phẩm lỗi qua tài khoản ngân hàng.</li>
                    <li class="list-group-item">Shop chịu 100% chi phí vận chuyển nếu sản phẩm lỗi.</li>
                    <li class="list-group-item">Hoàn tiền với sản phẩm không giao được (áp dụng mua hàng online trả trước).</li>
                    <li class="list-group-item">Xác minh lỗi trong vòng 01 - 03 ngày sau khi nhận sản phẩm.</li>
                </ul>

                <h6 class="mt-4">2.2 Điều kiện trả sản phẩm</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Trả sản phẩm trong vòng 10 ngày kể từ ngày nhận sản phẩm.</li>
                </ul>
            </div>

            <div class="mb-4">
                <h5 class="">3. Chính sách hoàn tiền</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Khách hàng thanh toán trước được hoàn tiền nếu sản phẩm lỗi do sản xuất và không muốn đổi sản phẩm.</li>
                    <li class="list-group-item">Thời gian hoàn tiền từ 03 đến 05 ngày sau khi xác minh lỗi sản phẩm.</li>
                    <li class="list-group-item">Tiền hoàn về tài khoản ngân hàng cá nhân của khách hàng.</li>
                </ul>
            </div>
        </div>

        <!-- Liên hệ hỗ trợ -->
        <div class="text-center mt-5">
            <p>Nếu cần hỗ trợ hoặc phản hồi, vui lòng liên hệ hotline chăm sóc khách hàng:</p>
            <h4 class="text-danger">0966 237 369</h4>
        </div>

        <!-- Nút về trang chủ -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                Về trang chủ
            </a>
        </div>

    </div>
</div>
@endsection
