@extends('layouts.master')

@section('meta')
    <title>{!! $model->meta_title !!}</title>
    <meta name="title" content="{!! $model->meta_title !!}" />
    <meta name="description" content="{!! $model->meta_description !!}">
    <meta name="keywords" content="{!! $model->meta_keywords !!}">
    <meta property="og:title" content="{!! $model->meta_title !!}" />
    <meta property="og:description" content="{!! $model->meta_description !!}" />
    <meta property="og:image" content="{!! $model->image !!}" />
    <meta name="twitter:description" content="{!! $model->meta_title !!}">
    <meta name="twitter:description" content="{!! $model->meta_description !!}" />
    <meta name="twitter:image" content="{!! $model->image !!}" />
    <link rel="image_src" href="{!! $model->image !!}" />
@endsection

<script>
    console.log('{!! $model->meta_title !!}');
    console.log('{!! $model->meta_description !!}');
    console.log('{!! $model->meta_keywords !!}');
    console.log('{!! $model->image !!}');
</script>