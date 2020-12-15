@extends('page.layouts.master')
@section('title')
    postJob
@endsection
@section('content')

 <div class="container">
        <div>
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

        </div>

<form action="{{route('post.job')}}" method="POST" enctype="multipart/form-data">
@csrf
<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">POST A JOB</h1>
              <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li class="active">Post a Job</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    
  
    

    
    

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
       
          <div class="col-md-12 col-lg-8 mb-5">
          
            
          
            <form action="#" class="p-5 bg-white">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="fullname"><h3>Tiêu Đề</h3></label>
                  <input type="text" id="fullname" name="name" class="form-control" placeholder="Tiêu đề công việc">
                </div>
              </div>

              


              <div class="row form-group">
                <div class="col-md-12"><h3>Chọn Loại Lĩnh Vực</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                   
                        <select class="form-control idProductType" name="occupation ">
                          
                            @foreach ($occupation as $ct)
                          
                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                            @endforeach
                        </select>
                </div>

              </div>

              <div class="row form-group mb-4">
                <div class="col-md-12"><h3>Địa Chỉ</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                  <input type="text" class="form-control" name="address" placeholder="New York City">
                </div>
              </div>
            <div class="form-group">
                        <label for="image"><h3>Hình ảnh</h3></label>
                        <input type="file" name="filepaths" class="form-control">
                    </div>
              <div class="row form-group">
                <div class="col-md-12"><h3>Mô tả công việc</h3></div>
                <div class="col-md-12 mb-3 mb-md-0">
                  <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                </div>
              </div>
              <div class="form-group">
                        <label for="quantity"><h3>Giá đưa ra</h3></label>
                        <input type="number" name="price" min="1" value="1" class="form-control">
                    </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Đăng Việc" class="btn btn-primary  py-2 px-5">
                </div>
              </div>

  
            </form>
          </div>

          
           
          </div>
        </div>
      </div>
    </div>


          </div>
          </div>
        </div>
      
      </div>
    </div>

  @endsection


    
    



