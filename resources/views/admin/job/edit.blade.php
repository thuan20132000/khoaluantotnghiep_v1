@extends('admin.layouts.master')

@section('content')

    <div style="margin:6px">


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
    @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    <form action="{{ route('job.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">


            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông Tin Công Việc</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName">Title</label>
                            <input type="text" value="{{ $job->name }}" id="name" name="name" class="form-control">
                            <input type="text" value="{{ $job->id }}" id="job_id" name="job_id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Slug</label>
                            <input type="text" value="{{ $job->slug }}" id="slug" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Job Description</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">
                            {{ $job->description }}
                            </textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Province / City</label>
                                    <select class="form-control" id="provinces" name="province">
                                        <option value="">-- select province --</option>
                                        <option value="{{ $job->location->province }}" hidden id="user_province"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" id="districts" name="district">
                                        <option value="">-- select district --</option>
                                        <option value="{{ $job->location->district }}" hidden id="user_district"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Sub Disctrict</label>
                                    <select class="form-control" id="subdistricts" name="subdistrict">
                                        <option value=""> -- select subdistrict -- </option>
                                        <option value="{{ $job->location->subdistrict }}" hidden id="user_subdistrict">
                                        </option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputName">Address</label>
                            <input type="text" value="{{ $job->location->address }}" id="addressTotal" name="address"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="inputDescription">Street</label>
                            <textarea id="inputDescription" name="street" class="form-control" rows="4">
                            {{ $job->location->street }}
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
                                    <option value="{{ $i }}" @if ($job->status == $i)
                                        selected
                                @endif
                                >

                                @if($i == 1)
                                    Draft
                                @elseif($i == 2)
                                    Pending
                                @else
                                    Published
                                @endif
                                </option>

                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="occupation-images" class="text-primary">Người tuyển dụng</label>
                            <select class="form-control custom-select" name="user">
                                <option disabled value="" selected>{{ $job->user->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occupation-images" class="text-primary">Lĩnh vực</label>
                            <select class="form-control custom-select" name="occupation">
                                <option value="0" selected>Selecting Field</option>
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}" @if ($occupation->id == $job->occupation->id)
                                        selected
                                @endif
                                >
                                {{ $occupation->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Giá</label>
                            <input type="text" value="{{ $job->suggestion_price }}" id="price" name="price"
                                class="form-control">
                        </div>
                        <label for="occupation-images" class="text-primary">Hình ảnh</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="filepaths">
                        </div>
                        <div id="holder" style="display: flex;flex-direction: row;flex-wrap: wrap;padding:16px">
                            @if (count($job_images_array) > 0)
                                @foreach ($job_images_array as $key => $value)
                                    <img src="{{ $value }}" style="height: 5rem;">
                                @endforeach
                            @endif
                        </div>



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Danh Sách Ưng Viên
                        <button type="button" class="btn btn-default p-2" style="margin-left: 12px" data-toggle="modal"
                            data-target="#modal-xl">
                            Thêm Ứng Viên
                        </button>
                    </h3>

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
                                <th>PHONE</th>
                                <th>ADDRESS</th>
                                <th>EXPECTED PRICE</th>
                                <th>DESCRIPTION</th>
                                <th>STATUS</th>
                                {{-- <th>OPERATION</th> --}}
                            </tr>
                        </thead>
                        <tbody id="collaborator_wrap">
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td>{{ $candidate->id }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $candidate->id) }}">{{ $candidate->name }}</a>
                                    </td>
                                    <td>{{ $candidate->email }}</td>
                                    <td>{{ $candidate->phonenumber }}</td>
                                    <td>{{ $candidate->address }}</td>
                                    <td>{{ $candidate->expected_price }}</td>
                                    <td>{{ $candidate->job_collaborator_description }}</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="dropdown">
                                                <button
                                                    class="btn
                                                        @switch($candidate->job_collaborator_status)
                                                            @case(1)
                                                                btn-danger
                                                                @break
                                                            @case(2)
                                                                btn-warning
                                                                @break
                                                            @case(3)
                                                                btn-primary
                                                                @break
                                                            @case(0)
                                                                btn-info
                                                                @break
                                                            @default

                                                        @endswitch
                                                    dropdown-toggle"
                                                    type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                >
                                                    @switch($candidate->job_collaborator_status)
                                                    @case(1)
                                                        Cancel
                                                        @break
                                                    @case(2)
                                                        Pending
                                                        @break
                                                    @case(3)
                                                        Approved
                                                        @break
                                                    @case(0)
                                                        Confirmed
                                                        @break
                                                    @default

                                                @endswitch
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @for ($i = 0; $i <= 3; $i++)
                                                        @if ($i != $candidate->job_collaborator_status)
                                                            <a class="dropdown-item"

                                                                href="{{ route('jobcollaborator.updatestatus', ['id'=>$candidate->job_collaborator_id,'status'=>$i]) }}"
                                                            >
                                                                @switch($i)
                                                                    @case(1)
                                                                        Cancel
                                                                        @break
                                                                    @case(2)
                                                                        Pending
                                                                        @break
                                                                    @case(3)
                                                                        Approved
                                                                        @break
                                                                    @case(0)
                                                                        Confirmed
                                                                    @default
                                                                @endswitch
                                                            </a>
                                                        @endif
                                                    @endfor
                                                </div>
                                              </div>
{{--
                                            <select
                                                class="form-control custom-select"
                                                id="job_collaborator_status"
                                                onchange="changeJobCollaboratorStatus({{$candidate->job_collaborator_id,$candidate->job_collaborator_id}})"
                                            >

                                                @for ($i = 1; $i <= 3; $i++)

                                                 <option value={{$i}}
                                                    @if ($candidate->job_collaborator_status == $i)
                                                        selected
                                                    @endif
                                                 >
                                                        @switch($i)
                                                            @case(1)
                                                                Cancel
                                                                @break
                                                            @case(2)
                                                                Pending
                                                                @break
                                                            @case(3)
                                                                Approved
                                                                @break
                                                            @default

                                                        @endswitch
                                                 </option>
                                                @endfor --}}
                                                {{-- @foreach ($ as $occupation)
                                                    <option value="{{ $occupation->id }}" @if ($occupation->id == $job->occupation->id)
                                                        selected
                                                @endif
                                                >
                                                {{ $occupation->name }}
                                                </option>
                                                @endforeach --}}
                                            {{-- </select> --}}
                                        </div>
                                        <script>

                                                const changeJobCollaboratorStatus = (jobcollaborator_id,this) => {
                                                //    let x =  e.getAttribute('data_id';
                                                alert(this);
                                                    //window.location.href = `/admin/jobcollaborator/${jobcollaborator_id}/status/${status}`;

                                                }

                                        </script>


                                    </td>
                                    {{-- <td>
                                        <a href="" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <a href="{{ route('jobcollaborator.edit', $candidate->job_collaborator_id) }}"
                                            class="btn btn-block bg-gradient-info btn-xs">Edit</a>
                                        <a class="btn btn-block bg-gradient-danger btn-xs"
                                            onclick="document.getElementById(`candidate-{{ $candidate->id }}`).submit()">
                                            <i class="fas fa-trash"></i> Delete
                                            <form
                                                action="{{ route('jobcollaborator.destroy', $candidate->job_collaborator_id) }}"
                                                method="post" hidden id="candidate-{{ $candidate->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Momal collaborator list --}}
                    <div class="modal fade" id="modal-xl" aria-modal="true">
                        <div class="modal-dialog modal-xl" style="max-width: 1420px">
                            <div class="modal-content">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">DataTable with default features</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="example2"
                                                        class="table table-bordered table-striped dataTable dtr-inline"
                                                        role="grid" aria-describedby="example1_info">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>NAME</th>
                                                                <th>IMAGE</th>
                                                                <th>OCCUPATIONS</th>
                                                                <th>EMAIL</th>
                                                                <th>IDC</th>
                                                                <th>ADDRESS</th>
                                                                <th>PHONE</th>
                                                                <th>OPERATIONS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($collaborators_all as $collaborator)
                                                                @if ($collaborator->hasRole('isCollaborator'))
                                                                    <tr role="row" class="odd">
                                                                        <td>{{ $collaborator->id }}</td>
                                                                        <td>{{ $collaborator->name }}</td>
                                                                        <td>{{ $collaborator->profile_image }}</td>
                                                                        <td
                                                                            style="display: flex;flex-direction: row;flex-wrap: wrap">
                                                                            @foreach ($collaborator->occupations as $occupation)
                                                                                <button type="button"
                                                                                    class="btn btn-block btn-info btn-xs">
                                                                                    {{ $occupation->name }}
                                                                                </button>
                                                                            @endforeach
                                                                        </td>
                                                                        <td>{{ $collaborator->email }}</td>
                                                                        <td>{{ $collaborator->idcard }}</td>
                                                                        <td>{{ $collaborator->address }}</td>
                                                                        <td>{{ $collaborator->phonenumber }}</td>
                                                                        <td>
                                                                            <form
                                                                                id="add-jobcollaborator-{{ $collaborator->id }}"
                                                                                action="{{ route('jobcollaborator.add') }}"
                                                                                method="post">
                                                                                <input type="text" name="expected_price"
                                                                                    id="" class="form-control m-1"
                                                                                    placeholder="expected price">

                                                                                <a class="btn btn-block bg-gradient-info btn-xs"
                                                                                    onclick="document.getElementById(`add-jobcollaborator-{{ $collaborator->id }}`).submit()">
                                                                                    Add

                                                                                    @csrf
                                                                                    <input hidden type="text"
                                                                                        value="{{ $job->id }}"
                                                                                        name="job_id">
                                                                                    <input hidden type="text"
                                                                                        value="{{ $collaborator->id }}"
                                                                                        name="user_id">
                                                                                </a>
                                                                            </form>

                                                                        </td>

                                                                    </tr>
                                                                @endif

                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
    <script>
        /**
         * author:thuantruong
         * created_at:30/10/2020
         */


        /**
         * author:thuantruong
         * created_at:30/10/2020
         */


        var address = {
            province: '',
            district: '',
            subdistrict: '',
            fullAddress: function() {
                return this.province + " - " + this.district + " - " + this.subdistrict;
            }
        }

        var user_province = document.getElementById('user_province').value;
        var user_district = document.getElementById('user_district').value;
        var user_subdistrict = document.getElementById('user_subdistrict').value;

        const fetchProvinces = async () => {
            let provinceFetch = await fetch(
                `https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json`);
            if (!provinceFetch.ok) {
                console.log("SOMETHING WENT WRONG!!");
                return;
            }
            let provinceData = await provinceFetch.json();
            let provincesArr = await Object.values(provinceData);

            var x = document.getElementById("provinces");
            for (const pv of provincesArr) {
                // option += `<option>${pv.name}</option>`;
                var option = document.createElement("option");
                option.text = pv.name;
                option.value = pv.code;
                if (option.value == user_province) {
                    option.selected = true;
                    fetchDistrict(user_province);
                }
                x.add(option);
            }




        }
        fetchProvinces();


        const fetchDistrict = async (code) => {
            let districtFetch = await fetch(
                `https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/quan-huyen/${code}.json`);
            if (!districtFetch.ok) {
                console.log("SOMETHING WENT WRONG!!");
                return;
            }
            let districtData = await districtFetch.json();
            let districtArr = await Object.values(districtData);


            var x = document.getElementById("districts");
            x.innerHTML = "";
            for (const pv of districtArr) {
                // option += `<option>${pv.name}</option>`;
                var option = document.createElement("option");
                option.text = pv.name;
                option.value = pv.code;
                if (option.value == user_district) {
                    option.selected = true;
                    fetchSubDistrict(user_district)
                }

                x.add(option);
            }
        }


        const fetchSubDistrict = async (code) => {
            let subDistrictFetch = await fetch(
                `https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/xa-phuong/${code}.json`)
            if (!subDistrictFetch.ok) {
                console.log("SOMETHING WENT WRONG!!");
                return;
            }
            let subdistrictData = await subDistrictFetch.json();
            let subdistrictArr = await Object.values(subdistrictData);

            console.log(subdistrictArr);
            var x = document.getElementById("subdistricts");
            x.innerHTML = "";
            for (const pv of subdistrictArr) {
                // option += `<option>${pv.name}</option>`;
                var option = document.createElement("option");
                option.text = pv.name;
                option.value = pv.code;
                if (option.value == user_subdistrict) {
                    option.selected = true;
                }
                x.add(option);
            }
        }


        document.getElementById('provinces').onchange = function(evt) {
            fetchDistrict(evt.target.value);
            address.province = evt.target.selectedOptions[0].text;
            getAddressTotal();

        }
        document.getElementById('districts').onchange = function(evt) {
            fetchSubDistrict(evt.target.value);
            address.district = evt.target.selectedOptions[0].text;
            getAddressTotal();
        }

        document.getElementById('subdistricts').onchange = function(evt) {
            address.subdistrict = evt.target.selectedOptions[0].text;
            getAddressTotal();
        }

        const getAddressTotal = async () => {
            document.getElementById('addressTotal').value = address.fullAddress();
        }


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
                console.log(fetchData);
                if (!fetchData.ok) {
                    console.log("SOMETHING WENT WRONG!!");
                    return;
                }
                let resData = await fetchData.json();
                console.log(resData);
                if (resData.data.length > 0) {

                    resData.data.forEach(e => {
                        let newRow = document.getElementById('collaborator_wrap').insertRow(-1);

                        newRow.innerHTML = collaboratorRow.fullrow(e.id, e.name, e.email, e.expected_price);
                    });

                }

                console.log(resData);
            } catch (error) {
                console.log("ERROR ", error);
                alert(error);
            }

        }


    </script>

@endsection
