@extends('layout.backend.admin.master.master')

@section('title')
    {{trans('general.manage_page')}} - {{ $title }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ $title }} {{ trans('general.page') }}</h3>
                </div>
                {!! Form::open(array('url' => route('admin-post-update-manage-page', $slug),'method'=>'POST','id'=>'form-manage-page')) !!}
                    <div class="box-body">
                        @include('flash::message')
                        <div class="error"></div>
                        <input type="hidden" name="title" class="form-control" id="title" value="{{ $title }}">
                        <input type="hidden" name="slug" class="form-control" id="slug" value="{{ $slug }}">
                        <div class="form-group{{ Form::hasError('content') }} content">
                            {!! Form::textarea('content', $content, ['class' => 'form-control tinymce','rows'=>'15']) !!}
                            {!! Form::errorMsg('content') !!}
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{ route('admin-manage-page', $slug) }}" class="btn btn-default">{{ trans('general.button_cancel') }}</a>
                        <button type="button" id="button_draft2" class="btn btn-default" title="{{ trans('general.button_draft') }}">{{ trans('general.button_draft') }}</button>
                        <a href="{{ URL::to($slug.'?preview=true') }}" id="button_preview" class="btn btn-default {{ ($status == '') ? 'disabled' : '' }}" title="{{ trans('general.button_preview') }}">{{ trans('general.button_preview') }}</a>
                        <input class="btn btn-primary" title="{{ trans('general.button_save') }}" type="submit" value="{{ trans('general.button_publish') }}" id="button_submit">
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@include('backend.admin.manage_page.script.form_script')