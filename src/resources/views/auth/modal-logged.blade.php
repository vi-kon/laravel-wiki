@extends('bootstrap::modal/modal-alert')


@section('title')
    <i class="icon-io-key"></i>
    &nbsp;
    @lang('wiki::auth/login.modal.login.title')
@overwrite


@section('type')
    alert-info
@overwrite


@section('message')
    @lang('wiki::auth/login.modal.logged.content', ['username' => $user->username])
@overwrite