@extends('vi-kon.bootstrap::modal.modal')

<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-folder"></i>
    &nbsp;
    @lang('wiki::page/show.modal.destroy-success.title')
@overwrite

@section('body')
    <div class="alert alert-success" role="alert">
        @lang('wiki::page/show.modal.destroy-success.content', ['title', $title])
    </div>
@overwrite

@section('append')
    <script type="text/javascript">
        setTimeout(function () {
                    window.location.reload();
                }, 1000
        );
    </script>
@append