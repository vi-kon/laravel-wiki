@extends('vi-kon.bootstrap::modal.modal-form')

<?php $onlyContent = true ?>

@section('title')
    <i class="icon-io-bin2"></i>
    &nbsp;
    @lang('wiki::page/create.modal.cancel.title')
@overwrite


@section('body')
    <p class="text-justify">@lang('wiki::page/create.modal.cancel.question')</p>
    <p class="text-justify text-muted">@lang('wiki::page/create.modal.cancel.note')</p>
@overwrite


@section('footer')
    <button type="button" class="btn btn-danger btn-submit"
            data-loading-text="@lang('wiki::page/create.modal.cancel.btn.yes.loading')">
        @lang('wiki::page/create.modal.cancel.btn.yes.content')
    </button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">
        @lang('wiki::page/create.modal.cancel.btn.no.content')
    </button>
@overwrite


@section('append')
    <script type="text/javascript">
        (function ($) {
            var modal = $('#modal');
            modal.find('.modal-footer').find('.btn-danger').on('click', function () {
                ajax.ajax('{{route('ajax.modal.wiki.create.cancel', ['page' => $page->id])}}', {
                    type: 'post',
                    data: {
                        _token: '{{csrf_token()}}'
                    }
                }).done(function () {
                    window.location.href = "{{route('wiki.show', ['url' => $page->url])}}";
                });
            });
        })(jQuery);
    </script>
@append