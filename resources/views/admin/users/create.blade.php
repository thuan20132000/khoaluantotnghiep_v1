@extends('admin.layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('user.index') }}"> << Danh sách người dùng</a>
        </div>
        <div class="col-6">

        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div style="margin: 6px">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Thông tin người dùng</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
                </div>
                <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input  type="text" value="{{old('name')}}" id="name" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Email</label>
                    <input type="text" value="{{old('email')}}" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phonenumber">PhoneNumber</label>
                    <input type="text" value="{{old('phonenumber')}}" id="phonenumber" name="phonenumber" class="form-control">
                </div>
                <div class="form-group">
                    <label for="idcard">ID card</label>
                    <input type="text" value="{{old('idcard')}}" id="idcard" name="idcard" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputName">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="row">
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Province / City</label>
                        <select class="form-control" id="provinces" name="province">
                            <option value="">-- select province --</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <label>District</label>
                          <select class="form-control" id="districts" name="district">
                            <option value="">-- select district --</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <label>Sub Disctrict</label>
                          <select class="form-control" id="subdistricts" name="subdistrict">
                            <option value=""> -- select subdistrict -- </option>
                          </select>
                        </div>
                      </div>

                </div>
                <div class="form-group">
                    <label for="inputDescription">Address</label>
                    <textarea id="inputDescription" name="address" class="form-control" rows="4"></textarea>
                </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>

            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="occupation_wrap" style="display: none">
                            <label for="occupation-images" class="text-primary">Lĩnh vực hoạt động</label>

                            <div class="form-group clearfix" style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: space-around">

                                @foreach ($occupations as $occupation)
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="occupation-{{$occupation->id}}" value="{{$occupation->id}}" name="occupations[]" >
                                        <label for="occupation-{{$occupation->id}}" class="text-muted">{{$occupation->name}}</label>
                                    </div>
                                @endforeach

                            </div>
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

                    <div class="form-group">
                        <label for="inputStatus">Role</label>
                        <select class="form-control custom-select" name="role" onchange="onChangeUserRole(this)">
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}"
                                @if ($role->name == 'isCustomer')
                                    selected
                                @endif
                            >
                                @switch($role->name)
                                    @case('isCustomer')
                                        Người tuyển dụng
                                        @break
                                    @case('isCollaborator')
                                        Người tìm việc
                                        @break
                                    @case('isAdmin')
                                        Quản trị viên
                                        @break
                                    @default

                                @endswitch
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
</div>

<script>


        /**
         * author:thuantruong
         * created_at:30/10/2020
         */


            const fetchProvinces = async () => {
                let provinceFetch = await fetch(`https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json`);
                if(!provinceFetch.ok){
                    console.log("SOMETHING WENT WRONG!!");
                    return;
                }
                let provinceData = await provinceFetch.json();
                let provincesArr = await Object.values(provinceData);
                // let province = provincesArr.for (const iterator of object) {

                // }
                var x = document.getElementById("provinces");
                for (const pv of provincesArr) {
                    // option += `<option>${pv.name}</option>`;
                    var option = document.createElement("option");
                    option.text = pv.name;
                    option.value = pv.code;
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
                    x.add(option);
                }
            }


            document.getElementById('provinces').onchange = function(evt){
                fetchDistrict(evt.target.value);
            }
            document.getElementById('districts').onchange = function(evt){
               fetchSubDistrict(evt.target.value);
            }


            const onChangeUserRole = (e) => {
                // alert('dsds');
                let occupation_fields = document.getElementById('occupation_wrap');

                if(e.value != 2){
                    occupation_fields.style.display = 'none'
                }else{
                    occupation_fields.style.display = 'block'

                }
            }


</script>

@endsection
