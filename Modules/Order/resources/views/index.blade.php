@extends('order::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('order.name') !!}</p>
@endsection
