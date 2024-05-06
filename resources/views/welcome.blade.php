<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>fullstack blog</title>
        <script>
            //window._locale = "{{ app()->getLocale() }}";
            (function(){
                window.Laravel={
                csrfToken:'{{csrf_token()}}'
            };
            })();

        </script>


        <!-- Styles -->
        <link rel="stylesheet"  href="/css/all.css"/>
        <style>

        </style>
    </head>
    <body>
        <div id="app">
            <!--<test></test>-->
            @if (Auth::check())
                <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
            @else
                <mainapp :user="false"></mainapp>
            @endif

        </div>
        <script  src="{{mix('/js/app.js')}}"></script>
    </body>
</html>
