
<header id="default_header" class="header_style_1">
  
  <!-- header bottom -->
  <div class="header_bottom">
    <div class="">
      <div class="d-flex fle-wrap">
        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
          <!-- logo start -->
          <div class="logo"> <a href="/"><img src="{{asset('assets/images/logos/vieclam24h_logo_meta_tag.jpg')}}" alt="logo" /></a> </div> 
          <!-- logo end -->
        </div>
        <div class="form-group search col-lg-3">
          <form class="form-inline" action="/search" method="get">
                            <input class="form-control mr-sm-2" type="search" name="key" placeholder="Nhập tên sản phẩm ..." aria-label="Search" required>
                            <button class="btn my-2 my-sm-0" type="submit">Tìm kiếm</button>
                        </form>
            </div>

          
          <!-- menu start -->
          <div class="menu_side">
            <div id="navbar_menu">
              <ul class="first-ul">
                <li> <a class="active" href="/">Trang Chủ</a>
                <li><a href="user">Người Tìm Việc</a></li>
                <li> <a href="it_service.html">Cộng Tác Viên</a>
                  <ul>
                    <li><a href="it_service_list.html">#</a></li>
                    <li><a href="it_service_detail.html">#</a></li>
                  </ul>
                </li>
                <li> <a href="it_shop.html">Job</a>
                  <ul>
                    <li><a href="{{asset('listJob')}}">Job List</a></li>
                    <li><a href="{{asset('jobdetail')}}">Shop Detail</a></li>
                    <li><a href="{{asset('shoppingcart')}}">Shopping Cart</a></li>
                    <li><a href="{{asset('checkout')}}">Checkout</a></li>
                  </ul>
                </li>
               @if (Auth::check())
                             @if(Auth::user()->role == 1)
                            <a href="/home">Admin</a>
                            @else
                            <a href="">{{Auth::user()->email}}</a>
                            @endif
                            <a href="/logout">Log out</a>
                        @else
                <li> <a href="/loginn">Đăng nhập</a>
                <li> <a href="/registerr">Đăng kí</a>
             @endif
          </div>
          <!-- menu end -->
        </div>
      </div>
    </div>
  </div>
  <!-- header bottom end -->
</header>