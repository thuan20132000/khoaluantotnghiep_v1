@extends('page.layouts.master')

@section('content')

<div class="m-2">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('success'))
            <div class="alert alert-success" >
                {{ session()->get('success') }}
            </div>
            @endif
            @if(session()->has('failed'))
            <div class="alert alert-success" >
                {{ session()->get('failed') }}
            </div>
            @endif



        <form action="/posteditprofile" method="post">
            @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Sửa Thông tin người dùng</h3>

                
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" value="{{ $user->name }}" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Email</label>
                            <input disabled type="text" value="{{ $user->email }}" id="email" name="email"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phonenumber">PhoneNumber</label>
                            <input type="text" value="{{ $user->phonenumber }}" id="phonenumber" name="phonenumber"
                                class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="inputName">Password</label>
                            <input type="password" value="{{ $user->password }}"  id="password" name="password"
                                class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Province / City</label>
                                    <select class="form-control" id="provinces" name="province">
                                        <option value="">-- select province --</option>
                                        <option value="{{ $user->province }}" hidden id="user_province"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" id="districts" name="district">
                                        <option value="">-- select district --</option>
                                        <option value="{{ $user->district }}" hidden id="user_district"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Sub Disctrict</label>
                                    <select class="form-control" id="subdistricts" name="subdistrict">
                                        <option value=""> -- select subdistrict -- </option>
                                        <option value="{{ $user->subdistrict }}" hidden id="user_subdistrict"></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Address</label>
                            <textarea id="inputDescription" name="address" class="form-control" rows="4">
                            {{ $user->address }}
                            </textarea>
                        </div>
                        <label for="occupation-images" class="text-primary">Hình ảnh</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Chọn
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
            <button type="submit" class="btn btn-success">Cập Nhật</button></button>
                    <button type="reset" class="btn btn-primary">Làm Mới</button>

         
                </form>
                </div>
            </div>
            </div>
        </div>
@endsection