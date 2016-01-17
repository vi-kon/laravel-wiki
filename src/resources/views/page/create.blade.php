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

            changed         = false;
            autoSaveTimeout = null;

            autoSave = function () {
                var btn = $('.js-btn-save-draft');

                btn.button('loading');
                autoSaveTimeout = null;
                editor.save();
                ajax.ajax('{!!route('ajax.wiki.create.store-draft', ['page' => $page->id])!!}', {
                    type            : 'post',
                    data            : $('#editor').closest('form').serialize(),
                    openModalOnError: false
                }).done(function () {
                    $('.draft-saved-at')
                            .html('@lang('wiki::page/create.form.alert.saved-draft.content', ['time' => '<time></time>'])')
                            .find('time').attr('datetime', new Date().toISOString()).timeago();
                }).fail(function () {
                    var time, draftSavedAt;

                    draftSavedAt = $('.draft-saved-at');
                    time         = draftSavedAt.find('time');
                    draftSavedAt
                            .html($('<div class="text-danger"/>')
                                    .html('@lang('wiki::page/create.form.alert.error-saving-draft.content', ['time' => '<time></time>'])'))
                            .find('time').attr('datetime', time.attr('datetime')).timeago();
                }).always(function () {
                    btn.button('reset');
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
            editor.on("change", function () {
                changed = true;
                if (autoSaveTimeout === null) {
                    autoSaveTimeout = setTimeout(autoSave, 1000);
                }
            });

            $('.js-btn-save').click(function () {
                var form = $('#editor').closest('form');

                editor.save();
                ajax.ajax('{!!route('ajax.wiki.create.store', ['page' => $page->id])!!}', {
                    type            : 'post',
                    data            : form.serialize(),
                    openModalOnError: false
                }).done(function () {
                    window.location.href = "{!!route('wiki.show', ['url' => $page->url])!!}";
                }).fail(function (jqXHR) {
                    var name;

                    if (jqXHR.status === 422) {
                        form.children('.error-block').remove();

                        for (name in jqXHR.responseJSON) {
                            if (jqXHR.responseJSON.hasOwnProperty(name)) {
                                if (name === 'form') {
                                    $('<div class="error-block"/>')
                                            .append($('<div class="alert alert-danger"/>')
                                                    .append($('<button type="button" class="close" data-dismiss="alert"/>')
                                                            .append($('<span aria-hidden="true"/>')
                                                                    .html('&times;'))
                                                            .append($('<span class="sr-only"/>')
                                                                    .html('Close')))
                                                    .append(jqXHR.responseJSON[name]))
                                            .prependTo(form);
                                }
                            }
                        }
                    } else {
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
            <p class="draft-saved-at">
                @lang('wiki::page/create.form.alert.saved-draft.content', ['time' => '<time datetime="' . $userDraft->created_at->toATOMString(). '"></time>'])
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
                    <i class="icon-io-eye"></i>
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
                        'message'     => trans('wiki::page/create.form.alert.draft-exists.content'),
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