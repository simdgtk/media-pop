@extends('layouts.app')

@section('content')
<div id="app" style="background-color: #FD494A; color: #FFFFFF;">
    <navbar color1="#FD494A" color2="#B8FF93"></navbar>
    <update-profile-form
        :user='@json(["name" => auth()->user()->name, "email" => auth()->user()->email, "image" => ""])'>
    </update-profile-form>
    <navbar-bottom></navbar-bottom>
    <onboarding-popup></onboarding-popup>
</div>
@endsection

@vite('resources/js/app.js')
