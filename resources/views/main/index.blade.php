@extends('layouts.app')

@section('title')
<meta name="description" content="#1 Ecommerce Solution for all types of business.. Airshop247, your digital space">
<title>HOME  - AIRSHOP</title>
@endsection

@section('content')
<section class="hero bg-white" id="home">
    <div class="container">
        <div class="row hero-body pt-0">
            <div class="col-md-6 d-flex flex-column justify-content-center hero-text" >
                <p class="subtitle m-0 mb-2 font-title">AIR SHOP</p>

                    <div class="columns">
                        <h3 class="title m-0 w-75">
                        <span class="has-text-info">#1</span> ECOMMERCE SOLUTION FOR ALL TYPES OF BUSINESS
                        </h3>
                    </div>
                    <div class="columns w-75">
                        <p class="column m-0 is-four-fifths ">At AIR we make it easier for all businesses to react more prospects. </p>
                    </div>
                    <div class="mt-3">
                        <a href="/account/join" class="btn text-white btn-info py-3 px-4">
                            GET STARTED FOR FREE
                        </a>
                    </div>
                </div>

                <div class="col-md-6 hero-img">
                    <img src="{{ asset ('video/tailor.gif') }}" class="img-fluid"/>
                </div>
            </div>
        </div>
    </section>
    <div class="space"></div>
    <section id="air_make">
        <div class="container my-4">
            <div class="row flex-wrap">
                <div class="col-md-6 d-flex justify-content-center">
                    <figure class="image">
                        <img class="img-fluid" src="{{asset ('img/Screenshot_20210626-153105.png') }}" alt="">
                    </figure>
                </div>
                <div class="col-md-6">
                    <div id="content" class="content d-flex justify-content-center align-items-center flex-column">
                        <h3 class="h3">AIR make it easier for customers to contact you.</h3>
                        <p>With Air, you can now do more because there are  more ways to transact with the customers that are ready to patronise  you...... Air shop 247.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="space"></div>
    <section class="py-5 bg-light" id="start">
        <div class="container">
            <img src="{{ asset('/img/start_img.jpg') }}" alt="" class="shadow-sm card rounded-pill mx-auto img-fluid">
            <h3 class="my-4">START YOUR ECOMMERCE JOURNEY TODAY</h3>
            @if (Auth::check())
            <a href="/dashboard" class="btn py-3 shadow-sm px-4 btn-info text-white">DASHBOARD</a>
            @else
            <a href="/account/join" class="btn py-3 shadow-sm px-4 btn-info text-white">SIGN UP NOW!</a>
            @endif
        </div>
    </section>
    <div class="space"></div>
    <section id="why_us">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center align-items-center flex-column">
                    <h3 class="text-center">WHY AIR</h3>
                    <p class="text-center">Air was launched to make it easy for ambitious businesses to reach more customers and to help them succeed in this competitive market and whatever success means to them.</p>
                </div>
                <div class="col-md-6" id="content">
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="space">
    </div>


@endsection
