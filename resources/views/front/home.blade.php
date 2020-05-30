@extends('front.app')
@section("title")
    {{ __("Home") }}
@endsection

@section('content')
<!-- /search_form start-->
<div class="search_form">
  <div class="container">
    <div class="row">


      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Area From</option>
          <option value="january" rel="icon-temperature">1000</option>
          <option value="february">800</option>
          <option value="march">600</option>
          <option value="april">400</option>
          <option value="may">200</option>
          <option value="june">100</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Property Status</option>
          <option value="For Sale" rel="icon-temperature">For Sale</option>
          <option value="For Rent">For Rent</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Location</option>
          <option value="United States" rel="icon-temperature">United States</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="American Samoa">American Samoa</option>
          <option value="Belgium">Belgium</option>
          <option value="Cameroon">Cameroon</option>
          <option value="Canada">Canada</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Property type</option>
          <option value="Residential" rel="icon-temperature">Residential</option>
          <option value="Commercial">Commercial</option>
          <option value="Land">Land</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Badrooms</option>
          <option value="1" rel="icon-temperature">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <select class="mounth">
          <option value="hide">Bathrooms</option>
          <option value="1" rel="icon-temperature">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            <div id="slider-range"></div>
          </div>
        </div>
        <div class="row slider-labels">
          <div class="col-lg-6 col-md-6 col-xs-6 col-6 caption"> <span id="slider-range-value1"></span> </div>
          <div class="col-lg-6 col-md-6 col-xs-6 col-6 text-right caption"> <span id="slider-range-value2"></span> </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="form-group">
          <button class="search-button btn-md btn-color" type="submit">Search Properties</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /search_form end-->




<!-- /welcome_box start-->
{{-- <div class="welcome_box">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="welcome_con">
          <h2>Welcome To <span class="text_change">Emperial Realty</span></h2>
          <p>{{ __("Emperial Realty got its start inventing map-based search. Everyone told us the easy money was in running ads for traditional brokers, but we couldn't stop thinking about how different real estate would be if it were designed from the ground up, using technology and totally different values, to put customers first. So we joined forces with agents who wanted to be customer advocates, not salesmen. Since these were our own agents, we could survey each customer on our service and pay a bonus based on the review.") }}</p>
        </div>
      </div>
      <div class="col-lg-12">
        <div id="demo" class="carousel slide" data-ride="carousel">
          <!--<ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active">01</li>
            <li data-target="#demo" data-slide-to="1">02</li>
            <li data-target="#demo" data-slide-to="2">03</li>
          </ul>-->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="carousel-caption1">
                <div class="property_img"> <img class="img-fluid" src="assets/images/expertise.jpg" alt=""> </div>
                <div class="property_con">
                  <h2>Expertise</h2>
                  <div class="address_box">
                    <p>Enter a world that is larger than life itself. CENTURY 21 Real Estate is in 79 countries & territories, with 7,450 offices, 115,000 agents. It is an international company with offices, agencies and gold jacket agents all over the globe.</p>
                  </div>

                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption1">
                <div class="property_img"> <img class="img-fluid" src="assets/images/market.jpg" alt=""> </div>
                <div class="property_con">
                  <h2>Ethical</h2>

                  <div class="address_box">
                    <p>Trained at CENTURY 21 University, every agent follows a rigorous training program before entering to their job, so we are sure to be knowledgeable and competent</p>
                  </div>

                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption1">
                <div class="property_img"> <img class="img-fluid" src="assets/images/image.jpg" alt=""> </div>
                <div class="property_con">
                  <h2>Market Strategies</h2>

                  <div class="address_box">
                    <p>Trained at CENTURY 21 University, every agent follows a rigorous training program before entering to their job, so we are sure to be knowledgeable and competent</p>
                  </div>

                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption1">
                <div class="property_img"> <img class="img-fluid" src="assets/images/teamwork.jpg" alt=""> </div>
                <div class="property_con">
                  <h2>Team Work</h2>

                   <div class="address_box">
                    <p>Trained at CENTURY 21 University, every agent follows a rigorous training program before entering to their job, so we are sure to be knowledgeable and competent</p>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="property_arrow"> <a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
<!-- /welcome_box end-->



@endsection
