@extends('layouts.app')

@section('content')

    <brands-component current-page="{{ Route::currentRouteName() }}"></brands-component>

@endsection