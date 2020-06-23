  @extends('master')

  @section('headr')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
  @endsection

  @include('partials.topnav')

  @section('content')
  <div class="container" id="contStart">
    <div class="row vcenter">
      <div class="col-sm-9" id="content">
        
          <!-- First photo in slideshow. Photo on year-page-->
          @if ( isset($firstPhoto) )
            <img id="stel-first-img" class="img-responsive" src="{{ $firstPhoto }}">
          @endif

          @if (isset($msgToUser))
            <div class="alert alert-danger msg-to-user" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign msg-to-user-glyph" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              {{ $msgToUser }}
            </div>
          @endif

          <div class="jumbotron">
          </div>
      </div>
      <div class="col-sm-3" id="bigLeftText">
          <!-- Big year text on white background --> 
          <div id="yearWell" class="well well-lg"><h1>{{ $searchTerms }}</h1></div>
          
          @if(isset($bigYearButton))
            <button type="button" id="stel-photo-btn" class="btn btn-primary btn-lg"{!! $bigYearButton !!}</button>
          @endif
      
      </div>
    </div> <!-- End row -->
  </div> <!-- End container -->
    @if(isset($slideshow))
      {!! $slideshow !!}
    @endIf               
    <!-- ------------- scripts --------------------------------------- -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
  @endsection
