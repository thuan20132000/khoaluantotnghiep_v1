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


    <form action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input  type="text" value="{{$user->name}}" id="name" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Email</label>
                    <input disabled type="text" value="{{$user->email}}" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phonenumber">PhoneNumber</label>
                    <input type="text" value="{{$user->phonenumber}}" id="phonenumber" name="phonenumber" class="form-control">
                </div>
                <div class="form-group">
                    <label for="idcard">ID card</label>
                    <input type="text" value="{{$user->idcard}}" id="idcard" name="idcard" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Password</label>
                    <input type="password" value="{{$user->password}}" disabled id="password" name="password" class="form-control">
                </div>
                <div class="row">
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Province / City</label>
                        <select class="form-control" id="provinces" name="province">
                            <option value="">-- select province --</option>
                            <option value="{{$user->province}}" hidden id="user_province"></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <label>District</label>
                          <select class="form-control" id="districts" name="district">
                            <option value="">-- select district --</option>
                            <option value="{{$user->district}}" hidden id="user_district"></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <label>Sub Disctrict</label>
                          <select class="form-control" id="subdistricts" name="subdistrict">
                            <option value=""> -- select subdistrict -- </option>
                            <option value="{{$user->subdistrict}}" hidden id="user_subdistrict"></option>
                          </select>
                        </div>
                      </div>

                </div>
                <div class="form-group">
                    <label for="inputDescription">Address</label>
                    <textarea id="inputDescription" name="address" class="form-control" rows="4">
                        {{$user->address}}
                    </textarea>
                </div>

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
                        <label for="occupation-images" class="text-primary">Major Fields</label>
                        <div class="form-group">
                            <div class="form-group clearfix" style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-around">

                                @foreach ($occupations as $occupation)
                                    <div class="icheck-primary">
                                        <input
                                            type="checkbox"
                                            id="occupation-{{$occupation->id}}"
                                            value="{{$occupation->id}}"
                                            name="occupations[]"
                                            @php
                                             if (in_array($occupation->id,$user_occupation_array)) {
                                                 echo "checked";
                                             }
                                            @endphp
                                        >

                                        <label for="occupation-{{$occupation->id}}" class="text-muted">{{$occupation->name}}</label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <label for="occupation-images" class="text-primary">Some Images of Recent Project</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="filepaths">
                        </div>
                        <div id="holder" style="display: flex;flex-direction: row;flex-wrap: wrap;padding:16px">
                            @if (count($user_image_array) > 0)
                                @foreach ($user_image_array as $key => $value)
                                    <img src="{{$value}}" style="height: 5rem;">
                                @endforeach
                            @endif
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
                        <button type="submit" class="btn btn-block btn-success">Update</button>

                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Status</label>
                        <select class="form-control custom-select" name="status">

                            @for ($i = 0; $i < 3; $i++)
                            <option
                                value="{{$i}}"
                                @if ($occupation->status == $i)
                                    selected
                                @endif
                            >
                                @if ($i ==0)
                                    Published
                                @elseif($i == 1)
                                    Draft
                                @else
                                    Pending
                                @endif
                            </option>

                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputStatus">Role</label>
                        <select class="form-control custom-select" name="role">

                            @foreach ($roles as $role)
                            <option value="{{$role->id}}"
                                @if (count($user->roles) > 0)
                                    @if ($role->id == $user->roles[0]->id)
                                        selected
                                    @endif
                                @endif

                            >
                                {{$role->name}}

                            </option>
                            @endforeach
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


        /**
         * author:thuantruong
         * created_at:30/10/2020
         */

            var user_province = document.getElementById('user_province').value;
            var user_district = document.getElementById('user_district').value;
            var user_subdistrict = document.getElementById('user_subdistrict').value;

            const fetchProvinces = async () => {
                let provinceFetch = await fetch(`https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json`);
                if(!provinceFetch.ok){
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
                    if(option.value == user_province){
                        option.selected = true;
                        fetchDistrict(user_province);
                    }
                    x.add(option);
                }




            }
            fetchProvinces();


            const fetchDistrict = async (code) => {
                let districtFetch = await fetch(`https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/quan-huyen/${code}.json`);
                if(!districtFetch.ok){
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
                    if(option.value == user_district){
                        option.selected = true;
                        fetchSubDistrict(user_district)
                    }

                    x.add(option);
                }
            }


            const fetchSubDistrict = async (code) => {
                let subDistrictFetch = await fetch(`https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/xa-phuong/${code}.json`)
                if(!subDistrictFetch.ok){
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
                    if(option.value == user_subdistrict){
                        option.selected = true;
                    }
                    x.add(option);
                }
            }


            document.getElementById('provinces').onchange = function(evt){
                fetchDistrict(evt.target.value);
            }
            document.getElementById('districts').onchange = function(evt){
               fetchSubDistrict(evt.target.value);
            }




            // const fetchUserProvince = async (code) => {
            //     let province_code = document.getElementById('user_province').value;
            //     alert(province_code);
            //     let fetchUserProvince = await fetch(`https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json`)
            // }
            // fetchUserProvince();

</script>

@endsection
