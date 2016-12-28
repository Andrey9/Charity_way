<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <link rel="stylesheet" href="{!! asset('assets/themes/default/main.css') !!}">
</head>
<body>

@include('partials.header')

@include('partials.idea')

@include('product.index')

@include('partials.done')

{{--Order product popup--}}
<div id="modal_form"></div>

<div id="overlay"></div>
{{--end--}}

{{--About product popup--}}
<div id="modal_form1"></div>

<div id="overlay1"></div>
{{--end--}}

@include('partials.partners')

@include('partials.delivery')

@include('partials.share')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="{!! asset('assets/themes/default/js/jquery-3.1.1.js') !!}"></script>
<script src="{!! asset('assets/components/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/main.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/jquery.maskedinput.min.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/paralax.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/is.mobile.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/script.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/maskedinput.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/ajax_requests.js') !!}"></script>
<script >

    jQuery(function($){
        $("#phone").mask("+38(099) 999-9999");
    });

</script>
</body>
</html>