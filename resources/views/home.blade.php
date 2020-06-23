  @extends('master')

  @section('headr')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/parallex.css') }}" />
        
    <style>
      .container-home-page {
        padding: 0px;
      }

      h1, h2, h3, h4, h5, h6{
        font-family: 'Charmonman';
        font-weight: bold;
      }
    </style>
  @endsection

  @section('content')
    @php
      //Session::flush(); // Remove all data from the session. Careful with this, you'll remove the CSRF Protection "token"
    @endphp
    
    <H1 id="birthdayReminder">{!! $birthdayMsg !!}</H1>
    
    <div class="hero">
      <h1>Familjen Elmgren</h1>
    </div>

    <div class="content-wrapper">
      <div class="container-fluid container-home-page">
        <a name="de-senaste-fotona"></a>       
        <div class="row mt-5 mb-4 mx-2">
          <h3 class="section-header">De senaste fotona</h3>
        </div>

        <div class="row mx-2 section-content">
          
          <div class="col my-auto px-1">
            {!! $latestPhotos[0] !!}  
          </div>
          <div class="col my-auto px-1">
            {!! $latestPhotos[1] !!}  
          </div>
          <div class="col my-auto px-1">
            {!! $latestPhotos[2] !!}    
          </div>
          <div class="col my-auto px-1">
            {!! $latestPhotos[3] !!}    
          </div>
          <div class="col my-auto px-1">
            {!! $latestPhotos[4] !!}   
          </div>
        </div>

        <div class="row mt-5 mx-2 no-gutters">
          <div class="col-1">
          </div>

          <a name="alla-foton"></a> 
          <div class="col-5">
              <h3 class="section-header section-header-left">Alla foton</h3> 
          </div>

          <div class="col-5">
            <div class="dropdown">
              <a class="mt-3 btn btn-lg btn-outline-primary dropdown-toggle float-left" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Välj år!
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                {!! $dropdownItems !!}
              </div>
            </div>
          </div>
          
          <div class="col-1">
          </div>
        </div>

        <div class="row no-gutters mt-5">
          <div class="col">
            <img src="{{ asset('/images/2004/vilmas_eyes_thin.jpg') }}" class="img-fluid mx-auto d-block" alt="Vilma">
          </div>  
        </div>

        <a name="search-foton"></a>
        <div class="row mt-5 mb-4 mx-2">
          <div class="col-12 mx-auto">
            <form class="form-inline justify-content-center" method="get">
              <label for="search-photos" class="mr-sm-2"><h3 class="section-header mb-0">Sök foton:</h3></label>
              <input type="search" class="form-control mb-2 mr-sm-2 mx-2" id="search-foton" name="search" autocomplete="off">
              <button type="submit" class="btn btn-lg btn-outline-primary mb-2" id="btnSearch">Sök</button>
            </form>
          </div>
        </div>

        <div class="row no-gutters mt-5">
          <div class="col">
            <img src="{{ asset('/images/2018/mids_stang_thin.jpg') }}" class="img-fluid mx-auto d-block" alt="Midsommarafton på Överlöpe">
          </div>  
        </div>

        <div class="row mt-5 mb-4 no-gutters">
          <div class="col-sm-6">
            <a name="fodelsedagar"></a>
            <div class="row">
              <h3 class="section-header mb-3">Födelsedagar</h3> 
            </div>
            {!! $birthdays !!}          
          </div>

          <div class="row d-sm-none mt-3 mb-5 no-gutters"><!-- hide on screens wider than sm. -->
            <div class="col">
              <img src="{{ asset('/images/1970-talet/kollo_78_thin.jpg') }}" class="img-fluid mx-auto d-block" alt="Daniel, Jessica och Stefan på Kollo på Överlöpe 1978">
            </div>  
          </div>  

          <div class="col-sm-6">
          <a name="epostadresser"></a>
            <div class="row no-gutters">
              <h3 class="section-header mb-3">Epostadresser</h3> 
            </div>
            <div class="row no-gutters">
              <p class="names-emails">Stefan Elmgren, stefan@elmgren.nu<br><br>Daniel Elmgren, daniel@elmgren.nu<br><br>Karin Elmquist, karin.elmquist@chello.se<br><br>Jessica Elmgren, jessica@elmgren.nu<br><br>Mikael Sjöblom, micke@elmgren.nu<br><br>Boine Elmgren, boine@elmgren.nu</p>
            </div>
          </div>
        </div>
      
        <div class="row mt-3 no-gutters">
          <div class="col">
            <img src="{{ asset('/images/2018/sofa_out_thin.jpg') }}" class="img-fluid mx-auto d-block" alt="Alvar, Jakob, Vilma och Idun på Överlöpe">
          </div> 
        </div>

        <div class="row mt-5 mb-2 no-gutters">
          <a name="uppdateringslogg"></a>
          <p id="update-log-button">
            <a class="btn btn-lg btn-outline-primary" data-toggle="collapse" href="#collapseUpdateLog" role="button" aria-expanded="false" aria-controls="collapseUpdateLog">
              Uppdateringslogg
            </a>
          </p>
        </div>
        <div class="row mb-3 no-gutters justify-content-center">
          <div class="collapse" id="collapseUpdateLog">
            <div class="card card-body update-log-card-body text-white mt-0 pt-0">
              <button class="btn btn-lg btn-outline-primary" type="button" id="btn-closeupdate-log">Stäng</button>
              {!! $updateLog !!}
            </div>
          </div>
        </div>
      </div>
         
         {!! $slides !!}
         {!! $yearOrSearchSlides !!}
    </div> <!-- <div class="content-wrapper"> END -->

  @endsection

  @section('footer')
     @include('partials.footer_big')

     <!-- ------------- scripts --------------------------------------- --> 
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>

      <!-- Bootstrap dropdown require Popper.js  -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

      <!-- ************************ Modal with Message to user START ******************************************* -->
      @if( null !== Session::get('msgToUser[0]' ) AND strlen( Session::get('msgToUser[0]') ) > 0 )
        <div id="msg-to-user-modal" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="msg-to-user-modal-content" class="modal-content">
              <div class="modal-header msg-to-user-modal-header">
                <p id="msg-to-user-modal-title" class="modal-title">{!! Session::get('msgToUser[1]') !!}</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p id="msg-to-user">{!! Session::get('msgToUser[2]') !!}</p>
              </div>
              <div class="modal-footer msg-to-user-modal-footer">
                <button type="button" class="btn btn-lg btn-outline-light" data-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>

        @php
          Session::forget('msgToUser[0]'); 
          Session::forget('msgToUser[1]');
          Session::forget('msgToUser[2]');
        @endphp
      @endif
      <!-- ************************ Modal with Message to user END ******************************************* -->
  @endsection