@extends('page.layouts.master')

@section('content')

  
  <div class="container">
  <h2>CustomerJoblist</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">Đang Tuyển</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1">Chờ Xác Nhận</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu2">Đã Xác Nhận</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
      <h3>Đang Tuyển</h3></h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Chờ Xác Nhận</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Đã Xác Nha</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
</div>

@endsection

