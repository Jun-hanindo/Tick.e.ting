@extends('layout.frontend.master.master')
@section('title', 'Page Title')
@section('content')
    @if(!empty($sliders))
        <section class="slider-home">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @foreach($sliders as $key => $slider) 
                        <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : ' '}}"></li>
                    @endforeach
                </ol>


                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">   
                        @foreach($sliders as $key => $slider)        
                            <div class="item {{ $key == 0 ? 'active' : ' '}}">
                              <img src="{{ $src.$slider->Event->featured_image1 }}" alt="...">
                              <div class="carousel-caption">
                                <div class="container">
                                    @php
                                        $cat = $slider->Event->Categories->first();
                                    @endphp 
                                    <h5>{{ $cat['name'] }}</h5>
                                    <h2>{{ $slider->Event->title }}</h2>
                                    <ul>
                                        @php 
                                            $schedule = $slider->Event->EventSchedule;
                                            $first = true;
                                        @endphp
                                        @if(!empty($schedule))
                                            @foreach($schedule as $sch)
                                                @if($first)
                                                    <li><div class="eventDate"><i class="fa fa-calendar"></i>{{ date('d F Y', strtotime($sch->date_at)) }}</div></li>
                                                    {{ $first = false }}
                                                @endif
                                            @endforeach
                                        @endif
                                        <li><div class="eventPlace"><i class="fa fa-map-marker"></i>{{ $slider->Event->Venue->name }}</div></li>
                                    </ul>
                                    <div class="moreDetail">
                                        <form action="{{ URL::route('event-detail', $slider->Event->slug) }}" style="margin-bottom:0;">
                                            <button class="btn btnDetail">More Details</button>
                                        </form>
                                    </div>
                                </div>
                              </div>
                            </div>
                        @endforeach
                    </div>
                

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </section>
    @endif
    @if(!empty($events))
    <section class="newRelease">
        <div class="container">
            <h2>New Release</h2>
            <div class="row">
                @foreach($events as $key => $event) 
                    <a href="{{ URL::route('event-detail', $event->Event->slug) }}">
                        <div class="col-md-4 box-release">
                            <img src="{{ $src.$event->Event->featured_image2 }}">
                            <div class="boxInfo box-info1 bg-{{ $event->Event->background_color }}">
                                <ul>
                                    @php
                                        $cat = $event->Event->Categories->first();
                                    @endphp      
                                    <li class="eventType">{{ $cat['name'] }}</li>
                                    <li class="eventName">{{ $event->Event->title }}</li>
                                    @php 
                                        $schedule = $event->Event->EventSchedule;
                                        $first = true;
                                    @endphp
                                    <li class="eventDate"><i class="fa fa-calendar-o"></i> 
                                    @if(!empty($schedule))
                                        @foreach($schedule as $sch)
                                            @if($first)
                                                {{ date('d F Y', strtotime($sch->date_at)) }}
                                                {{ $first = false }}
                                            @endif
                                        @endforeach
                                    @endif
                                    </li>
                                    <li class="eventPlace">{{ $event->Event->Venue->name }}</li>
                                </ul>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="loadMore">
                        <a href="{{ URL::route('discover')}}" class="btn btnLoad">Discover More Events</a>
            </div>
        </div>
    </section>
    @endif
    @if(!empty($promotions))
    <section class="latestPromo">
        <div class="container">
            <h2>Latest Promotions</h2>
            <div class="row">                
                @foreach($promotions as $key => $promotion) 
                @php
                    $data = $promotion->Event->promotions()->where('avaibility', true)->orderBy('start_date')->first();
                @endphp

                    <div class="col-md-4 box-promo">
                        <a href="#promoModal{{ $promotion->id }}" data-toggle="modal">
                            <img src="{{ $src.$promotion->Event->featured_image2 }}" class="image-promo">
                            <div class="boxInfo promo1">
                                <ul>
                                    <li class="eventType">
                                        @if($data->category == 'discounts')
                                            {{ $data->category = 'DISCOUNTS' }}
                                        @elseif($data->category == 'early-bird')
                                            {{ $data->category = 'EARLY BIRD' }}
                                        @else
                                            {{ $data->category = 'LUCKY DRAW' }}
                                        @endif
                                    </li>
                                    <li class="eventName">{{$data->title}} <img src="{{ $src2.$data->featured_image }}"></li>
                                    <li class="eventPlace">Valid From
                                        @php
                                            $m_start = date('m', strtotime($data->start_date));
                                            $m_end = date('m', strtotime($data->end_date));

                                            $y_start = date('Y', strtotime($data->start_date));
                                            $y_end = date('Y', strtotime($data->end_date));
                                        @endphp

                                        
                                        @if($m_start == $m_end && $y_start == $y_end)
                                            {{ date('d', strtotime($data->start_date)).' - '.date('d F Y', strtotime($data->end_date)) }}
                                        @elseif($m_start != $m_end && $y_start == $y_end)
                                            {{ date('d F', strtotime($data->start_date)).' - '.date('d F Y', strtotime($data->end_date)) }}
                                        @else
                                            {{ date('d F Y', strtotime($data->start_date)).' - '.date('d F Y', strtotime($data->end_date)) }}
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </a>
                        <div class="modal fade promoModal" id="promoModal{{ $promotion->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">{{$data->title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="promoBanner">
                                            <img height="166px" src="{{ $src.$promotion->Event->featured_image1 }}">
                                        </div>
                                        <div class="descPromoModal">
                                            <h4>About This Promotion</h4>
                                            <div class="promoBannerDesc">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <p>{!! $data->description !!}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="{{ $src2.$data->featured_image }}" class="promoLogo">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <h4>How to Participate </h4>
                                            <p>Show StarHub bill or subscription on any device such as mobile phone or tablet.</p> -->
                                            <h4>Promotion Period</h4>
                                            <p>Start Date: {{ date('d F Y', strtotime($data->start_date)) }}</p>
                                            <br>
                                            <p>End Date: {{ date('d F Y', strtotime($data->end_date)) }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4>Get Your Early Bird Tickets Now!</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <form action="{{ $promotion->Event->buylink }}">
                                                    <button type="button" class="btn btn-primary">Buy Now</button>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="loadMore">
                <a href="{{ URL::route('promotion')}}" class="btn btnLoad">More Promotions</a>
            </div>
        </div>
    </section>
    @endif
@stop