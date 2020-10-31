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
                        <a class="dropdown-item" href="#" id="user-deleteAllCheckbox">
                            Delete
                        </a>

                      </div>
                    </button>
                    <a type="button" class="btn btn-info" style="margin:auto 20px" href="{{ route('user.create') }}">Create</a>
                  </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="user-selectAllCheckbox" >
                    </th>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>IMAGE</th>
                    <th>EMAIL</th>
                    <th>ADDRESS</th>
                    <th>IDC</th>
                    <th>PHONE</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th>OPERATIONS</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td>
                        <input type="checkbox" name="user[]" value="{{$user->id}}" >
                        </td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>
                            <img src="{{$user->profile_image}}" width="100px" height="100px" alt="" srcset="">
                        </td>
                        <td>{{$user->email}}</td>

                        <td>{{$user->address}}</td>
                        <td>{{$user->idcard}}</td>
                        <td>{{$user->phonenumber}}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <button type="button" class="btn btn-block btn-outline-primary btn-sm">{{$role->name}}</button>
                            @endforeach
                        </td>
                        <td>
                            @if ($user->status == 0)
                                <button type="button" class="btn btn-block bg-gradient-success btn-xs">Published</button>
                            @endif

                            @if ($user->status == 1)
                            <button type="button" class="btn btn-block bg-gradient-secondary btn-xs">Draft</button>
                            @endif

                            @if ($user->status == 2)
                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                            @endif

                        </td>
                        <td>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('user.edit', $user->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`user-{{$user->id}}`).submit()">
                                <i class="fas fa-trash"></i> Delete
                                <form action="{{ route('user.destroy',$user->id) }}" method="post" hidden id="user-{{$user->id}}">
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
