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
                        <select class="form-control custom-select" name="user">
                            <option value="" selected>-- Selecting User --</option>
                            @foreach ($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="occupation-images" class="text-primary">Field</label>
                        <select class="form-control custom-select" name="occupation">
                            <option value="0" selected>Selecting Field</option>
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





</script>

@endsection
