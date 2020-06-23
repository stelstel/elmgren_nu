<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
               
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style_whole_site.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/index_new_base.css') }}" />
        <link rel="stylesheet" type="text/css" media="all and (min-width: 1281px)" href="{{ URL::asset('/css/index_new_wide.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/2015_and_forward.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/2018.css') }}" />
        <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">
        

        <title>Familjen Elmgren</title>
        @yield('headr')  
    </head>

    <body>
        @yield('content')

        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk="crossorigin="anonymous"></script>
    
        @yield('footer')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.js"></script>
        <script src="{{ URL::asset('js/elmgren.js') }}"></script>

    </body> 
</html>
