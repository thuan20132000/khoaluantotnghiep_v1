@extends('page.layouts.master')
@section('title')
    list
@endsection
@section('content')

<div class="section padding_layout_1 product_list_main">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row">
        @foreach($users as $key => $us)
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src={{$us->profile_image}} alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">{{$us->name}}</a></h4>
                </div>
                <h5>Email : {{$us->email}}</h5>
                <h5>Số Điện Thoại : {{$us->phonenumber}}</h5>
                <h5>Địa Chỉ : {{$us->address}}</h5>

              </div>
            </div>
          </div>
          @endforeach
@endsection