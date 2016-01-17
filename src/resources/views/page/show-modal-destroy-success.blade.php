@extends('bootstrap::modal/modal-alert')


@section('title')
    <i class="icon-io-folder"></i>
    &nbsp;
    @lang('wiki::page/show.modal.destroy-success.title')
@overwrite


@section('type')
    alert-success
@overwrite


@section('message')
    @lang('wiki::page/show.modal.destroy-success.content', ['title', $title])
@overwrite

@section('append')
    <script type="text/javascript">
        setTimeout(function () {
                    window.location.reload();
                }, 1000
        );
    </script>
@append
