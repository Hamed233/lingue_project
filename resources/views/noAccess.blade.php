@extends('cp.layouts.adminMaster')

@section('content')
    @foreach ($users as $user)
        <h5>{{$user['first_name']}}</h5>
        <p>{{$user->roles->name}}</p>
    @endforeach
@endsection
