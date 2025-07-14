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
                <div class="row sp-sm-15">
                    <div class="col-xl-3 col-xxl-4 col-md-4 col-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-black mb-0">Today Expense</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$todayExpense}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-md-4 col-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-black mb-0">Today Deposit</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$todayDeposit}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-md-4 col-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-black mb-0">Running Projects</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$projects}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-xxl-4 col-md-4 col-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-black mb-0">Total Suppliers</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$suppliers}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Today Profile Data List</h4>
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
                                        @foreach($profiles as $profile)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($profile->date)->format('d M Y') }}</td>
                                                <td>{{$profile->note}}</td>
                                                <td>{{$profile->deposit_amount}}</td>
                                                <td>{{$profile->expense_amount}}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('khotiyan.edit',$profile->profile_id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <form action="{{ route('khotiyan.destroy', $profile->profile_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display:inline;">
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
                                        {{ $profiles->links() }}
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
