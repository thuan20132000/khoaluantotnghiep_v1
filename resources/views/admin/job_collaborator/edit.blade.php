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


    @if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
    @endif

    <form action="{{ route('jobcollaborator.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">General</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
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
                            <th>EXPECTED PRICE</th>
                          </tr>
                        </thead>
                        <tbody id="collaborator_wrap">




                        </tbody>
                      </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>

            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Occupation Experiences</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" value="{{$job_collaborator->job->id}}" hidden name="jobcollaborator_id" id="jobcollaborator_id">
                            <label for="occupation-images" class="text-primary">Collaborator</label>
                            <select class="form-control custom-select" name="user">
                                <option value="" selected>-- Selecting Collaborator --</option>
                                @foreach ($collaborators as $collaborator)
                                    <option value="{{$collaborator->id}}"
                                        @if ($collaborator->id == $job_collaborator->user->id)
                                            selected
                                        @endif
                                    >{{$collaborator->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occupation-images" class="text-primary">Job</label>
                            <select class="form-control custom-select" name="job" id="job">
                                <option value="0" selected>Selecting Job</option>
                                @foreach ($jobs as $job)
                                    <option value="{{$job->id}}"
                                        @if ($job->id == $job_collaborator->job->id)
                                            selected
                                        @endif
                                    >{{$job->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- {{$job_collaborator->job->id}} --}}
                        <div class="form-group">
                            <label for="inputName">Expected Price</label>
                            <input type="text" value="{{$job_collaborator->expected_price}}" id="price" name="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">
                                {{$job_collaborator->description}}
                            </textarea>
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
<script>



            var collaboratorRow = {

                fullrow:function(id,name,email,expected_price){
                    return  `<tr>
                                <td>${id}</td>
                                <td><span class="badge bg-danger">${name}</span></td>
                                <td>${email}</td>
                                <td>${expected_price}</td>
                             </tr>`;
                }
            }



            const fetchCollaboratorByJob = async (job_id) => {
                let collaboratorWrap = document.getElementById('collaborator_wrap');
                collaboratorWrap.innerHTML = "";
                try {
                    let fetchData = await fetch(`/admin/ajax/jobcollaborator/${job_id}`,{
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });
                    if(!fetchData.ok){
                        console.log("SOMETHING WENT WRONG!!");
                        return;
                    }
                    let resData = await fetchData.json();
                    if(resData.data.length>0){

                        resData.data.forEach(e => {
                            let newRow = document.getElementById('collaborator_wrap').insertRow(-1);

                            newRow.innerHTML = collaboratorRow.fullrow(e.id,e.name,e.email,e.expected_price);
                        });

                    }

                } catch (error) {
                    console.log("ERROR ",error);
                    alert(error);
                }

            }

            let jobcollaborator_id = document.getElementById('jobcollaborator_id').value;
            fetchCollaboratorByJob(jobcollaborator_id);


            document.getElementById('job').onchange = function(evt){
                fetchCollaboratorByJob(evt.target.value);
            }



</script>

@endsection
