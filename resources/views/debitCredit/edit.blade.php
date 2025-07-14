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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cash Book Update</a></li>
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
                    <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Update Entry</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('cashbook.update',$data->debit_credit_id)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Select Project*</label>
                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                <option disabled>Select Project</option>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->project_id}}" {{($data->project_id == $project->project_id) ? 'selected':''}}>{{$project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Supplier*</label>
                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                <option disabled>Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->supplier_id}}" {{($data->supplier_id == $project->supplier_id) ? 'selected':''}}>{{$supplier->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if($data->debit)
                                            <div class="form-group">
                                                <label>Amount*</label>
                                                <input type="number" class="form-control input-default" name="debit" value="{{$data->debit}}" required>
                                            </div>
                                        @endif
                                        @if($data->credit)
                                            <div class="form-group">
                                                <label>Amount*</label>
                                                <input type="number" class="form-control input-default" name="credit" value="{{$data->credit}}" required>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Note*</label>
                                            <textarea class="form-control" rows="4" id="comment" name="note" value="{{$data->note}}" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
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
@endsection
