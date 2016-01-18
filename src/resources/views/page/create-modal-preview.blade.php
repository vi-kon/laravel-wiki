@extends('vi-kon.bootstrap::modal.modal-form')

<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-eye"></i>
    &nbsp;
    @lang('wiki::page/create.modal.preview.title')
@overwrite


@section('body')
    {!! $content !!}
@overwrite


@section('footer')
    <button type="button" class="btn btn-primary"
            data-loading-text="@lang('wiki::page/create.modal.preview.btn.save.loading')">
        @lang('wiki::page/create.modal.preview.btn.save.content')
    </button>
    <button type="button" class="btn btn-default" data-dismiss="modal">
        @lang('wiki::page/create.modal.preview.btn.back.content')
    </button>
@overwrite