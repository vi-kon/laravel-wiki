@extends('wiki::layout')


@section('styles')
    <link type="text/css" rel="stylesheet" media="all" href="{!!asset('vendor/codemirror/lib/codemirror.css')!!}"/>
@append


@section('scripts-head')
    <script type="text/javascript" src="{!!asset('vendor/codemirror/lib/codemirror.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('vendor/codemirror/mode/markdown/markdown.js')!!}"></script>
@append


@section('scripts')
    <script type="text/javascript">
        (function ($, undefined) {
            "use strict";

            var editor, changed, autoSave, autoSaveTimeout;

            changed = false;
            autoSaveTimeout = null;

            autoSave = function () {
                autoSaveTimeout = null;
                editor.save();
                ajax.ajax('{!!route('ajax.wiki.create.store-draft', ['page' => $page->id])!!}', {
                    data            : $('#editor').closest('form').serialize(),
                    openModalOnError: false
                }).done(function (data) {
                    if (data !== undefined && data.hasOwnProperty('success') && data.success) {
                        $('time').html($.timeago(new Date()));
                    }
                });
            };

            editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
                mode          : "markdown",
                lineNumbers   : true,
                theme         : "default",
                extraKeys     : {
                    "Enter": "newlineAndIndentContinueMarkdownList"
                },
                lineWrapping  : true,
                viewportMargin: Infinity
            });
            editor.on("change", function (cm) {
                changed = true;
                if (autoSaveTimeout === null) {
                    autoSaveTimeout = setTimeout(autoSave, 1000);
                }
            });

            $('.js-btn-save').click(function () {
                editor.save();
                ajax.ajax('{!!route('ajax.wiki.create.store', ['page' => $page->id])!!}', {
                    data: $('#editor').closest('form').serialize()
                }).done(function (data) {
                    var content;

                    if (data === undefined || !data.hasOwnProperty('success') || !data.success) {
                        content = '@lang('wiki::page/create.modal.save.msg.error')';
                        if (data.hasOwnProperty('type')) {
                            switch (data.type) {
                                case 'not-modified':
                                    content = '@lang('wiki::page/create.modal.save.msg.not-modified')';
                                    break;
                            }
                        }
                        openModal({
                            content: '<div class="modal-header">' +
                            '' + '<span class="icon-io-disk"></span> @lang('wiki::page/create.modal.save.title')' +
                            '' + '<button type="button" class="close" data-dismiss="modal">' +
                            '' + '' + '<span aria-hidden="true">&times;</span><span class="sr-only">@lang('base.modal.btn.close.content')</span>' +
                            '' + '</button>' +
                            '</div>' +
                            '<div class="modal-body">' +
                            '' + '<div class="alert alert-warning">' + content + '</div>' +
                            '</div>'
                        });
                    } else {
                        window.location.href = "{!!route('wiki.show', ['url' => $page->url])!!}";
                    }
                });
            });

            $('.js-btn-save-draft').click(function () {
                if (autoSaveTimeout !== null) {
                    clearTimeout(autoSaveTimeout);
                }
                autoSave();
            });

            $('.js-btn-preview').click(function () {
                editor.save();
                modal.ajax('{!!route('ajax.modal.wiki.create.preview', ['page' => $page->id])!!}', {
                    ajax: {
                        type: 'post',
                        data: $('#editor').closest('form').serialize()
                    },
                    size: 'lg'
                });
            });

            $('.js-btn-cancel').click(function () {
               modal.ajax('{!!route('ajax.modal.wiki.create.cancel', ['page' => $page->id])!!}');
            });
        })(jQuery);
    </script>
@append

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h1>@lang('wiki::page/create.title')</h1>
        </div>
        <div class="col-sm-6 text-right valign-bottom">
            <p>
                @lang('wiki::page/create.form.msg.saved-draft.content', ['time' => '<time datetime="' . $userDraft->created_at->toATOMString(). '"></time>'])
            </p>

            <div class="btn-group btn-group-sm hidden-xs">
                <a href="#" class="btn btn-primary js-btn-save">
                    <i class="icon-io-floppy-disk"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/create.form.btn.save.content')</span>
                </a>

                <a href="#" class="btn btn-default js-btn-save-draft">
                    <i class="icon-io-floppy-disk"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/create.form.btn.save-draft.content')</span>
                </a>

                <a href="#" class="btn btn-default js-btn-preview">
                    <i class="icon-io-file-text"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/create.form.btn.preview.content')</span>
                </a>

                <a href="#" class="btn btn-danger js-btn-cancel">
                    <i class="icon-io-bin2"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/create.form.btn.cancel.content')</span>
                </a>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            @if($draftExists)
                @include('bootstrap::alert/alert', [
                        'type'        => 'info',
                        'message'     => trans('wiki::page/create.form.msg.draft-exists.content'),
                        'dismissible' => true,
                    ])
            @endif

            {!!app('form')->open(['class' => 'form-horizontal'])!!}
            {!!app('form')->hidden('page_id', $page->id)!!}

            @include('bootstrap::form/group-text', [
                'label'     => 'wiki::page/create.form.field.title.label',
                'name'      => 'title',
                'labelSize' => 2,
                'value'     => $userDraft->title,
            ])

            <div class="form-group">
                <div class="col-sm-12">
                    {!!app('form')->textarea('content', $userDraft->content, [
                        'id'    => 'editor',
                        'class' => 'form-control markdown',
                        'rows'  => 20,
                    ])!!}
                </div>
            </div>
            {!!app('form')->close()!!}
        </div>
    </div>
@overwrite