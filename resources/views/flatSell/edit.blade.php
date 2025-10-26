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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Flat Sell</a></li>
                    </ol>
                </div>
                <div class="row">

                    <div class="col-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Flat Sell Data</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('flat-sell.update',$id->flat_sell_id)}}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="form-group">
                                            <label>Select Purchaser*</label>
                                            <select class="form-control form-control-lg default-select" name="supplier_id" required>
                                                @foreach($purchasers as $pur)
                                                    <option value="{{$pur->supplier_id}}" @if($id->supplier_id = $pur->supplier_id) selected @endif>{{$pur->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Project*</label>
                                            <select class="form-control form-control-lg default-select" name="project_id" required>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->project_id}}" @if($id->project_id = $pur->project_id) selected @endif>{{$project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control input-default" value="{{$id->total_amount}}" name="total_amount" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" class="form-control input-default" value="{{$id->date}}" name="date">
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="4" id="comment" spellcheck="false" name="note">{{$id->note}}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-rounded btn-outline-primary">Add</button>
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
