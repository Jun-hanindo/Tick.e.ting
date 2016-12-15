@extends('layout.frontend.master.master')
@section('title', 'Terms of Ticket Sales - ')
@section('og_image', asset('assets/frontend/images/logo-share.jpg'))
@section('content')
@php
  $tag = '<--mobile-->';
@endphp
<section class="about-content ways-content">
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar sidebar-support">
                @include('layout.frontend.partial.support_left_side')
            </div>
        </div>
        <div class="col-md-9">
            <div class="main-content main-terms">
                <div class="support-desc">
                    <div class="row">
                        <h3 class="head-support font-light">Terms of Ticket Sales</h3>
                        <div class="col-md-12">
                            <div class="terms-content">
                                {!! strstr($content, $tag, true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ways-mobile mobile-content">
    <div class="row">
        <div class="col-md-12 mobile-sidebar">
            <div class="container">
                <div class="mobile-sidebar-menu">
                     @include('layout.frontend.partial.support_top_mobile')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="mobile-page-title">
                    <h3 class="font-light">Terms of Ticket Sales</h3>
                </div>
                <div class="terms-content">
                    {!! str_replace($tag, '', strstr($content, $tag)) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop