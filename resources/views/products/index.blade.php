@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h1>Product Catalog</h1>
        <button class="btn btn-primary" id="addNewProduct">+ Add New</button>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal for Add/Edit Form -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        @csrf
                        {!! Form::hidden('product_id', '', ['id' => 'product_id']) !!}
                        <div class="form-group">
                            {!! Form::label('sku', 'SKU') !!}
                            {!! Form::text('sku', null, ['class' => 'form-control', 'required' => true, 'id' => 'sku']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('product_name', 'Product Name') !!}
                            {!! Form::text('product_name', null, ['class' => 'form-control', 'required' => true, 'id' => 'product_name']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true, 'id' => 'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('price', 'Price') !!}
                            {!! Form::number('price', null, ['class' => 'form-control', 'required' => true, 'id' => 'price']) !!}
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.data') }}",
            columns: [
                {data: 'sku', name: 'sku'},
                {data: 'product_name', name: 'product_name'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Show Add Modal
        $('#addNewProduct').click(function () {
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modalTitle').text("Add New Product");
            $('#productModal').modal('show');
        });

        // Handle Form Submission
        $('#productForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('products.store') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    $('#productModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function (xhr) {
                    alert('Something went wrong.');
                }
            });
        });

        // Edit and Delete Actions
        $('body').on('click', '.editProduct', function () {
            var id = $(this).data('id');
            $.get("{{ route('products.index') }}" + '/' + id + '/edit', function (data) {
                $('#modalTitle').text("Edit Product");
                $('#productModal').modal('show');
                $('#product_id').val(data.id);
                $('#sku').val(data.sku);
                $('#product_name').val(data.product_name);
                $('#description').val(data.description);
                $('#price').val(data.price);
            });
        });

        $('body').on('click', '.deleteProduct', function () {
            var id = $(this).data('id');
            confirm("Are you sure to delete this product?");
            $.ajax({
                type: "DELETE",
                url: "{{ route('products.destroy', '') }}/" + id,
                success: function (data) {
                    table.ajax.reload();
                    alert(data.success);
                },
                error: function (xhr) {
                    alert('Something went wrong.');
                }
            });
        });
    });
</script>
@endsection
