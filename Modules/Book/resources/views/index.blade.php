@extends('book::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('book.name') !!}</p>
@endsection
