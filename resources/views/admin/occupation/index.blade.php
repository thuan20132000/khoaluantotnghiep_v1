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
                        <a class="dropdown-item" href="#" id="occupation-deleteAllCheckbox">
                            Delete
                        </a>

                      </div>
                    </button>
                    <a type="button" class="btn btn-info" style="margin:auto 20px" href="{{ route('occupation.create') }}">Create</a>
                  </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="occupation-selectAllCheckbox" >
                    </th>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>CATEGORIES</th>
                    <th>IMAGE</th>
                    <th>STATUS</th>
                    <th>OPERATIONS</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($occupations as $occupation)
                    <tr>
                        <td>
                        <input type="checkbox" name="occupation[]" value="{{$occupation->id}}" >
                        </td>
                        <td>{{$occupation->id}}</td>

                        <td>{{$occupation->name}}</td>
                        <td>
                            <a href="{{ route('category.edit', $occupation->category->id) }}"
                                class="btn btn-block btn-info btn-xs"
                            >
                                {{$occupation->category->name}}
                            </a>
                        </td>
                        <td>
                        <img src="{{$occupation->image}}" width="100px" height="100px" alt="" srcset="">
                        </td>
                        <td>
                            @if ($occupation->status == 0)
                                <button type="button" class="btn btn-block bg-gradient-success btn-xs">Published</button>
                            @endif

                            @if ($occupation->status == 1)
                            <button type="button" class="btn btn-block bg-gradient-secondary btn-xs">Draft</button>
                            @endif

                            @if ($occupation->status == 2)
                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                            @endif

                        </td>
                        <td>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('occupation.edit', $occupation->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`occupation-{{$occupation->id}}`).submit()">
                                <i class="fas fa-trash"></i> Delete
                                <form action="{{ route('occupation.destroy',$occupation->id) }}" method="post" hidden id="occupation-{{$occupation->id}}">
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
