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
                                <h4 class="card-title">Update product purchase data.</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('purchase-product.update', $purchase_id->product_purchase_id)}}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="form-group">
                                            <label>Select Seller*</label>
                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                @foreach($suppliers as $seller)
                                                    <option value="{{$seller->supplier_id}}" @if($seller->supplier_id == $purchase_id->supplier_id) selected @endif>{{$seller->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Project*</label>
                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->project_id}}" @if($project->project_id == $purchase_id->project_id) selected @endif>{{$project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Product*</label>
                                            <select class="form-control form-control-lg default-select" name="product_id" required>
                                                @foreach($products as $product)
                                                    <option value="{{$product->product_id}}" @if($product->product_id == $purchase_id->product_id) selected @endif>{{$product->product_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" class="form-control input-default" value="{{$purchase_id->quantity}}" name="quantity" id="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <input type="text" class="form-control input-default" value="{{$purchase_id->unit}}" name="unit" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Unit Price</label>
                                            <input type="text" class="form-control input-default" value="{{$purchase_id->unit_price}}" name="unit_price" id="unit_price" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Price</label>
                                            <input type="text" class="form-control input-default" value="{{$purchase_id->total_price}}" name="total_price" id="total_price" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="4" id="comment" spellcheck="false" name="note">{{$purchase_id->note}}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Update</button>
                                    </form>
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
