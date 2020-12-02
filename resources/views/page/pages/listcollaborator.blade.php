@extends('page.layouts.master')
@section('title')
    list
@endsection
@section('content')
    @foreach($collaborators_all as $key => $collaborators_alls)
<div class="section padding_layout_1 product_list_main">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src={{$collaborators_alls->profile_image}} alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">{{$collaborators_alls->name}}</a></h4>
                </div>
                <h5>{{$collaborators_alls->email}}</h5>
                <h5>{{$collaborators_alls->phonenumber}}</h5>
                <h5>{{$collaborators_alls->address}}</h5>

              </div>
            </div>
          </div>
          @endforeach
@endsection