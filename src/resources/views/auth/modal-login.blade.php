@extends('bootstrap::modal/modal-form')


@section('title')
    <i class="icon-io-key"></i>
    &nbsp;
    @lang('wiki::auth/login.modal.login.title')
@stop


@section('form')
    @if($errors->has('form'))
        <div class="alert alert-danger">
            {{$errors->first('form')}}
        </div>
    @endif

    @include('bootstrap::form/group-text', [
        'label' => 'wiki::auth/login.modal.login.form.field.username.label',
        'name'  => 'username',
        'index' => 1
    ])

    @include('bootstrap::form/group-password', [
        'label' => 'wiki::auth/login.modal.login.form.field.password.label',
        'name'  => 'password',
        'index' => 2
    ])

@stop


@section('footer')
    <div class="modal-footer">

        {!!app('form')->button(trans('wiki::auth/login.modal.login.btn.cancel.content'), [
            'class'        => 'btn btn-default',
            'data-dismiss' => 'modal',
        ])!!}

        {!!app('form')->button(trans('wiki::auth/login.modal.login.btn.login.content'), [
            'class'             => 'btn btn-primary btn-submit',
            'data-loading-text' => trans('wiki::auth/login.modal.login.btn.login.loading'),
            'data-index'        => 3,
        ])!!}

    </div>
@stop
