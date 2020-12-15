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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('jobcollaborator.update', $job_collaborator->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
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
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">

                            <label for="occupation-images" class="text-primary">Collaborator</label>
                            <div class="bg-primary color-palette">
                                <a href="{{ route('user.edit', $job_collaborator->user->id) }}"
                                    class="btn btn-block btn-outline-info btn-flat">
                                    {{ $job_collaborator->user->name }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation-images" class="text-primary">Job</label>
                            <div class="bg-primary color-palette">
                                <a href="{{ route('job.edit', $job_collaborator->job->id) }}"
                                    class="btn btn-block btn-outline-info btn-flat">
                                    {{ $job_collaborator->job->name }}
                                </a>
                            </div>
                            <input hidden type="text" name="" id="jobcollaborator_id"
                                value="{{ $job_collaborator->job->id }}">
                        </div>
                        {{-- {{ $job_collaborator->job->id }} --}}
                        <div class="form-group">
                            <label for="inputName">Expected Price</label>
                            <input type="text" value="{{ $job_collaborator->expected_price }}" id="price" name="price"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">
                            {{ $job_collaborator->description }}
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
                        <h3 class="card-title">Thiết lập</h3>
                        <div class="card-tools">
                            <button class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success">Update</button>

                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select class="form-control custom-select" name="status">
                                @for ($i = 0; $i < 3; $i++)
                                    <option value="{{ $i }}" @if ($job_collaborator->status == $i)
                                        selected
                                @endif
                                >
                                @if ($i == 0)
                                    Published
                                @elseif($i == 1)
                                    Draft
                                @elseif($i == 2)
                                    Pending
                                @endif
                                </option>
                                @endfor
                            </select>
                        </div>

                        @if ($job_collaborator->status != 3)
                            <button type="button" onclick="document.getElementById(`job_collaborator_confirm`).submit()"  class="btn btn-block bg-gradient-info btn-lg">
                                CONFIRM
                            </button>
                        @else
                        <button type="button" disabled   class="btn btn-block bg-gradient-success btn-sm">
                            CONFIRMED
                        </button>
                        @endif

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </form>
    <form action="{{ route('jobconfirm.post') }}" method="post" id="job_collaborator_confirm">
        @csrf
        <input type="hidden" name="job_collaborator_id" value="{{$job_collaborator->id}}" id="job_collaborator_id" >
        <input type="hidden" name="confirmed_price" value="{{$job_collaborator->expected_price}}" id="job_collaborator_price" >
        <input type="hidden" name="job_id" value="{{$job_collaborator->job->id}}" id="job_collaborator_price" >

    </form>
    <script>
        var collaboratorRow = {

            fullrow: function(id, name, email, expected_price) {
                return `<tr>
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
                let fetchData = await fetch(`/admin/ajax/jobcollaborator/${job_id}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                if (!fetchData.ok) {
                    console.log("SOMETHING WENT WRONG!!");
                    return;
                }
                let resData = await fetchData.json();
                if (resData.data.length > 0) {

                    resData.data.forEach(e => {
                        let newRow = document.getElementById('collaborator_wrap').insertRow(-1);

                        newRow.innerHTML = collaboratorRow.fullrow(e.id, e.name, e.email, e.expected_price);
                    });

                }

            } catch (error) {
                console.log("ERROR ", error);
                alert(error);
            }

        }

        let jobcollaborator_id = document.getElementById('jobcollaborator_id').value;
        fetchCollaboratorByJob(jobcollaborator_id);




        document.getElementById('price').onkeyup = function(evt){
            let priceValue = evt.target.value;
            document.getElementById('job_collaborator_price').value = priceValue;

        }



    </script>

@endsection
