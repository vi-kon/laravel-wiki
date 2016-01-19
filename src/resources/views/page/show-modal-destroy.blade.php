@extends('vi-kon.bootstrap::modal.modal-form')

<?php $formAction = route('ajax.modal.wiki.destroy', ['pageId' => $page->id]); ?>
<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-bin2"></i>
    &nbsp;
    @lang('wiki::page/show.modal.destroy.title')
@overwrite


@section('form')
    <p class="text-justify">@lang('wiki::page/show.modal.destroy.question')</p>
    <p class="text-justify text-muted">@lang('wiki::page/show.modal.destroy.note')</p>
@overwrite


@section('footer')
    <button type="button" class="btn btn-danger btn-submit"
            data-loading-text="@lang('wiki::page/create.modal.destroy.btn.yes.loading')">
        @lang('wiki::page/show.modal.destroy.btn.yes.content')
    </button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">
        @lang('wiki::page/show.modal.destroy.btn.no.content')
    </button>
@overwrite