@extends('page.layouts.master')
@section('title')
    Job
@endsection
@section('content')





<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">Job List</h1>
              <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li class="active">Job</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

        

<div class="section padding_layout_1 product_list_main">
  <div class="container">
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
    <div class="row">
      <div class="col-md-9">
        <div class="row">
        @foreach($job as $key => $jb)
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
            
              <div class="product_img">
               @foreach($jb->images as $image)
              <img src="{{$image->image_url}}" style="width:500px;height:300px;padding-right:210px" alt="" srcset="">
              @endforeach
              </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h3><a href="it_shop_detail.html">{{$jb->name}}</a></h3>
                </div>
               

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter-{{$jb->id}}">
  Ứng Tuyển Vị Trí
</button>
   

                <div class="product_price">
                  <h4>Gía đưa ra:{{$jb->suggestion_price}}</h4>
                </div>
              </div>
              <div class="blog_feature_cont">
            <p>{{$jb->description}}</p>
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
                                        <input type="text" name="user"  hidden value={{Auth::user()->id?Auth::user()->id:null}} class="form-control"/>
                                        
                                        <input type="text" name="job"  hidden value={{$jb->id}} class="form-control"/>
                                        
                        <label for="inputDescription"><h4>Lời Nhắn</h4></label>
                            <textarea id="inputDescription" name="description" class="form-control" rows="4">
                            </textarea>
      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-secondary" >
        Ung Tuyển
        </button>
     
      </div>
      </form>
     
    </div>
  </div>
            </div>


            
          </div>

         
</div>
    @endforeach          
        </div>
      </div>
      <div class="col-md-3">
        <div class="side_bar">
          <div class="side_bar_blog">
            <h4>SEARCH</h4>
            <div class="side_bar_search">
              <div class="input-group stylish-input-group">
                <input class="form-control" placeholder="Search" type="search" name="type">
                <span class="input-group-addon">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </span> </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
    