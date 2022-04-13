@extends('layouts.app')


@section('title')
<meta name="description" content="#1 Ecommerce Solution for all types of business.. Airshop247, your digital space">
<title>HOME  - AIRSHOP</title>
@endsection



@section('content')
    
<style>
    
    .news {
        width: 160px;
    }
    
    .news-scroll a {
        text-decoration: none;
    }
    
    .dot {
        height: 6px;
        width: 6px;
        margin-left: 3px;
        margin-right: 3px;
        margin-top: 2px !important;
        background-color: yellow;
        border-radius: 50%;
        display: inline-block
    }
    
    
    video{
    width:100%;
    height:80vh;
    }
    
    header{
        margin-bottom:65px;
    }
    
    @media only screen and (max-width:600px){
        video{
            height:auto;
        }
    }
    </style>
    <br />
    <div class="container my-3" >
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center breaking-news bg-white">
                    <div class="d-flex shadow py-2 flex-row flex-grow-1 flex-fill justify-content-center bg-primary py-2 text-white px-1 news"><span class="shadow d-flex align-items-center">&nbsp; Updates</span></div>
                    <marquee class="news-scroll" behavior="scroll" scrollamount="7" direction="left" onmouseover="this.stop();" onmouseout="this.start();"> 
                        <a class="text-info" href="#">Update!... </a> <span class="dot"></span> 
                        <a class="text-info" href="#">Update!!... </a> <span class="dot"></span> 
                        <a class="text-info" href="#">Update!!!... </a> <span class="dot"></span> 
                    </marquee>
                </div>
            </div>
        </div>  
    </div> 
    <div class="px-4 md-4 my-2" >
        <video style="width: 100%;" src="{{ asset ('video/market.mp4') }}" autoplay loop></video>
    </div>
        
@endsection