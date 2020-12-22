
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
                            <input class="form-control mr-sm-2" type="search" name="key" placeholder="Nhập tên việc làm ..." aria-label="Search" required>
                            <button class="btn  my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
            </div>

          
          <!-- menu start -->
          <div class="menu_side">
            <div id="navbar_menu">
              <ul class="first-ul">
                <li> <a class="active" href="/">Trang Chủ</a>
                <li><a href="user">Người Tìm Việc</a></li>
                <li> <a>Nhà Tuyển Dụng</a>
                  <ul>
                    <li><a href="postjob">Đăng Việc Làm</a></li>
                    
                  </ul>
                </li>
                <li> <a href="it_shop.html">Việc Làm</a>
                  <ul>
                    <li><a href="{{asset('listJob')}}">Danh Sách Việc Làm</a></li>
                    <li><a href="{{asset('jobdetail')}}">Shop Detail</a></li>

                  </ul>
                </li>
                 @if (Auth::check())
                 
                    <li> <a href="it_shop.html">Thông Tin cá Nhân</a>
                      <ul>
                        <li>
                         @if(Auth::user()->role == 1)
                            <a href="/profile">Admin</a>
                            @else
                            <a href="/profile">{{Auth::user()->email}}</a>
                            @endif
                        </li>
                        <li><a href="{{ route('getAuhorJobByStatus', ['author_id'=>Auth::user()->id,'status'=>2]) }}">Đang tuỷen</a></li>
                        <li><a href="{{ route('getAuhorJobByStatus', ['author_id'=>Auth::user()->id,'status'=>3]) }}">Cho chap nhan</a></li>
                        <li><a href="{{ route('getAuhorJobByStatus', ['author_id'=>Auth::user()->id,'status'=>4]) }}">Đã xác nhận</a></li>
                        <li>    
                                                    <a href="/logout">Log out</a>

                        </li>
                      </ul>
                    </li>
                             
               
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