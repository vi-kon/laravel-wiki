@extends('bootstrap::modal/modal-form')


@section('title')
    <i class="icon-io-folder"></i>
    &nbsp;
    @lang('wiki::page/show.modal.move.title')
@overwrite


@section('form')
    @include('bootstrap::form/group-text', [
            'label'     => 'wiki::page/show.modal.move.form.field.source.label',
            'labelSize' => 3,
            'name'      => 'source',
            'index'     => 1,
            'value'     => '/' . $page->url,
            'disabled'  => true,
        ])

    @include('bootstrap::form/group-text', [
            'label'     => 'wiki::page/show.modal.move.form.field.destination.label',
            'labelSize' => 3,
            'name'      => 'destination',
            'index'     => 2,
        ])
@overwrite


@section('footer')
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            @lang('wiki::page/show.modal.move.btn.cancel.content')
        </button>
        <button type="button" class="btn btn-primary btn-submit"
                data-loading-text="@lang('wiki::page/show.modal.move.btn.save.loading')" data-index="3">
            @lang('wiki::page/show.modal.move.btn.save.content')
        </button>
    </div>
@overwrite