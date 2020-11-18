@extends('page.layouts.master')
@section('title')
    cart
@endsection
@section('content')
<!-- inner page banner -->
<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">Shop Page</h1>
              <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li class="active">Shop</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<!-- section -->
<div class="section padding_layout_1 product_list_main">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/1.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/2.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Kaspersky Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/3.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Mcafee Livesafe Antivirus</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/4.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/5.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/6.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Kaspersky Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/7.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Mcafee Livesafe Antivirus</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/8.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/1.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/2.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Kaspersky Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/3.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Mcafee Livesafe Antivirus</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$24.99</span><span class="new_price"> $12.49</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
            <div class="product_list">
              <div class="product_img"> <img class="img-responsive" src="{{asset('assets/images/it_service/4.jpg')}}" alt=""> </div>
              <div class="product_detail_btm">
                <div class="center">
                  <h4><a href="it_shop_detail.html">Norton Internet Security</a></h4>
                </div>
                <div class="starratin">
                  <div class="center"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                </div>
                <div class="product_price">
                  <p><span class="old_price">$15.00</span> – <span class="new_price">$25.00</span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="side_bar">
          <div class="side_bar_blog">
            <h4>SEARCH</h4>
            <div class="side_bar_search">
              <div class="input-group stylish-input-group">
                <input class="form-control" placeholder="Search" type="text">
                <span class="input-group-addon">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </span> </div>
            </div>
          </div>
          <div class="side_bar_blog">
            <h4>GET A QUOTE</h4>
            <p>An duo lorem altera gloriatur. No imperdiet adver sarium pro. No sit sumo lorem. Mei ea eius elitr consequ unturimperdiet.</p>
            <a class="btn sqaure_bt" href="it_service.html">View Service</a> </div>
          <div class="side_bar_blog">
            <h4>OUR SERVICE</h4>
            <div class="categary">
              <ul>
                <li><a href="it_data_recovery.html"><i class="fa fa-angle-right"></i> Data recovery</a></li>
                <li><a href="it_computer_repair.html"><i class="fa fa-angle-right"></i> Computer repair</a></li>
                <li><a href="it_mobile_service.html"><i class="fa fa-angle-right"></i> Mobile service</a></li>
                <li><a href="it_network_solution.html"><i class="fa fa-angle-right"></i> Network solutions</a></li>
                <li><a href="it_techn_support.html"><i class="fa fa-angle-right"></i> Technical support</a></li>
              </ul>
            </div>
          </div>
          <div class="side_bar_blog">
            <h4>RECENT NEWS</h4>
            <div class="categary">
              <ul>
                <li><a href="it_data_recovery.html"><i class="fa fa-angle-right"></i> Land lights let be divided</a></li>
                <li><a href="it_computer_repair.html"><i class="fa fa-angle-right"></i> Seasons over bearing air</a></li>
                <li><a href="it_mobile_service.html"><i class="fa fa-angle-right"></i> Greater open after grass</a></li>
                <li><a href="it_network_solution.html"><i class="fa fa-angle-right"></i> Gathered was divide second</a></li>
              </ul>
            </div>
          </div>
          <div class="side_bar_blog">
            <h4>TAG</h4>
            <div class="tags">
              <ul>
                <li><a href="#">Bootstrap</a></li>
                <li><a href="#">HTML5</a></li>
                <li><a href="#">Wordpress</a></li>
                <li><a href="#">Bootstrap</a></li>
                <li><a href="#">HTML5</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end section -->
<!-- section -->
<div class="section padding_layout_1 testmonial_section white_fonts">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="main_heading text_align_left">
            <h2 style="text-transform: none;">What Clients Say?</h2>
            <p class="large">Here are testimonials from clients..</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-7">
        <div class="full">
          <div id="testimonial_slider" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
              <li data-target="#testimonial_slider" data-slide-to="0" class="active"></li>
              <li data-target="#testimonial_slider" data-slide-to="1"></li>
              <li data-target="#testimonial_slider" data-slide-to="2"></li>
            </ul>
            <!-- The slideshow -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="testimonial-container">
                  <div class="testimonial-content"> You guys rock! Thank you for making it painless, pleasant and most of all hassle free! I wish I would have thought of it first. 
                    I am really satisfied with my first laptop service. </div>
                  <div class="testimonial-photo"> <img src="{{asset('assets/images/it_service/client1.jpg')}}" class="img-responsive" alt="#" width="150" height="150"> </div>
                  <div class="testimonial-meta">
                    <h4>Maria Anderson</h4>
                    <span class="testimonial-position">CFO, Tech NY</span> </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-container">
                  <div class="testimonial-content"> You guys rock! Thank you for making it painless, pleasant and most of all hassle free! I wish I would have thought of it first. 
                    I am really satisfied with my first laptop service. </div>
                  <div class="testimonial-photo"> <img src="{{asset('assets/images/it_service/client2.jpg')}}" class="img-responsive" alt="#" width="150" height="150"> </div>
                  <div class="testimonial-meta">
                    <h4>Maria Anderson</h4>
                    <span class="testimonial-position">CFO, Tech NY</span> </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-container">
                  <div class="testimonial-content"> You guys rock! Thank you for making it painless, pleasant and most of all hassle free! I wish I would have thought of it first. 
                    I am really satisfied with my first laptop service. </div>
                  <div class="testimonial-photo"> <img src="{{asset('assets/images/it_service/client3.jpg')}}" class="img-responsive" alt="#" width="150" height="150"> </div>
                  <div class="testimonial-meta">
                    <h4>Maria Anderson</h4>
                    <span class="testimonial-position">CFO, Tech NY</span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="full"> </div>
      </div>
    </div>
  </div>
</div>
<!-- end section -->
<!-- section -->
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="contact_us_section">
            <div class="call_icon"> <img src="{{asset('assets/images/it_service/phone_icon.png')}}" alt="#" /> </div>
            <div class="inner_cont">
              <h2>REQUEST A FREE QUOTE</h2>
              <p>Get answers and advice from people you want it from.</p>
            </div>
            <div class="button_Section_cont"> <a class="btn dark_gray_bt" href="it_contact.html">Contact us</a> </div>
          </div>
        </div>
      </div>
      @endsection