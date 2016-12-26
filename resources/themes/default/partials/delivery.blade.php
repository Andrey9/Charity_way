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
                        @lang('front_messages.numbers')
                    </div>

                </div>
                <div class="email_wrapper">
                    <div class="text_phon">e-mail:</div>
                    <div class="wraper_number_phon">
                        <div class="number_phon1">@lang('front_messages.email')</div>
                    </div>
                </div>
            </div>
            <div class="mail">
                <div class="wrapper_mail">
                    <form action="#">
                        <h3 class="caption_email">@lang('front_labels.contact_us')</h3>
                        <h4 class="text_for_caption">@lang('front_labels.contact_us_small')</h4>
                        <div class="wrap_input">
                            <div class="img_bg1"></div>
                            <input type="text" class="name_sender" placeholder="Ваше имя">
                            <div class="img_bg2"></div>
                            <input type="number" class="number_phon_sender" placeholder="Телефон">
                        </div>
                        <textarea type="text" class="massage" placeholder="Текст сообщения"></textarea>
                        <input type="submit" class="btn_massage" value="{!! trans('labels.write') !!}">
                    </form>
                </div>

            </div>

        </div>

    </div>
    <div class="bg_volna"></div>
</div>