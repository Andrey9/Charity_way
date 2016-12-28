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
                <input type="button" class="btn" value="{!! trans('labels.help_as_action') !!}">
            </div>
            <div class="nipple_class">
                <div class="nipple"></div>
            </div>
        </div>
    </div>
    <div class="bg-white"></div>
</header>