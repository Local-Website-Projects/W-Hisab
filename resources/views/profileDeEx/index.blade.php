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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
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
                                <h4 class="card-title">Add New Data</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('khotiyan.store')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>Date*</label>
                                            <input type="date" class="form-control input-default" name="date" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="4" id="comment" spellcheck="false" name="note"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Deposit Amount</label>
                                            <input type="number" class="form-control input-default" placeholder="amount" name="deposit_amount">
                                        </div>
                                        <div class="form-group">
                                            <label>Expense Amount</label>
                                            <input type="number" class="form-control input-default" placeholder="amount" name="expense_amount">
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
                                <h4 class="card-title">Profile Data List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Note</th>
                                            <th>Deposit Amount</th>
                                            <th>Expense Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                                                <td>{{$data->note}}</td>
                                                <td>{{$data->deposit_amount}}</td>
                                                <td>{{$data->expense_amount}}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('khotiyan.edit',$data->profile_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <form action="{{ route('khotiyan.destroy', $data->profile_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display:inline;">
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
                                        {{ $datas->links() }}
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
