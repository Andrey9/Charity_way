@extends('layouts.master')

@section('meta')
    <title>{!! $model->meta_title !!}</title>
    <meta name="description" content="{!! $model->meta_description !!}">
    <meta name="keywords" content="{!! $model->meta_keywords !!}">
@endsection