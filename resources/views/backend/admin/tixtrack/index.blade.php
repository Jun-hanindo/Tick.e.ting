@extends('layout.backend.admin.master.master')

@section('title')
Tixtrack
@endsection

@section('header')
    {!! Html::style('assets/plugins/datatables/dataTables.bootstrap.css') !!}

@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ trans('general.member') }}</h3>
            <div class="pull-right">
                <span class="error-add-member"></span>
            </div>
        </div>
        <div class="box-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.account') }} </label>
                    <div class="col-sm-2">
                        {!! Form::select('account_id_member', $dropdown, null, ['class' => 'form-control', 'id' => 'account_id_member']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.customer_id') }} </label>
                    <div class="col-sm-2">
                        {!! Form::text('customer_id', old('customer_id'), ['class' => 'form-control number-only', 'id' => 'customer_id']) !!}
                    </div>
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.email') }} </label>
                    <div class="col-sm-2">
                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.first_name') }} </label>
                    <div class="col-sm-2">
                        {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'id' => 'first_name']) !!}
                    </div>
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.last_name') }} </label>
                    <div class="col-sm-2">
                        {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'last_name']) !!}
                    </div>
                </div>
            </div>
            <table id="member-datatables" class="table table-hover table-bordered table-condensed table-responsive datatables" data-tables="true">
                <thead>
                    <tr>
                        <!-- <th><input name="select_all" value="1" type="checkbox" class="select_all-checkbox"></th> -->
                        <th class="center-align">{{ trans('general.customer_id') }}</th>
                        <th class="center-align">{{ trans('general.email') }}</th>
                        <th class="center-align">{{ trans('general.first_name') }}</th>
                        <th class="center-align">{{ trans('general.last_name') }}</th>
                        {{-- <th width="12%"></th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ trans('general.transaction') }}</h3>
            <div class="pull-right">
                <span class="error-add-transaction"></span>
            </div>
        </div>
        <div class="box-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.account') }} </label>
                    <div class="col-sm-2">
                        {!! Form::select('account_id_order', $dropdown, null, ['class' => 'form-control', 'id' => 'account_id_order']) !!}
                    </div>
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.order_status') }} </label>
                    <div class="col-sm-2">
                        {!! Form::select('order_status', array('all' => 'All', 'Accepted' => 'Accepted', 'Cancelled' => 'Cancelled'), null, ['class' => 'form-control', 'id' => 'order_status']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.order_item_type') }} </label>
                    <div class="col-sm-2">
                        {!! Form::select('order_item_type', array('all' => 'All', 'Ticket' => 'Ticket', 'Delivery' => 'Delivery', 'Fee' => 'Fee'), null, ['class' => 'form-control', 'id' => 'order_item_type']) !!}
                    </div>
                    <label for="filter" class="col-sm-1 control-label width-percent-12 left-align">{{ trans('general.local_created') }} </label>
                    <div class="col-sm-2">
                        <input name="local_created" class="form-control datepicker" id="local_created" data-date-end-date="0d" value=>
                    </div>
                </div>
            </div>
            <table id="transaction-datatables" class="table table-hover table-bordered table-condensed table-responsive datatables" data-tables="true">
                <thead>
                    <tr>
                        <!-- <th><input name="select_all" value="1" type="checkbox" class="select_all-checkbox"></th> -->
                        <th class="center-align">{{ trans('general.order_id') }}</th>
                        <th class="center-align">{{ trans('general.local_created') }}</th>
                        <th class="center-align">{{ trans('general.event') }}</th>
                        <th class="center-align">{{ trans('general.customer') }}</th>
                        <th class="center-align">{{ trans('general.price') }}</th>
                        <th class="center-align">{{ trans('general.order_item_type') }}</th>
                        <th class="center-align">{{ trans('general.order_status') }}</th>
                        {{-- <th width="12%"></th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@include('backend.admin.tixtrack.script.index_script')