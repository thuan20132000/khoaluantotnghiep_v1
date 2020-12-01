@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('category.index') }}"> << Danh sách danh mục</a>
        </div>
        <div class="col-6">

        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                    <input  type="text" id="name" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control">
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> Choose
                    </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                </div>
                <div id="holder" style="width:100px;height:100px">

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
                        <button type="submit" class="btn btn-block btn-success">Save</button>

                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Status</label>
                        <select class="form-control custom-select" name="status">
                            <option value="0" selected>Published</option>
                            <option value="1" >Draft</option>
                            <option value="2">Pending</option>
                        </select>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
        </div>
    </form>


</div>

      <script>
          let aa = document.getElementById('thumbnail');
            aa.addEventListener('click',function(){
                console.warn('sasa',aa);
            })

      </script>

@endsection
