@extends('page.layouts.master')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                  <th>
                      <input type="checkbox" id="job-selectAllCheckbox" >
                  </th>
                  <th>ID</th>
                  <th>TITLE</th>
                  <th>DESCRIPTION</th>
                  <th>IMAGES</th>
                  <th>ADDRESS</th>
                  <th>PRICE</th>
                  <th>CUSTOMER</th>
                  <th>FIELD</th>
                  <th>STATUS</th>
                  <th>OPERATIONS</th>
              </tr>
              </thead>
              <tbody>

              @foreach ($jobs as $job)
                  <tr>
                      <td>
                      <input type="checkbox" name="job[]" value="{{$job->id}}" >
                      </td>
                      <td>{{$job->id}}</td>
                      <td>{{$job->name}}</td>
                      <td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                          {{$job->description}}
                      </td>

                      <td style="max-width: 220px">
                          @foreach ($job->images as $image)
                          <img src="{{ $image->image_url }}" width="50px" height="50px" alt="" srcset="">

                          @endforeach
                      </td>

                      <td>
                          <p>{{$job->location->address}}</p>
                          <p>{{$job->location->street}}</p>
                      </td>
                      <td>
                          {{$job->suggestion_price}}
                      </td>
                      <td>
                          <a href="{{$job->user->id }}" class="btn btn-block bg-gradient-info btn-xs">{{$job->user->name}}</a>
                      </td>
                      <td>
                          <a href="{{$job->occupation->id }}" class="btn btn-block bg-gradient-info btn-sm">{{$job->occupation->name}}</a>
                      </td>
                      {{-- <td>
                          @foreach ($job->roles as $role)
                              <button type="button" class="btn btn-block btn-outline-primary btn-sm">{{$role->name}}</button>
                          @endforeach
                      </td> --}}
                      <td>
                          @if ($job->status == 0)
                              <button type="text" class="btn btn-block bg-gradient-success btn-xs">Published</button>
                          @endif

                          @if ($job->status == 1)
                          <button type="text" class="btn btn-block bg-gradient-secondary btn-xs">Draft</button>
                          @endif

                          @if ($job->status == 2)
                          <button type="text" class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                          @endif

                          @if ($job->status == 3)
                          <button type="text" class="btn btn-block bg-gradient-info btn-xs">Approved</button>
                          @endif
                          @if ($job->status == 4)
                          <button type="text" class="btn btn-block bg-gradient-warning btn-xs">Confirmed</button>
                          @endif

                      </td>
                      <td>
                       @if($job->status == 2)
                          <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('chitietcongviec', ['job_id'=>$job->id]) }}">
                              <i class="fas fa-edit"></i> Chi tiết công việc
                          </a>
                        @endif
                        @if($job->status == 3)
                        
                          <a class="btn btn-block bg-gradient-info btn-xs" href="{{ route('chitietcongviec', ['job_id'=>$job->id]) }}">
                            <i class="fas fa-edit"></i> Xác Nhận
                        @endif
                        
                        
                        
                          <a class="btn btn-block bg-gradient-danger btn-xs" onclick="document.getElementById(`job-{{$job->id}}`).submit()">
                              <i class="fas fa-trash"></i> Delete
                              <form action="{{ route('job.destroy',$job->id) }}" method="post" hidden id="job-{{$job->id}}">
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