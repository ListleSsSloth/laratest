@extends('layouts.app')

@section('content')

<h1><a href="{{url()->current()}}">Two Window Component</a></h1>

<div class="container">
    <div id="app">
        <two-window-component :vuedata="{{ json_encode($vue_component_data) }}"></two-window-component>
    </div>
</div>
    
@endsection