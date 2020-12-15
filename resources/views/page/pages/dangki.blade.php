<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>.register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}</style>

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

<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                        <h3>Việc Làm 24h</h3>
                
                        <input type="submit"  href="/loginn" method="get" value="Login"/><br/>
                        @csrf
                    </div>
                    <div class="col-md-9 register-right">
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Employee</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hirer</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Đăng Ký</h3>
                                <div class="row register-form">
                                    <div class="col-md-6">
									<form action="/registerrr" method="post">
										@csrf

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder=" Name " name="name" />
											@if ($errors->has('name'))
								                {{$errors->first('name')}}						
							                @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="email " name="email" />
											@if ($errors->has('email'))
								                {{$errors->first('email')}}						
							                @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="address " name="address" />
											@if ($errors->has('address'))
								                {{$errors->first('address')}}						
							                @endif
                                        </div>
										<div class="form-group">
                                            <input type="text" class="form-control" placeholder="phone " name="phonenumber" />
											@if ($errors->has('phonenumber'))
								                {{$errors->first('phonenumber')}}						
							                @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" name="password" />
										@if ($errors->has('password'))
								                {{$errors->first('password')}}						
							                @endif
                                        </div>
                                         
                             <div class="form-group">
                        <label for="image">Hình ảnh</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                
                                        <div class="form-group">
                                        <label for="exampleFormControlSelect1">Tôi Là</label>
                                         <select class="form-control" id="exampleFormControlSelect1" name="role">
                                         <option value="2">Nhà Tuyển Dụng</option>
                                         <option value="3">Người Tìm Việc</option>
                                         
                                            </select>
                                          
										    </div>
                                        

                                       <button type="submit" class="btn btn-primary">Đăng Ký</button>
                                    </div>
                                    
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            