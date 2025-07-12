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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Projects</a></li>
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
                                <h4 class="card-title">Update Project</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('project.update',$project->project_id)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Project Name*</label>
                                            <input type="text" class="form-control input-default" placeholder="project name" name="project_name" value="{{$project->project_name}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Initial Balance*</label>
                                            <input type="number" class="form-control input-default" placeholder="balance" name="initial_balance" value="{{$project->initial_balance}}" required>
                                        </div>
                                        <div class="form-group">
                                            <lable>Change Status</lable>
                                            <select class="form-control form-control-lg default-select" name="status">
                                                <option value="1" {{$project->status == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{$project->status == 0 ? 'selected' : ''}}>De-Active</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" rows="4" id="comment" spellcheck="false" name="note">{{$project->note}}</textarea>
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
