@extends('admin.layouts.master')

@section('content')

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
                <input disabled  type="text" id="name" name="name" value="{{$occupation->name}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Slug</label>
                    <input disabled type="text" id="slug" name="slug" value="{{$occupation->slug}}" class="form-control">
                </div>

                <div id="holder" style="width:100px;height:100px">
                    <img src="{{$occupation->image}}" width="100px" height="100px" alt="" srcset="">
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
                                @if ($occupation->status == $i)
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


      <script>
          let aa = document.getElementById('thumbnail');
            aa.addEventListener('click',function(){
                console.warn('sasa',aa);
            })

      </script>
@endsection
