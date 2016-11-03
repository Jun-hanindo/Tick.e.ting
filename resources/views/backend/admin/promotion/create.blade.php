@extends('layout.backend.admin.master.master')

@section('title')
    {{ trans('general.promotions') }} - {{ trans('general.add') }} {{ trans('general.promotion') }}
@endsection

@section('header')

    <style>
        #start_date, #end_date{
            border-radius: 0;
        }
        #discount-percent, #discount-nominal{
            margin-left: 10px;
        }
        .bootstrap-switch{
            float: left;
        }
        img[src=""] {
            display: none;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('general.add') }} {{ trans('general.promotion') }}</h3>
                </div>
                {!! Form::open(array('url' => route('admin-post-promotion'),'files'=>'true','method'=>'POST','id'=>'form-promotion')) !!}
                    <div class="box-body">
                        @include('flash::message')
                        <div class="error"></div>
                        <div class="col-md-9">
                            <div class="form-group{{ Form::hasError('title_promo') }} title_promo">
                                {!! Form::label('title_promo', trans('general.title').' *') !!}
                                {!! Form::text('title_promo', old('title_promo'), ['class' => 'form-control','maxlength'=>'255', 'placeholder' => trans('general.title')]) !!}
                                {!! Form::errorMsg('title_promo') !!}
                            </div>
                            <div class="form-group{{ Form::hasError('description_promo') }} description_promo">
                                {!! Form::label('description_promo', trans('general.description').' *') !!}
                                {!! Form::textarea('description_promo', old('description_promo'), ['class' => 'form-control tinymce', 'rows'=> '5', 'placeholder' => trans('general.description')]) !!}
                                {!! Form::errorMsg('description_promo') !!}
                            </div>


                            <div class="form-group{{ Form::hasError('discount') }} discount {{ Form::hasError('discount_nominal') }} discount_nominal full-width">
                                {!! Form::label('discount', trans('general.discount'), array('class' => 'full-width ')) !!}
                                {!! Form::checkbox('discount_type', '1', true, ['class' => 'form-control pull-left discount_type-check', 'data-animate' => 'false', 'data-on-text' => 'Percent',  'data-off-color' => 'success', 'data-off-text' => 'Nominal']) !!}
                                <div id="discount-percent" class="pull-left col-sm-3">
                                    <div class="input-group ">
                                        {!! Form::text('discount', old('discount'), ['id' => 'discount', 'class' => 'form-control number-only percent','maxlength'=>'255', 'placeholder' => trans('general.discount')]) !!}
                                        <div class="input-group-addon">%</div>
                                    </div>
                                    {!! Form::errorMsg('discount') !!}
                                </div>
                                <div id="discount-nominal" class="pull-left col-sm-4" style="display:none">
                                    <div class="input-group currency-value">
                                        {!! Form::select('currency_id', $data['currencies'], $data['currency_sel'], array('class' => 'form-control','data-option' => old('currency_id'))) !!}
                                        {!! Form::text('discount_nominal', old('discount_nominal'), ['id' => 'discount_nominal', 'class' => 'form-control number-only nominal','maxlength'=>'255', 'placeholder' => trans('general.discount')]) !!}
                                    </div>
                                    {!! Form::errorMsg('discount_nominal') !!}
                                </div>
                            </div>


                            <div class="form-group{{ Form::hasError('discount_period') }} discount_period full-width">
                                {!! Form::label('discount_period', trans('general.discount_period'), array('class' => 'full-width ')) !!}
                                <div class="col-sm-3 row form-group{{ Form::hasError('start_date') }}">
                                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control  datepicker', 'id' => 'start_date', 'maxlength'=>'255', 'placeholder' => trans('general.start_date')]) !!}
                                    {!! Form::errorMsg('start_date') !!}
                                </div>
                                {!! Form::label('to', trans('general.to'), array('class' => 'col-sm-1 control-label')) !!}
                                <div class="col-sm-3 row form-group{{ Form::hasError('end_date') }}">
                                    {!! Form::text('end_date', old('end_date'), ['class' => 'form-control  datepicker', 'id' => 'end_date','maxlength'=>'255', 'placeholder' => trans('general.end_date')]) !!}
                                    {!! Form::errorMsg('end_date') !!}
                                </div>
                            </div>
                            <div class="form-group{{ Form::hasError('promotion_code') }} promotion_code full-width">
                                {!! Form::label('promotion_code', trans('general.promotion_code'), array('class' => 'full-width ')) !!}
                                <div class="col-sm-4 row">
                                    {!! Form::text('promotion_code', old('promotion_code'), ['class' => 'form-control','maxlength'=>'255', 'placeholder' => trans('general.promotion_code')]) !!}
                                    {!! Form::errorMsg('promotion_code') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ Form::hasError('featured_image') }} featured_image">
                                {!! Form::label('featured_image', trans('general.featured_image').'(Max. 2880px x 800px) *') !!}
                                (Max. size 1 mb)
                                <input id="featured_image" name="featured_image" class="form-control image" data-name="image" type="file" value="">
                                {!! Form::errorMsg('featured_image') !!}
                            </div>
                            <div class="form-group privew" id="div-preview_image" data-name="image" style="display:none">
                                <img src="" name="preview" id="preview_image" height="50%" width="50%">
                            </div>
                            <div class="form-group{{ Form::hasError('featured_image_link') }} featured_image_link">
                                {!! Form::label('featured_image_link', trans('general.featured_image_link')) !!}
                                {!! Form::text('featured_image_link', old('featured_image_link'), ['class' => 'form-control','maxlength'=>'255', 'placeholder' => trans('general.featured_image_link')]) !!}
                                {!! Form::errorMsg('featured_image_link') !!}
                            </div>
                            <div class="form-group{{ Form::hasError('category') }} category">
                                {!! Form::label('category', trans('general.category')) !!}
                                {!! Form::select('category', array('discounts' => 'Discounts',
                                                                'lucky-draws' => 'Lucky Draws', 
                                                                'early-bird' => 'Early Bird'), old('category'), ['class' => 'form-control category', 'id' => 'category']) !!}
                                {!! Form::errorMsg('category') !!}
                            </div>
                            <div class="box-footer">
                                <a href="{{ route('admin-index-promotion') }}" class="btn btn-default">{{ trans('general.button_cancel') }}</a>
                                <input class="btn btn-primary pull-right" title="{{ trans('general.button_save') }}" type="submit" value="{{ trans('general.button_publish') }}" id="button_submit">
                            </div>
                        </div>
                        
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@include('backend.admin.promotion.script.create_script')