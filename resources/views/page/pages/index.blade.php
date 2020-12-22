@extends('page.layouts.master')
@section('slide')
    @include('page.layouts.slide')
@endsection
@section('content')
<div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_center">
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
            <h1>Danh Mục </h1>
          </div>
        </div>
  <div class="container">  
    <div class="row">
    @foreach($categories as $key => $cat)
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="full cat-item text_align_center margin_bottom_30">
          <div class="center">
            <div class="icon"> <img src="{{$cat->image}}" alt="#" /> </div>
          </div>
          <h4><a href="jobCategory/{{$cat->id}}">{{$cat->name}}</a>
          </h4>
        </div>
      </div>
    @endforeach
<!-- end section -->
<!-- section -->
<!-- end section -->
<!-- section -->

<!-- end section -->
<!-- section -->

</div>

<!-- end section -->
<!-- section -->
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_left">
            <h2>Công Việc Mới</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
    @foreach($jobs as $jb)
      <div class="col-md-4">
        <div class="full blog_colum">
          <div class="blog_feature_img">
          @foreach($jb->images as $image)
            <img src="{{$image->image_url}}" style="width:170px;height:160px" alt="" srcset="">
          @endforeach
          </div>
        
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter-{{$jb->id}}">
            Ứng Tuyển Vị Trí
          </button>
          
          <div class="blog_feature_head">
            <h4><a href="jobsingle/{{$jb->id}}">{{$jb->name}}</h4>
          </div>  
          
          <div class="modal fade" id="exampleModalCenter-{{$jb->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Nhập Thông Tin</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('post.ungtuyen')}}" method="post">
      @csrf
            <div class="modal-body">
      
            <label for="quantity"><h4>Giá đưa ra</h4></label>
                              <input type="number" name="price" type="text" class="form-control"/>
                                              <input type="text" name="user"  hidden value="{{Auth::check()?Auth::user()->id:null}}" class="form-control" />
                                              
                                              <input type="text" name="job"  hidden value={{$jb->id}} class="form-control"/>
                                              
                              <label for="inputDescription"><h4>Lời Nhắn</h4></label>
                                  <textarea id="inputDescription" name="description" class="form-control" rows="4">
                                  </textarea>
            </div>
            <div class="modal-footer">
      
              <button type="submit" class="btn btn-secondary" >
              Ứng Tuyển
              </button>
           
            </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
      @endforeach
@endsection