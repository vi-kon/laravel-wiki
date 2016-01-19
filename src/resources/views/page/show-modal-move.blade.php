@extends('vi-kon.bootstrap::modal.modal-form')

<?php $formAction = route('ajax.modal.wiki.move', ['pageId' => $page->id]); ?>
<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-folder"></i>
    &nbsp;
    @lang('wiki::page/show.modal.move.title')
@overwrite


@section('form')
    {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupText('source', '/' . $page->url, [
        'label'     => trans('wiki::page/show.modal.move.form.field.source.label'),
        'labelSize' => 3,
        'disabled'  => true,
        'index'     => 1,
    ]) !!}

    {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupText('destination', null, [
        'label'     => trans('wiki::page/show.modal.move.form.field.destination.label'),
        'labelSize' => 3,
        'index'     => 2,
    ]) !!}
@overwrite


@section('footer')
    <button type="button" class="btn btn-default" data-dismiss="modal">
        @lang('wiki::page/show.modal.move.btn.cancel.content')
    </button>
    <button type="button" class="btn btn-primary btn-submit"
            data-loading-text="@lang('wiki::page/show.modal.move.btn.save.loading')" data-index="3">
        @lang('wiki::page/show.modal.move.btn.save.content')
    </button>
@overwrite