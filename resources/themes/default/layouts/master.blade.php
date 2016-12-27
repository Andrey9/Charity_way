<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @yield('meta')
    <link rel="stylesheet" href="{!! asset('assets/themes/default/main.css') !!}">
    <script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
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

    <script src="{!! asset('assets/themes/default/js/jquery-3.1.1.min.js') !!}"></script>
    <script src="{!! asset('assets/themes/default/js/main.js') !!}"></script>
    <script src="{!! asset('assets/themes/default/js/paralax.js') !!}"></script>
    <script src="{!! asset('assets/components/jquery/dist/jquery.min.js') !!}"></script>
    <script src="{!! asset('assets/themes/default/js/ajax_requests.js') !!}"></script>
</body>
</html>