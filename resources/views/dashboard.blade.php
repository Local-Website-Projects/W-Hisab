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
                                <p class="text-black mb-0">Cash In Hand</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$cashOnHand}}</span>
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
                                <p class="text-black mb-0">Today Expense</p>
                                <span class="fs-28 text-black font-w600 d-block">{{$todayExpense}}</span>
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
                                <h4 class="card-title">Today Cash Book</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Supplier Name</th>
                                            <th>Product Name</th>
                                            <th>Note</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cashbooks as $cashbook)
                                            <tr>
                                                <td>{{$cashbook->project->project_name}}</td>
                                                <td>{{ optional($cashbook->supplier)->supplier_name ?? 'N/A' }}</td>
                                                <td>{{ optional($cashbook->product)->product_name ?? 'N/A'}}</td>
                                                <td>{{$cashbook->note}}</td>
                                                <td>{{$cashbook->credit}}</td>
                                                <td>{{$cashbook->debit}}</td>
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
                <div class="row">
                    @foreach($results as $result)
                        <div class="col-xl-3 col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media pb-2 border-bottom align-items-center">
                                        <div class="media-body">
                                            <h4 class="fs-20">{{$result['project_name']}}</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3 mt-3">
											<span class="text-black mr-auto font-w500">
											Total Credit: {{$result['total_credit']}}<br/>Total Debit: {{$result['total_debit']}}   </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
