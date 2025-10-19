@extends('frontend.layouts.main')

@section('main-container')
    <div class="error-page-wrapper" style="text-align:center; padding:80px 20px;">

      <img src="{{ asset('frontend/images/404.png') }}" alt="Not Found" style="
            max-width:350px;
            width:100%;
            display:block;
            margin:auto;
            position:relative;
            z-index:2;
    ">

        <h2 style="font-size:30px; font-weight:600; margin-top:30px;">
            Page Not Found
        </h2>

        <p style="font-size:16px; color:#555; margin:10px 0 20px;">
            The page you’re looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <p style="font-size:14px; color:#777; margin-bottom:30px; font-style:italic;">
            "Sometimes the best pages are the ones not yet discovered."
        </p>

        <a href="{{ url('/') }}" style="
            display:inline-block;
            padding:12px 30px;
            background:#000;
            color:#fff;
            text-decoration:none;
            border-radius:6px;
            font-size:15px;
            letter-spacing:0.5px;
        ">
            Go Back Home
        </a>
    </div>
@endsection
