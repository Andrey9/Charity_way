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







