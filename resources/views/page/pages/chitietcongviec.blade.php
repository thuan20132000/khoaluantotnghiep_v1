@extends('page.layouts.master')

@section('content')

<section class="content">
        <div class="row" style="margin: 6px">


            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Công Việc</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName">Title</label>
                            <input disabled type="text" value="{{ $job->name }}" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Slug</label>
                            <input disabled type="text" value="{{ $job->slug }}" id="slug" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Job Description</label>
                            <textarea disabled id="inputDescription" name="description" class="form-control" rows="4">
                            {{ $job->description }}
                            </textarea>
                        </div>
                        
                            
                         

        
                       

                       

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="row" style="margin:6px">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Danh Sách Ứng Tuyển
                            </h3>
        
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>PHONE</th>
                                        <th>ADDRESS</th>
                                        <th>EXPECTED PRICE</th>
                                        <th>DESCRIPTION</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="collaborator_wrap">
                                    @foreach ($candidates as $candidate)
                                        <tr>
                                            <td>{{ $candidate->id }}</td>
                                            <td>
                                                <a href="{{ route('chitietcongviec', $candidate->id) }}">{{ $candidate->name }}</a>
                                            </td>
                                            <td>{{ $candidate->email }}</td>
                                            <td>{{ $candidate->phonenumber }}</td>
                                            <td>{{ $candidate->address }}</td>
                                            <td>{{ $candidate->expected_price }}</td>
                                            <td>{{ $candidate->job_collaborator_description }}</td>
                                            <td>
                                                @if ($candidate->job_collaborator_status == 4)
                                                    <button type="button"
                                                        class="btn btn-block bg-gradient-warning btn-xs">Confirmed</button>
                                                @endif
        
                                                @if ($candidate->job_collaborator_status == 1)
                                                    <button type="button"
                                                        class="btn btn-block bg-gradient-secondary btn-xs">Cancel</button>
                                                @endif
        
                                                @if ($candidate->job_collaborator_status == 2)
                                                    <button type="button"
                                                        class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                                                @endif
        
                                                @if ($candidate->job_collaborator_status == 3)
                                                    <button type="button"
                                                        class="btn btn-block bg-gradient-success btn-xs">Approved</button>
                                                @endif
        
                                            </td>
        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
        
                        </div>
        
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        
        </section>
                  
        
        
                
                   
            @endsection