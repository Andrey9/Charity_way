<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @yield('meta')
    <link rel="stylesheet" href="{!! asset('assets/themes/default/main.css') !!}">
</head>
<body>

@include('partials.header')

@include('partials.idea')

@include('product.index')

@include('partials.done')

<div id="modal_form">

</div>

<div id="overlay"></div>

<div id="modal_form1">

</div>

<div id="overlay1"></div>

@include('partials.partners')

@include('partials.delivery')

@include('partials.share')
    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>--}}
    <script src="{!! asset('assets/themes/default/js/jquery-3.1.1.min.js') !!}"></script>
    <script src="{!! asset('assets/themes/default/js/main.js') !!}"></script>
    <script src="{!! asset('assets/themes/default/js/paralax.js') !!}"></script>
    <script src="{!! asset('assets/components/jquery/dist/jquery.min.js') !!}"></script>
    <script>

        //show more
        $('.show_more').on('click', function(){
            var _offset = $.find('.wrapper_tovar').length;
            $.ajax({
                type: 'get',
                url: 'show_more',
                data:{
                    offset: _offset
                }
            }).done(function(response){
                console.log(response);
                $('.wrapper_tovar:last').after(response);
            })
        });

        //load about modal window
        $(document).on('click','.btn_about_tovar', function(){
            var _id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: 'about_product',
                data:{
                    id: _id
                }
            }).done(function (response) {
                $('#modal_form1').html(response);
            })
        });

        //load order modal window
        $(document).on('click', '.btn_hover_tovar', function(){
            var _id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: 'order_product',
                data:{
                    id: _id
                }
            }).done(function(response){
                $('#modal_form').html(response);
            })
        })

        //order form submit
        $(document).on('submit', '#order-product', function(event){
            event.preventDefault();
            var formData = $(this).serialize();
            var formMethod = $(this).attr('method');
            var formUrl = $(this).attr('action');
            $.ajax({
                type: formMethod,
                url: formUrl,
                data: formData
//                beforeSend: function(){
//                    console.log(formData);
//                }
            }).done(function(response){
                console.log(response);
                $('#modal_form').html(response);
            })
        })

        $(document).on('click','.oplata1',function () { // ловим клик по крестику или подложке
            $('#modal_form1')
                .animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
                    function () { // после анимации
                        $(this).css('display', 'none'); // делаем ему display: none;
                        $('#overlay1').fadeOut(400); // скрываем подложку
                    }
                );
            var _id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: 'order_product',
                data:{
                    id: _id
                }
            }).done(function(response){
                $('#modal_form').html(response);
            })
            $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
                function () { // после выполнения предъидущей анимации
                    $('#modal_form')
                        .css('display', 'block') // убираем у модального окна display: none;
                        .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
                });
        });

    </script>
</body>
</html>