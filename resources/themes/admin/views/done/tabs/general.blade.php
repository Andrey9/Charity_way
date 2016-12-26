<div class="form-group required @if ($errors->has('status')) has-error @endif">
    {!! Form::label('status', trans('labels.status'), array('class' => 'control-label col-xs-4 col-sm-3 col-md-2')) !!}

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        {!! Form::select('status', ['1' => trans('labels.status_on'), '0' => trans('labels.status_off')], null, array('class' => 'form-control select2 input-sm', 'aria-hidden' => 'true')) !!}

        {!! $errors->first('status', '<p class="help-block error">:message</p>') !!}
    </div>
</div>

<div class="form-group @if ($errors->has('position')) has-error @endif">
    {!! Form::label('position', trans('labels.position'), ['class' => 'control-label col-xs-4 col-sm-3 col-md-2']) !!}

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        {!! Form::text('position', $model->position ?: 0, ['placeholder' => trans('labels.position'), 'class' => 'form-control input-sm']) !!}

        {!! $errors->first('position', '<p class="help-block error">:message</p>') !!}
    </div>
</div>

<div class="form-group @if ($errors->has('content')) has-error @endif">
    {!! Form::label('content', trans('labels.content'), ['class' => 'control-label col-xs-4 col-sm-3 col-md-2']) !!}

    <div class="col-xs-8 col-sm-7 col-md-10">
        {!! Form::textarea('content', isset($model->content) ? $model->content: '', ['rows' => '3', 'placeholder' => trans('labels.content'), 'class' => 'form-control input-sm content']) !!}

        {!! $errors->first('content', '<p class="help-block error">:message</p>') !!}
    </div>
</div>

<div class="form-group @if ($errors->has('value')) has-error @endif">
    {!! Form::label('value', trans('labels.value'), ['class' => 'control-label col-xs-4 col-sm-3 col-md-2']) !!}

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        {!! Form::text('value', $model->value ?: 0, ['placeholder' => trans('labels.value'), 'class' => 'form-control input-sm']) !!}

        {!! $errors->first('value', '<p class="help-block error">:message</p>') !!}
    </div>
</div>