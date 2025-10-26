@extends('layouts.theme')

@section('content')
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        @include('layouts.theme_navHeader')
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        @include('layouts.theme-header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layouts.theme_sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Purchase Product</a></li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        @endif
                    </div>


                    <div class="col-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add new product purchase data.</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('purchase-product.store')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>Select Seller*</label>
                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                @foreach($suppliers as $seller)
                                                    <option value="{{$seller->supplier_id}}">{{$seller->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Project*</label>
                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->project_id}}">{{$project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Product*</label>
                                            <select class="form-control form-control-lg default-select" name="product_id" required>
                                                @foreach($products as $product)
                                                    <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" class="form-control input-default" placeholder="quantity" name="quantity" id="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <input type="text" class="form-control input-default" placeholder="unit" name="unit" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Unit Price</label>
                                            <input type="text" class="form-control input-default" placeholder="price" name="unit_price" id="unit_price" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Price</label>
                                            <input type="text" class="form-control input-default" placeholder="total price" name="total_price" id="total_price" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="4" id="comment" spellcheck="false" name="note"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Purchase List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                            <th>Project</th>
                                            <th>Supplier Name</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($purchases as $purchase)
                                            <tr>
                                                <td>{{$purchase->project->project_name}}</td>
                                                <td>{{$purchase->supplier->supplier_name}}</td>
                                                <td>{{$purchase->product->product_name}}</td>
                                                <td>{{$purchase->quantity}} {{$purchase->unit}}</td>
                                                <td>{{$purchase->unit_price}}</td>
                                                <td>{{$purchase->total_price}}</td>
                                                <td>{{$purchase->note}}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('purchase-product.edit',$purchase->product_purchase_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <form action="{{ route('purchase-product.destroy', $purchase->product_purchase_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase data?');" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $purchases->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        @include('layouts.theme_footer')
        <!--**********************************
            Footer end
        ***********************************-->

    </div>
    <script>
        function calculateTotal() {
            let qty = parseFloat(document.getElementById('quantity').value) || 0;
            let price = parseFloat(document.getElementById('unit_price').value) || 0;
            document.getElementById('total_price').value = qty * price;
        }

        document.getElementById('quantity').addEventListener('input', calculateTotal);
        document.getElementById('unit_price').addEventListener('input', calculateTotal);
    </script>
@endsection
