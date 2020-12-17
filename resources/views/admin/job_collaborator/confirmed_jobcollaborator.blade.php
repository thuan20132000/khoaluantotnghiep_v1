@extends('admin.layouts.master')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('failed'))
<div class="alert alert-danger">
    {{ session('failed') }}
</div>
@endif

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    <input type="checkbox" name="" id="">
            </div>
        </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="#" id="jobcollaborator-deleteAllCheckbox">
                            Delete
                        </a>

                      </div>
                    </button>
                    {{-- <a type="button" class="btn btn-info" style="margin:auto 20px" href="{{ route('jobcollaborator.create') }}">Create</a> --}}
                  </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="jobcollaborator-selectAllCheckbox" >
                    </th>
                    <th>ID</th>
                    <th>Giá</th>
                    <th>Mô TẢ</th>
                    <th>NGUỜI ỨNG TUYỂN</th>
                    <th>CÔNG VIỆC</th>
                    <th>CREATED_AT</th>
                    <th>UPDATED_AT</th>
                    <th>STATUS</th>
                    <th>OPERATIONS</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($job_collaborators as $job_collaborator)
                    <tr>
                        <td>
                        <input type="checkbox" name="jobcollaborator[]" value="{{$job_collaborator->id}}" >
                        </td>
                        <td>{{$job_collaborator->id}}</td>
                        <td>{{$job_collaborator->expected_price}}</td>
                        <td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            {{$job_collaborator->description}}
                        </td>
                        <td>
                            <a href="{{ route('user.edit',$job_collaborator->user->id) }}" class="btn btn-block bg-gradient-info btn-xs">{{$job_collaborator->user->name}}</a>

                        </td>
                        <td>
                            <a href="{{ route('job.edit',$job_collaborator->job->id) }}" class="btn btn-block bg-gradient-info btn-xs">{{$job_collaborator->job->name}}</a>
                        </td>
                        <td>{{$job_collaborator->created_at}}</td>
                        <td>{{$job_collaborator->updated_at}}</td>
                        <td>
                            @if ($job_collaborator->status == 0)
                                <button type="button" class="btn btn-block bg-gradient-info btn-xs">CONFIRM</button>
                            @endif

                            @if ($job_collaborator->status == 1)
                            <button type="button" class="btn btn-block bg-gradient-secondary btn-xs">Cancel</button>
                            @endif

                            @if ($job_collaborator->status == 2)
                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                            @endif

                            @if ($job_collaborator->status == 3)
                            <button type="button" class="btn btn-block bg-gradient-success btn-xs">Approved</button>
                            @endif


                        </td>
                        <td>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('jobcollaborator.edit', $job_collaborator->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`job_collaborator-{{$job_collaborator->id}}`).submit()">
                                <i class="fas fa-trash"></i> Delete
                                <form action="{{ route('jobcollaborator.destroy',$job_collaborator->id) }}" method="post" hidden id="job_collaborator-{{$job_collaborator->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </a>

                        </td>
                    </tr>
                @endforeach


                </tbody>

              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>


@endsection
