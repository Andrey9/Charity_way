<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <link rel="stylesheet" href="{!! asset('assets/themes/default/css/styles.css') !!}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body>

<!-- Header -->
<header class="header clearfix">
    <div class="wrap_header clearfix">
        <a href="{!! route('home') !!}" class="logo "><img src="{!! asset('assets/themes/default/img/logo.png') !!}" ></a>

        <div class="wrap_caption_header">
            <div class="dum_class ">
                <div class="dum"></div>
            </div>
            <h1 class="caption_text1">@lang('front_labels.first_title')</h1>
            <h3 class="caption_text2 ">@lang('front_messages.first_title_mess_1') <span>@lang('front_messages.first_title_mess_1_span')</span> </h3>
            <h3 class="caption_text3">@lang('front_messages.first_title_mess_2')</h3>
            <div class="star_class">
                <div class="star"></div>
            </div>
        </div>

        <div class="wrapper_zadacha clearfix">
            <div class="clearfix">
                <img src="{!! $model->task_image !!}">
            </div>

            <div class="wrap_help">
                <h3 class="help_text1">@lang('front_labels.task')</h3>
                <h3 class="help_text2">@lang('front_messages.task')</h3>
                <a href="https://www.liqpay.com/" class="btn">@lang('labels.help_as_action')</a>
            </div>
            <div class="nipple_class">
                <div class="nipple"></div>
            </div>
        </div>
    </div>
    <div class="bg-white"></div>
</header>

<!-- Our idea -->
<div class="wrap_our_idea clearfix">

    <div class="wrap_header clearfix">
        <h3 class="caption_idea ">@lang('front_labels.what`s_our_idea')</h3>
        <div class="heart_class">
            <div class="heart">
            </div>
        </div>
        <div class="wrapper_idea clearfix">
            <div class="wrap_idea_text">
                @lang('front_messages.idea')
            </div>
            <div class="wr_border"> <div class="border"></div></div>
            <div class="candy_class">
                <div class="candy"></div>
            </div>
        </div>

    </div>

</div>
<div class="bg_hvuli1"></div>

<!-- Products -->
<div class="tovaru clearfix">
    <div class="wrap_header">
        <h3 class="caption_tovar">@lang('front_labels.product_title')</h3>
        <div class="tovar">
            {!! Widget::widget__product() !!}
            <a class="btn_next show_more">@lang('labels.show_more')</a>
            <h3 class="help_now">Или помогите прямо сейчас</h3>
            <a href="https://www.liqpay.com/" class="btn_help_naw">@lang('labels.help_as_action')</a>
        </div>
    </div>
</div>
<div class="bg_hvuli2"></div>


<!-- Done -->
<div class="wrap_work clearfix">

    <div class="wrap_header clearfix">
        <div class="star2_class">
            <div class="star2"></div>
        </div>
        <div class="wrapper_wor">
            <h3 class="work_caption">@lang('front_labels.done')</h3>
            <div class="wrap_block_work clearfix">
                {!! Widget::widget__done()!!}
            </div>
        </div>
    </div>
</div>
<div class="bg_hvuli3"></div>

<!--Order product popup-->
<div id="modal_form"></div>
<div id="overlay"></div>


<!--About product popup-->
<div id="modal_form1"></div>
<div id="overlay1"></div>

<!-- Partners -->
<div class="wrap_partner clearfix">
    <div class="wrap_header clearfix">
        <div class="wrp_block_part">
            <p class="caption_partner">@lang('front_labels.our_partners')</p>
            <div class="wrapper_partner clearfix">
                <div class="block_partner clearfix">
                    {!! Widget::widget__partner() !!}
                </div>
            </div>

        </div>
    </div>
</div>
<div class="bg_hvuli4"></div>

