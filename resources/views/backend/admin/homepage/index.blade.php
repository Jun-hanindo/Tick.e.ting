@extends('layout.backend.admin.master.master')

@section('title')
{{ trans('general.homepages') }}
@endsection

@section('header')
    {!! Html::style('assets/plugins/datatables/dataTables.bootstrap.css') !!}

    <style>
        .center-align {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ trans('general.slider') }}</h3>
            <div class="pull-right">
                <a class="btn btn-primary actAddSlider" href="javascript:void(0)" title="{{ trans('general.create_new') }}"><i class="fa fa-plus fa-fw"></i></a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            <div class="error-slider"></div>
            <table id="homepage-sliders-table" class="table table-hover table-bordered table-condensed table-responsive" data-tables="true">
                <thead>
                    <tr>
                        <th class="center-align">Event</th>
                        <!-- <th class="center-align">Category</th> -->
                        <th width="12%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ trans('general.event') }}</h3>
            <div class="pull-right">
                <a class="btn btn-primary actAddEvent" href="javascript:void(0)" title="{{ trans('general.create_new') }}"><i class="fa fa-plus fa-fw"></i></a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            <div class="error-event"></div>
            <table id="homepage-events-table" class="table table-hover table-bordered table-condensed table-responsive" data-tables="true">
                <thead>
                    <tr>
                        <th class="center-align">Event</th>
                        <!-- <th class="center-align">Category</th> -->
                        <th width="12%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-form-slider" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ModalLabel"><span id="title-create-slider" style="display:none">{{ trans('general.create_new') }}</span><span id="title-update-slider" style="display:none">{{ trans('general.edit') }}</span></h4>
          </div>
          <div class="modal-body">
            <div class="error-slider"></div>
            <form id="form-slider">
                <input type="hidden" name="id_slider" class="form-control" id="id_slider">
                <input type="hidden" name="category" class="form-control" id="category" value="slider">
                <div class="form-group name">
                    <label for="event" class="control-label">{{ trans('general.event') }} :</label>
                    {!! Form::text('event_id', old('event_id'), array('id' => 'event_id_slider', 'class' => 'form-control','data-option' => old('event_id'))) !!}
                </div>
                
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="button_save-slider" class="btn btn-primary" title="{{ trans('general.button_save') }}">{{ trans('general.button_save') }}</button>
            <button type="button" id="button_update-slider" class="btn btn-primary" title="{{ trans('general.button_update') }}">{{ trans('general.button_update') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-form-event" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ModalLabel"><span id="title-create-event" style="display:none">{{ trans('general.create_new') }}</span><span id="title-update-event" style="display:none">{{ trans('general.edit') }}</span></h4>
          </div>
          <div class="modal-body">
            <div class="error-event"></div>
            <form id="form-event">
                <input type="hidden" name="id_event" class="form-control" id="id_event">
                <input type="hidden" name="category" class="form-control" id="category" value="event">
                <div class="form-group name">
                    <label for="event" class="control-label">{{ trans('general.event') }} :</label>
                    {!! Form::text('event_id', old('event_id'), array('id' => 'event_id_event', 'class' => 'form-control','data-option' => old('event_id'))) !!}
                </div>
                
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="button_save-event" class="btn btn-primary" title="{{ trans('general.button_save') }}">{{ trans('general.button_save') }}</button>
            <button type="button" id="button_update-event" class="btn btn-primary" title="{{ trans('general.button_update') }}">{{ trans('general.button_update') }}</button>
          </div>
        </div>
      </div>
    </div>

@endsection
@include('backend.admin.homepage.script.index_script')