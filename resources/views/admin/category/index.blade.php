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
                        <a class="dropdown-item" href="#" id="category-deleteAllCheckbox">
                            Delete
                        </a>

                      </div>
                    </button>
                    <a type="button" class="btn btn-info" style="margin:auto 20px" href="{{ route('category.create') }}">Create</a>
                  </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="category-selectAllCheckbox" >
                    </th>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>SLUG</th>
                    <th>IMAGE</th>
                    <th>STATUS</th>
                    <th>OPERATIONS</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($categories as $category)
                    <tr>
                        <td>
                        <input type="checkbox" name="category[]" value="{{$category->id}}" >
                        </td>
                        <td>{{$category->id}}</td>

                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                        <img src="{{$category->image}}" width="100px" height="100px" alt="" srcset="">
                        </td>
                        <td>
                            @if ($category->status == 0)
                                <button type="button" class="btn btn-block bg-gradient-success btn-xs">Published</button>
                            @endif

                            @if ($category->status == 1)
                            <button type="button" class="btn btn-block bg-gradient-secondary btn-xs">Draft</button>
                            @endif

                            @if ($category->status == 2)
                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                            @endif

                        </td>
                        <td>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('category.show', $category->id) }}">
                                <i class="fas fa-eye"></i> Show
                            </a>
                            <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('category.edit', $category->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`category-{{$category->id}}`).submit()">
                                <i class="fas fa-trash"></i> Delete
                                <form action="{{ route('category.destroy',$category->id) }}" method="post" hidden id="category-{{$category->id}}">
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
