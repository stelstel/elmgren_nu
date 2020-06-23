  @extends('master')

  @include('partials.topnav')

  @section('content')
    <div class="container">
      <div class="jumbotron">
      </div>
    </div>
    <p id="updated">Senast uppdaterad xxx from js</p>
    <p id="webmaster"><a href="mailto:webmaster@elmgren.nu">webmaster@elmgren.nu</a></p>
    <img id="bglogin" src="{{ asset('/images/table_vietnam_bg_1280.jpg') }}" class="bgwidth" alt="">

    <!-- ------------- scripts --------------------------------------- -->  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  @endsection
