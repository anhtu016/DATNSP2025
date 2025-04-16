<h5>Danh sách biến thể của sản phẩm: {{ $product->name }}</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SKU</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thuộc tính</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product->variants as $variant)
            <tr>
                <td>{{ $variant->sku }}</td>
                <td>{{ $variant->price }}</td>
                <td>{{ $variant->quantity }}</td>
                <td>
                    @foreach($variant->attributeValues as $value)
                        <span class="badge bg-secondary">{{ $value->attribute->name }}: {{ $value->value }}</span>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
