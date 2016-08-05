@extends('layout.backend.admin.master.master')

@section('title')
    {{trans('general.manage_page')}} - {{ trans('general.privacy_policy') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('general.privacy_policy') }} {{ trans('general.page') }}</h3>
                </div>
                {!! Form::open(array('url' => route('admin-post-update-privacy-policy'),'method'=>'POST','id'=>'form-privacy-policy')) !!}
                    <div class="box-body">
                        <div class="error"></div>
                            <div class="form-group{{ Form::hasError('description') }} description">
                                {!! Form::textarea('description', old('description'), ['class' => 'form-control tinymce','rows'=>'18']) !!}
                                {!! Form::errorMsg('description') !!}
                            </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@include('backend.admin.manage_page.script.form_script')