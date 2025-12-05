@extends('layouts.app')

@section('content')
<div id="app">
    <navbar></navbar>
        <update-profile-form
        :user='@json(["name" => auth()->user()->name, "email" => auth()->user()->email, "image" => ""])'>
        </update-profile-form>
</div>
@endsection

@vite('resources/js/app.js')
