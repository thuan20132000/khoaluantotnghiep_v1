@extends('page.layouts.master')
@section('slide')
    @include('page.layouts.slide')
@endsection
@section('content')
<div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_center">
            <h2>Danh Mục </h2>
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
          <h4><a href="it_shop_detail.html">{{$cat->name}}</a></h4>
        </div>
      </div>
    @endforeach
<!-- end section -->
<!-- section -->
<!-- end section -->
<!-- section -->
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_center">
            <h2>Nghề Nghiệp</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
    @foreach($occupation as $key => $oc)
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 margin_bottom_30_all" data-aos="fade-right">
        <div class="product_list">
          <div class="product_img"> <img class="img-responsive" src="{{$oc->image}}" alt=""> </div>
          <div class="product_detail_btm">
            <div class="center">
              <h4><a href="it_shop_detail.html">{{$oc->name}}</a></h4>
            </div>
          </div>
        </div>
      </div>
      @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end section -->
<!-- section -->

</div>
<div class="section padding_layout_1 light_silver gross_layout right_gross_layout">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_right">
            <h2>Our Feedback</h2>
            <p class="large">Easy and effective way to get your device repaired.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row counter">
      <div class="col-md-4"> </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin_bottom_50">
            <div class="text_align_right"><i class="fa fa-smile-o"></i></div>
            <div class="text_align_right">
              <p class="counter-heading text_align_right">Happy Customers</p>
            </div>
            <h5 class="counter-count">2150</h5>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin_bottom_50">
            <div class="text_align_right"><i class="fa fa-laptop"></i></div>
            <div class="text_align_right">
              <p class="counter-heading text_align_right">Laptop Repaired</p>
            </div>
            <h5 class="counter-count">1280</h5>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin_bottom_50">
            <div class="text_align_right"><i class="fa fa-desktop"></i></div>
            <div class="text_align_right">
              <p class="counter-heading">Computer Repaired</p>
            </div>
            <h5 class="counter-count">848</h5>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin_bottom_50">
            <div class="text_align_right"><i class="fa fa-windows"></i></div>
            <div class="text_align_right">
              <p class="counter-heading">OS Installed</p>
            </div>
            <h5 class="counter-count">450</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
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
          <div class="blog_feature_img"> <img src"{{$jb->images}}" alt="" /></div>
          <div class="blog_feature_head">
            <h4>{{$jb->name}}</h4>
          </div>  
          <div class="blog_feature_cont">
            <p>{{$jb->description}}</p>
          </div>
        </div>
      </div>
      @endforeach
@endsection