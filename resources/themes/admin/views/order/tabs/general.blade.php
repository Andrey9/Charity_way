<div class="form-group required @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', trans('labels.status'), array('class' => 'control-label col-xs-4 col-sm-3 col-md-2')) !!}

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        {!! Form::select('status', [
                'new' => trans('labels.new'),
                'wait_payment' => trans('labels.wait_payment'),
                'closed' => trans('labels.closed'),
                'canceled' => trans('labels.canceled')
            ],
            null, array('class' => 'form-control select2 input-sm', 'aria-hidden' => 'true')) !!}

        {!! $errors->first('status', '<p class="help-block error">:message</p>') !!}
    </div>
</div>

<div class="form-group @if ($errors->has('comment')) has-error @endif">
    {!! Form::label('comment', trans('labels.comment'), ['class' => 'control-label col-xs-4 col-sm-3 col-md-2']) !!}

    <div class="col-xs-8 col-sm-7 col-md-10">
        {!! Form::textarea('comment', isset($model->comment) ? $model->comment : '', ['rows' => '3', 'placeholder' => trans('labels.comment'), 'class' => 'form-control input-sm comment']) !!}

        {!! $errors->first('comment', '<p class="help-block error">:message</p>') !!}
    </div>
</div>

@include('partials.tabs.ckeditor', ['id' => 'comment'])

