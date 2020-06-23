@extends('master')

@section('headr')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/bottom_footer.css') }}" />
    <style>
        h1, h2, h3, h4, h5, h6{
            font-family: 'Charmonman';
        }
    </style>
@endsection

@section('content')
      <div class="container-login-page">
        <div class="row no-gutters">
            <div class="col">
                <h1 class="elmgrens-logga mt-5 mb-5" >Familjen Elmgren</h1>
            </div>  
        </div>

        <div class="row no-gutters mb-3">
            <div class="col">
                <img src="{{ asset('/images/table_vietnam_blur.jpg') }}" class="img-fluid mx-auto d-block" id="login-img" alt="Familjen Elmgren på en strand i Vietnam">
            </div>  
        </div>
        
        <div class="row no-gutters">
            <div class="col">
                <form class="form-inline" id="login-form" method="post" action="{{ route('login') }}">
                    <div class="form-group mb-2">
                        <input type="hidden" name="email" value="trash@s.se"> <!-- Same email for every login -->
                        <label for="inputPassword2" class="sr-only" id="txtPassword">Password</label>
                        <input type="password" class="form-control mt-2" id="input-password" placeholder="Lösenord" name="password">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-lg btn-outline-primary ml-2" name="submit">Logga in</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer_big')

    <!-- ------------- scripts --------------------------------------- --> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endsection
