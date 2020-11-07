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

    <form action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-md-8">
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
                            <label for="inputName">Title</label>
                            <input  type="text" value="{{old('name')}}" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Slug</label>
                            <input type="text" value="{{old('slug')}}" id="slug" name="slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Job Description</label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">
                                {{old('description')}}
                            </textarea>
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
                        <label for="inputName">Address</label>
                        <input type="text" value="" id="addressTotal" name="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Street</label>
                        <textarea  name="street" class="form-control" rows="4">

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
                    <div class="form-group">
                        <label for="occupation-images" class="text-primary">Customer</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xl">Select Customer</button>
                            </div>
                            <!-- /btn-group -->
                            <input type="text" class="form-control" id="job_customer_name">
                            <input hidden type="text" id="job_customer_id" name="user" hidden >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="occupation-images" class="text-primary">Field</label>
                        <select class="form-control custom-select" name="occupation">
                            <option value="" selected>Selecting Field</option>
                            @foreach ($occupations as $occupation)
                                <option value="{{$occupation->id}}">{{$occupation->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Price</label>
                        <input type="text" value="{{old('price')}}" id="price" name="price" class="form-control">
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

                    </div>



                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
        </div>
    </form>
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
                                                <th>EMAIL</th>
                                                <th>IDC</th>
                                                <th>ADDRESS</th>
                                                <th>PHONE</th>
                                                <th>OPERATIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                    <tr role="row" class="odd">
                                                        <td>{{ $customer->id }}</td>
                                                        <td>{{ $customer->name }}</td>
                                                        <td>
                                                            <img src="{{ $customer->profile_image }}" width="100px" height="100px" alt="" srcset="">
                                                        </td>
                                                        <td>{{ $customer->email }}</td>
                                                        <td>{{ $customer->idcard }}</td>
                                                        <td>{{ $customer->address }}</td>
                                                        <td>{{ $customer->phonenumber }}</td>
                                                        <td>
                                                        <a class="btn btn-block bg-gradient-info btn-xs" data-dismiss="modal" id="" href="#" onclick="selectJobCustomer('{{$customer->id}}','{{$customer->name}}')">
                                                                <i class="fas fa-edit"></i> Select
                                                            </a>
                                                        </td>


                                                    </tr>

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
<script>

 /**
         * author:thuantruong
         * created_at:30/10/2020
         */


        var address = {
            province:'',
            district:'',
            subdistrict:'',
            fullAddress:function(){
                return this.province + " - "+ this.district+" - "+this.subdistrict;
            }
        }


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
                address.province = evt.target.selectedOptions[0].text;
            }
            document.getElementById('districts').onchange = function(evt){
               fetchSubDistrict(evt.target.value);
               address.district = evt.target.selectedOptions[0].text;
            }


            const getAddressTotal = async () => {

                document.getElementById('subdistricts').onchange = function(evt){
                    address.subdistrict = evt.target.selectedOptions[0].text;
                    document.getElementById('addressTotal').value = address.fullAddress();
                }
            }
            getAddressTotal();


            const selectJobCustomer = (id,name) => {
                console.log(name);
               document.getElementById('job_customer_name').value = name;
               document.getElementById('job_customer_id').value = id;
            }


</script>

@endsection
