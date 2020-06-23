<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
               
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style_whole_site.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/index_new_base.css') }}" />
        <link rel="stylesheet" type="text/css" media="all and (min-width: 1281px)" href="{{ URL::asset('/css/index_new_wide.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/2015_and_forward.css') }}" />
                        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
        <script src="{{ URL::asset('js/elmgren.js') }}"></script>

        <!--
            <script>
                var head = document.getElementsByTagName('head')[0];
                var js = document.createElement("script");
                var width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
                
                js.type = "text/javascript";
                
                if (width > 1280)
                {
                        
                        js.src = "{{ URL::asset('js/index_new_wide.js') }}";
                }
                else
                {
                        js.src = "{{ URL::asset('js/index_new_base.js') }}";
                }
                
                head.appendChild(js);
            </script>
        -->

        <title>Familjen Elmgren</title>
        @yield('headr')  
    </head>
    <body>
        @yield('content')    
    </body>
</html>
