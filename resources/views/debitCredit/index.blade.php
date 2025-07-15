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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Cash Book</a></li>
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
                    <div class="col-12 mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#debitModal">Add Debit Entry</button>
                        <!-- Modal -->
                        <div class="modal fade" id="debitModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Debit Entry</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="basic-form">
                                                    <form action="{{route('cashbook.store')}}" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Select Project*</label>
                                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                                <option disabled selected>Select Project</option>
                                                                @foreach($projects as $project)
                                                                    <option value="{{$project->project_id}}">{{$project->project_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Select Supplier*</label>
                                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                                <option disabled selected>Select Supplier</option>
                                                                @foreach($suppliers as $supplier)
                                                                    <option value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Amount*</label>
                                                            <input type="number" class="form-control input-default" name="debit" required>
                                                        </div>
                                                        <input type="hidden" value="" name="credit"/>
                                                        <div class="form-group">
                                                            <label>Note*</label>
                                                            <textarea class="form-control" rows="4" id="comment" name="note" required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#creditModal">Add Credit Entry</button>
                        <!-- Modal -->
                        <div class="modal fade" id="creditModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Credit Entry</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="basic-form">
                                                    <form action="{{route('cashbook.store')}}" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Select Project*</label>
                                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                                <option disabled selected>Select Project</option>
                                                                @foreach($projects as $project)
                                                                    <option value="{{$project->project_id}}">{{$project->project_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Select Supplier*</label>
                                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                                <option disabled selected>Select Supplier</option>
                                                                @foreach($suppliers as $supplier)
                                                                    <option value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Amount*</label>
                                                            <input type="number" class="form-control input-default" name="credit" required>
                                                        </div>
                                                        <input type="hidden" value="" name="debit"/>
                                                        <div class="form-group">
                                                            <label>Note*</label>
                                                            <textarea class="form-control" rows="4" id="comment" name="note" required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cashbook entries</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Supplier Name</th>
                                            <th>Note</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cashbooks as $cashbook)
                                            <tr>
                                                <td>{{$cashbook->project->project_name}}</td>
                                                <td>{{$cashbook->supplier->supplier_name}}</td>
                                                <td>{{$cashbook->note}}</td>
                                                <td>{{$cashbook->debit}}</td>
                                                <td>{{$cashbook->credit}}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('cashbook.edit',$cashbook->debit_credit_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <form action="{{ route('cashbook.destroy', $cashbook->debit_credit_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display:inline;">
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
                                        {{ $cashbooks->links() }}
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
@endsection