<!-- Delivery -->
<div class="wrap_delivery clearfix">
    <div class="wrap_header">
        <div class="wrapper_delivery clearfix">
            <div class="delivery">
                <div class="caption_delivery">@lang('front_labels.delivery')</div>
                <div class="wrapper_delivery_Ukraine">
                    <div class="marcer"></div>
                    <div class="wrap_text_delivery">
                        <div class="text_delivery1">по Украине</div>
                        <div class="text_delivery2">за 1-2 дня</div>
                    </div>
                </div>
                <div class="wrap_phon clearfix">
                    <div class="text_phon">Телефоны:</div>
                    <div class="wraper_number_phon">
                        <a href="tel:+38 098 739 23 12" class="number_phon1">+38 098 739 23 12</a>
                        <a  href="tel:+38 098 739 23 12" class="number_phon2">+38 098 739 23 12</a>
                    </div>
                </div>
                <div class="email_wrapper">
                    <div class="text_phon">e-mail:</div>
                    <div class="wraper_number_phon">
                        <a href="mailto:@lang('front_messages.email')" class="number_phon1">@lang('front_messages.email')</a>
                    </div>
                </div>
            </div>
            <div class="mail">
                <div class="wrapper_mail">
                    {!! Form::open(['role' => 'form', 'route' => 'feedback.store', 'id' => 'feedback-form']) !!}
                        <h3 class="caption_email">Напишите нам письмо по любому поводу</h3>
                        <h4 class="text_for_caption">Напишите нам письмо по любому поводу</h4>
                        <div class="wrap_input">
                            <div class="img_bg1"></div>
                            {!! Form::text('fio',null, ['class' => 'name_sender', 'placeholder' => 'Ваше имя', 'id' => 'feed_name', 'required' => true]) !!}
                            <div class="img_bg2"></div>
                            {!! Form::text('phone',null, ['class' => 'number_phon_sender', 'placeholder' => 'Телефон', 'id' => 'phone', 'required' => true, 'title' => 'Формат: 380 96 999 99 99']) !!}
                        </div>
                        {!! Form::textarea('message',null,['class' => 'massage', 'placeholder' => 'Текст сообщения', 'id' => 'feed_text', 'required' => true] ) !!}
                        {!! Form::submit(trans('labels.write'), ['class' => 'btn_massage']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="bg_volna"></div>
</div>

<!-- Tell about our project -->
<div class="wrap_tell">
    <div class="bg">
        <div class="wrap_header">
            <div class="tell">
                <h3 class="caption_tell">@lang('front_labels.share')</h3>
                <div class="social_network">
                    <a  href="https://www.facebook.com/sharer.php?u={!! urlencode(url()->current()) !!}" id="fb-share"
                        onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600'); return false;">
                        <span class="contact">
                            <div class="facebook"></div>
                            <div class="count_users">
                                <?php
                                $json = file_get_contents('http://graph.facebook.com/?id='.url()->current());
                                $result = json_decode($json);
                                echo isset($result->{'share'}->{'share_count'}) ? $result->{'share'}->{'share_count'} : 0;
                                ?>
                            </div>
                        </span>
                    </a>
                    <script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
                    <script type="text/javascript">
                        document.write(VK.Share.button({url: '{!! url()->current() !!}', title:'{!! $model->meta_title !!}' }, {type: 'custom',
                            text:   '<span class="contact">'+
                            '<div class="vk"></div>'+
                            '<div class="count_users">'
                            +'<?php
                                $val = intval(explode(',' , file_get_contents('https://vk.com/share.php?act=count&index=1&url='.url()->current()))[1]);
                                $val = !$val || empty($val) ? 0 : $val;
                                echo $val;
                                ?>'
                            +'</div></span>'
                        }));
                    </script>
                    <a href="https://twitter.com/share?url={!! urlencode(url()->current()) !!}&text={!! urlencode($model->meta_title) !!}"
                       onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600'); return false;">
                        <span class="contact">
                            <div class="twiter"></div>
                            <div class="count_users"></div>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .btn_next{
        cursor: pointer;
    }
    .social_network a {
        text-decoration: none;
    }
</style>
<!-- Scripts -->
<script src="{!! asset('assets/components/jquery/dist/jquery.min.js') !!}"></script>
<script src="{!! asset('assets/components/jquery.maskedinput/dist/jquery.maskedinput.min.js') !!}"></script>
<script src="{!! asset('assets/themes/default/js/main.js') !!}"></script>
<script >
    jQuery(function($){
        $("#phone").mask("+38(099) 999-9999");
    });

   /* $(document).on('click', '.wrap_hover_tovar', function(){
        var _id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: 'order_product',
            data: {
                id: _id
            }
        }).done(function(response){
            $('#modal_form').html(response);
            $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
                function () { // после выполнения предъидущей анимации
                    $('#modal_form')
                        .css('display', 'block') // убираем у модального окна display: none;
                        .animate({opacity: 1, top: '30%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
                });
        })
    })*/
</script>
</body>
</html>