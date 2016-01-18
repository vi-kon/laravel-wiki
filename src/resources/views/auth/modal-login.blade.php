<?php $formAction = route('ajax.modal.auth.login'); ?>

@extends('vi-kon.bootstrap::modal.modal-form')

<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-key"></i>
    &nbsp;
    @lang('wiki::auth/login.modal.login.title')
@stop

@section('form')
    {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupText('username', null, [
                       'label' => trans('wiki::auth/login.form.field.username.label'),
                       'index' => 1,
                   ]) !!}

    {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupPassword('password', [
                       'label' => trans('wiki::auth/login.form.field.password.label'),
                       'index' => 2,
                   ]) !!}
@stop



@section('footer')
    <button type="button" class="btn btn-primary btn-submit"
            data-loading-text="@lang('wiki::auth/login.modal.login.btn.login.loading')" data-index="3">
        @lang('wiki::auth/login.modal.login.btn.login.content')
    </button>

    <button type="button" class="btn btn-default" data-dismiss="modal">
        @lang('wiki::auth/login.modal.login.btn.cancel.content')
    </button>
@stop
