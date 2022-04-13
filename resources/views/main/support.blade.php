@extends('layouts.app')


@section('title')
<meta name="description" content="#1 Ecommerce Solution for all types of business.. Airshop247, your digital space">
<title>SUPPORT  - AIRSHOP</title>
@endsection



@section('content')

<section >
    <section class="d-flex bg-light justify-content-center align-items-center hero mb-4" id="home" style="height: 300px; background: url('/static/media/public/img/support.jpeg')">
        <img class="img-fluid" src="/img/support.jpeg" style="object-fit: cover; object-position: center; width: 100%; height: 100%;"  alt="">
    </section>
<div class="container">
    <!-- Box -->
    <div class="box">
        <!-- info container -->
        <!-- form container -->
        <div class="row py-3 ">
            <section class="col-md-5 p-4 info">
                <h4 class="fw-bold">Airshop 24/7</h4>
                <div class="d-flex">
                    <p class="">
                    <i class="fa fa-road"></i> &nbsp; &nbsp;
                    </p>
                    <p>
                        <small>Block D19</small>
                        <br> <small>Railway Corporation,</small>
                        <br> <small>Dugbe, Ibadan</small>
                    </p>
                </div>
                <div class="d-flex">
                    <p> <i class="fa fa-phone"></i>&nbsp; &nbsp;</p>
                    <p><small>07038463454</small></p>
                </div>
                <div class="d-flex">
                    <p><i class="fa fa-envelope"></i>&nbsp; &nbsp;</p>
                    <p><small>support@airshop.com</small></p>
                </div>
            </section>
            <div class="col-md-7">
                
                <h3>Reach out to us for support</h3>
                <form method="POST" action=".">
                    @csrf
                    <!-- Name -->
                    <div class="name">
                        <label for="name">Name</label>
                        <br>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <!-- Company -->
                    <div class="business">
                        <label for="business">Business Name</label>
                        <br>
                        <input class="form-control" type="text" id="business" required>
                    </div>
                    <!-- Email -->
                    <div class="email">
                        <label for="email">Email</label>
                        <br>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <!-- Telephone -->
                    <div class="tele">
                        <label for="telephone">Phone Number</label>
                        <br>
                        <input type="tel" class="form-control" id="telephone" required>
                    </div>
                    <!-- Message -->
                    <div class="message">
                        <label for="message">Message</label>
                        <br>
                        <textarea class="form-control" cols="10" id="message"></textarea>
                    </div>
                    <!-- Submit -->
                    <div class="submit py-2 ">
                        <input class="btn btn-info text-white" type="submit" value="SUBMIT">
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>
</section>

@endsection