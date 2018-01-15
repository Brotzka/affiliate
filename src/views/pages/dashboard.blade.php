@extends('affiliate::layout.app')

@section('content')
    <h1>Dashboard</h1>

    <pre>
        {{ print_r($values) }}
    </pre>
@endsection