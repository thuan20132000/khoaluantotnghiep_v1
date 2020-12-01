@extends('admin.layouts.master')

@section('content')


        <div class="row" style="margin: 6px">


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
                            <input disabled type="text" value="{{ $job->name }}" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Slug</label>
                            <input disabled type="text" value="{{ $job->slug }}" id="slug" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Job Description</label>
                            <textarea disabled id="inputDescription" name="description" class="form-control" rows="4">
                            {{ $job->description }}
                            </textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Province / City</label>
                                    <select class="form-control" id="provinces" name="province" disabled>
                                        <option value="">-- select province --</option>
                                        <option value="{{ $job->location->province }}" hidden id="user_province"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" id="districts" name="district" disabled>
                                        <option value="">-- select district --</option>
                                        <option value="{{ $job->location->district }}" hidden id="user_district"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Sub Disctrict</label>
                                    <select class="form-control" id="subdistricts" name="subdistrict" disabled>
                                        <option value=""> -- select subdistrict -- </option>
                                        <option value="{{ $job->location->subdistrict }}" hidden id="user_subdistrict">
                                        </option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputName">Address</label>
                            <input disabled type="text" value="{{ $job->location->address }}" id="addressTotal" name="address"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="inputDescription">Street</label>
                            <textarea disabled id="inputDescription" name="street" class="form-control" rows="4">
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
                        <h3 class="card-title">Publish</h3>
                        <div class="card-tools">
                            <button class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select class="form-control custom-select" name="status" disabled>
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
                            <label for="occupation-images" class="text-primary">Người Tuyển Dụng</label>
                            <select class="form-control custom-select" name="user" disabled>
                                <option disabled value="" selected>{{ $job->user->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occupation-images" class="text-primary">Lĩnh Vực</label>
                            <select class="form-control custom-select" name="occupation" disabled>
                                <option value="{{$job->occupation->id}}" selected>
                                    {{$job->occupation->name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Giá</label>
                            <input disabled type="text" value="{{ $job->suggestion_price }}" id="price" name="price"
                                class="form-control">
                        </div>
                        <label for="occupation-images" class="text-primary">Hình ảnh</label>

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
    <div class="row" style="margin:6px">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Danh Sách Ứng Tuyển
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
                                        @if ($candidate->job_collaborator_status == 0)
                                            <button type="button"
                                                class="btn btn-block bg-gradient-info btn-xs">Confirmed</button>
                                        @endif

                                        @if ($candidate->job_collaborator_status == 1)
                                            <button type="button"
                                                class="btn btn-block bg-gradient-secondary btn-xs">Cancel</button>
                                        @endif

                                        @if ($candidate->job_collaborator_status == 2)
                                            <button type="button"
                                                class="btn btn-block bg-gradient-danger btn-xs">Pending</button>
                                        @endif

                                        @if ($candidate->job_collaborator_status == 3)
                                            <button type="button"
                                                class="btn btn-block bg-gradient-success btn-xs">Approved</button>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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

        let job_id = document.getElementById('job_id').value;
        // fetchCollaboratorByJob(job_id);

    </script>

@endsection
