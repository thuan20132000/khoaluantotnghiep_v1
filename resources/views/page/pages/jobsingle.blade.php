@extends('page.layouts.master')
@section('title')
    cart
@endsection
@section('content')

<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css1fonts/icomoon/style.css')}}">

<link rel="stylesheet" href="{{asset('job/css1/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/magnific-popup.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('job/css1/animate.css')}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">



<link rel="stylesheet" href="{{asset('job/css1/fonts/flaticon/font/flaticon.css')}}">

<link rel="stylesheet" href="{{asset('job/css1/aos.css')}}">

<link rel="stylesheet" href="{{asset('job/css1/style.css')}}">





        



<div class="site-section bg-light">
  <div class="container">
    <div class="row">
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
   @foreach ($job as $jb)
       
   
      <div class="col-md-12 col-lg-8 mb-5">
      
        
    
        <div class="p-5 bg-white">

          <div class="mb-4 mb-md-5 mr-5">
           <div class="job-post-item-header d-flex align-items-center">
             <h2 class="mr-3 text-black h4">{{$jb->name}}</h2>
             <div class="badge-wrap">
              <span class="border border-warning text-warning py-2 px-4 rounded"></span>
             </div>
           </div>
           <div class="job-post-item-body d-block d-md-flex">
             <div class="mr-3"><span class="fl-bigmug-line-portfolio23"></span> <a href="#">{{$jb->created_at}}</a></div>
             <div><span class="fl-bigmug-line-big104"></span> <span></span></div>
           </div>
          </div>


        
          <div class="img-border mb-5">
            
              @foreach($jb->images as $image)
            <img src="{{$image->image_url}}" style="width:300px;height:300px" alt="" srcset="">
          @endforeach
          
          </div>
        
      
          
          <h3>Giá công việc : {{$jb->suggestion_price}}VNĐ</h3>
          <h3>Mô tả công việc: {{$jb->description}}</h3>


          
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter-{{$jb->id}}">
            Ứng Tuyển Vị Trí
          </button>
          
          
          
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
    </div>
    



<div class="site-section">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-md-6" data-aos="fade" >
        <h2>Frequently Ask Questions</h2>
      </div>
    </div>
    

    <div class="row justify-content-center" data-aos="fade" data-aos-delay="100">
      <div class="col-md-8">
        <div class="accordion unit-8" id="accordion">
        <div class="accordion-item">
          <h3 class="mb-0 heading">
            <a class="btn-block" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">What is the name of your company<span class="icon"></span></a>
          </h3>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="body-text">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur quae cumque perspiciatis aperiam accusantium facilis provident aspernatur nisi optio debitis dolorum, est eum eligendi vero aut ad necessitatibus nulla sit labore doloremque magnam! Ex molestiae, dolor tempora, ad fuga minima enim mollitia consequuntur, necessitatibus praesentium eligendi officia recusandae culpa tempore eaque quasi ullam magnam modi quidem in amet. Quod debitis error placeat, tempore quasi aliquid eaque vel facilis culpa voluptate.</p>
            </div>
          </div>
        </div> <!-- .accordion-item -->
        
        <div class="accordion-item">
          <h3 class="mb-0 heading">
            <a class="btn-block" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">How much pay for 3  months?<span class="icon"></span></a>
          </h3>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="body-text">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel ad laborum expedita. Nostrum iure atque enim quisquam minima distinctio omnis, consequatur aliquam suscipit, quidem, esse aspernatur! Libero, excepturi animi repellendus porro impedit nihil in doloremque a quaerat enim voluptatum, perspiciatis, quas dignissimos maxime ut cum reiciendis eius dolorum voluptatem aliquam!</p>
            </div>
          </div>
        </div> <!-- .accordion-item -->

        <div class="accordion-item">
          <h3 class="mb-0 heading">
            <a class="btn-block" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">Do I need to register?  <span class="icon"></span></a>
          </h3>
          <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="body-text">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel ad laborum expedita. Nostrum iure atque enim quisquam minima distinctio omnis, consequatur aliquam suscipit, quidem, esse aspernatur! Libero, excepturi animi repellendus porro impedit nihil in doloremque a quaerat enim voluptatum, perspiciatis, quas dignissimos maxime ut cum reiciendis eius dolorum voluptatem aliquam!</p>
            </div>
          </div>
        </div> <!-- .accordion-item -->

        <div class="accordion-item">
          <h3 class="mb-0 heading">
            <a class="btn-block" data-toggle="collapse" href="#collapseFour" role="button" aria-expanded="false" aria-controls="collapseFour">Who should I contact in case of support.<span class="icon"></span></a>
          </h3>
          <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="body-text">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel ad laborum expedita. Nostrum iure atque enim quisquam minima distinctio omnis, consequatur aliquam suscipit, quidem, esse aspernatur! Libero, excepturi animi repellendus porro impedit nihil in doloremque a quaerat enim voluptatum, perspiciatis, quas dignissimos maxime ut cum reiciendis eius dolorum voluptatem aliquam!</p>
            </div>
          </div>
        </div> <!-- .accordion-item -->

      </div>
      </div>
    </div>
  
  </div>
</div>




</div>
@endsection
<script src="{{asset('job/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('job/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('job/js/jquery-ui.js')}}"></script>
<script src="{{asset('job/js/popper.min.js')}}"></script>
<script src="{{asset('job/js/bootstrap.min.js')}}"></script>
<script src="{{asset('job/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('job/js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('job/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('job/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('job/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('job/js/aos.js')}}"></script>


<script src="{{asset('job/js/mediaelement-and-player.min.js')}}"></script>

<script src="{{asset('job/js/main.js')}}"></script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
            var mediaElements = document.querySelectorAll('video, audio'), total = mediaElements.length;

            for (var i = 0; i < total; i++) {
                new MediaElementPlayer(mediaElements[i], {
                    pluginPath: 'https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/',
                    shimScriptAccess: 'always',
                    success: function () {
                        var target = document.body.querySelectorAll('.player'), targetTotal = target.length;
                        for (var j = 0; j < targetTotal; j++) {
                            target[j].style.visibility = 'visible';
                        }
              }
            });
            }
        });
</script>


<script>
  // This example displays an address form, using the autocomplete feature
  // of the Google Places API to help users fill in the information.

  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  var placeSearch, autocomplete;
  var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  };

  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
      document.getElementById(component).value = '';
      document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
    }
  }

  // Bias the autocomplete object to the user's geographical location,
  // as supplied by the browser's 'navigator.geolocation' object.
  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
      });
    }
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&libraries=places&callback=initAutocomplete"
    async defer></script>


