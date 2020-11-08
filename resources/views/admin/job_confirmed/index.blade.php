@extends('admin.layouts.master')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<section class="content">
    <div class="container-fluid">
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
                    <a type="button" class="btn btn-info" style="margin:auto 20px" href="{{ route('jobcollaborator.create') }}">Create</a>
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
                    <th>JOB</th>
                    <th>CONFIRMED PRICE</th>
                    <th>COLLABORATOR</th>
                    <th>CUSTOMER</th>
                    <th>CREATED AT</th>
                    <th>STATUS</th>
                    <th>OPERATIONS</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($job_confirms as $job_confirm)
                    <tr>
                        <td>
                        <input type="checkbox" name="jobcollaborator[]" value="{{$job_confirm->id}}" >
                        </td>
                        <td>{{$job_confirm->id}}</td>
                        <td>
                            <a href="{{ route('job.edit', $job_confirm->job()->id) }}">{{$job_confirm->job()->name}}</a>
                        </td>
                        <td>
                            {{$job_confirm->confirmed_price}}
                        </td>
                        <td>
                            <a href="{{ route('user.edit',$job_confirm->collaborator()->id) }}">{{$job_confirm->collaborator()->name}}</a>
                        </td>
                        <td>
                            <a href="{{ route('user.edit',$job_confirm->job()->user_id) }}">{{$job_confirm->job()->user_name}}</a>
                        </td>
                        <td>{{$job_confirm->updated_at}}</td>
                        <td>
                            @if ($job_confirm->status == 0)
                                <button type="button" class="btn btn-block bg-gradient-success btn-xs">Published</button>
                            @endif

                            @if ($job_confirm->status == 1)
                            <button type="button" class="btn btn-block bg-gradient-secondary btn-xs">Draft</button>
                            @endif

                            @if ($job_confirm->status == 2)
                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                            @endif

                        </td>
                        <td>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('jobcollaborator.edit', $job_confirm->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`job_confirm-{{$job_confirm->id}}`).submit()">
                                <i class="fas fa-trash"></i> Delete
                                <form action="{{ route('jobconfirm.destroy',$job_confirm->id) }}" method="post" hidden id="job_confirm-{{$job_confirm->id}}">
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
