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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cash Book Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('report.cashbook')}}" method="post" target="_blank">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Form Date</label>
                                                <input type="date" class="form-control" name="form">
                                            </div>
                                            <div class="col-sm-4 mt-2 mt-sm-0">
                                                <label>To Date</label>
                                                <input type="date" class="form-control" name="to">
                                            </div>
                                            <div class="col-sm-4 mt-4">
                                                <button type="submit" class="btn btn-rounded btn-primary mb-2">Report</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Wise Cashbook Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('report.project')}}" method="post" target="_blank">
                                        @csrf
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Select Project*</label>
                                                    <select class="form-control form-control-lg default-select" name="project_id" required>
                                                        <option disabled selected>Select Project</option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->project_id}}">{{$project->project_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mt-4">
                                                <button type="submit" class="btn btn-rounded btn-primary mb-2">Report</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Supplier Profile Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('report.supplier')}}" method="post" target="_blank">
                                        @csrf
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Select Supplier*</label>
                                                    <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                        <option disabled selected>Select Supplier</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mt-4">
                                                <button type="submit" class="btn btn-rounded btn-primary mb-2">Report</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Purchaser Profile Report</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('report.purchaser')}}" method="post" target="_blank">
                                        @csrf
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Select Purchaser*</label>
                                                    <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                        <option disabled selected>Select Purchaser</option>
                                                        @foreach($purchasers as $purchaser)
                                                            <option value="{{$purchaser->supplier_id}}">{{$purchaser->supplier_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mt-4">
                                                <button type="submit" class="btn btn-rounded btn-primary mb-2">Report</button>
                                            </div>
                                        </div>
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

