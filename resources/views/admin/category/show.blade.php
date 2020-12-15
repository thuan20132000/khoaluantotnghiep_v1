@extends('admin.layouts.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">General</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Name</label>
                    <input disabled  type="text" id="name" name="name" value="{{$category->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Slug</label>
                        <input disabled type="text" id="slug" name="slug" value="{{$category->slug}}" class="form-control">
                    </div>

                    <div id="holder" style="width:100px;height:100px">
                        <img src="{{$category->image}}" width="100px" height="100px" alt="" srcset="">
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
                <div class="col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                    <h3 class="card-title">Publish</h3>
                    <div class="card-tools">
                        <button
                            class="btn btn-tool"
                            data-card-widget="collapse"
                            data-toggle="tooltip"
                            title="Collapse"
                        >
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select class="form-control custom-select" name="status" disabled>

                                @for ($i = 0; $i < 3; $i++)
                                <option
                                    value="{{$i}}"
                                    @if ($category->status == $i)
                                        selected
                                    @endif
                                >
                                    @if ($i ==0)
                                        Publish
                                    @elseif($i == 1)
                                        Draft
                                    @else
                                        Pending
                                    @endif
                                </option>

                                @endfor
                            </select>
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
            </div>
        </div>



@endsection
