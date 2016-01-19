@extends('wiki::layout')


@section('scripts')
    <script type="text/javascript">
        (function ($) {
            $('.js-btn-page-history').click(function () {
                modal.ajax('{!!route('ajax.modal.wiki.history', ['page' => $page->id])!!}', {size: 'lg'});
            });

            $('.js-btn-page-link').click(function () {
                modal.ajax('{!!route('ajax.modal.wiki.link', ['page' => $page->id])!!}');
            });

            $('.js-btn-page-move').click(function () {
                modal.ajax('{!!route('ajax.modal.wiki.move', ['page' => $page->id])!!}');
            });

            $('.js-btn-page-destroy').click(function () {
                modal.ajax('{!!route('ajax.modal.wiki.destroy', ['page' => $page->id])!!}');
            });
        }(jQuery));
    </script>
@append


@section('content')
    <div class="row wiki-page-title">
        <div class="col-sm-6">
            <h1 id="{{$titleId}}" style="position: relative;">
                {{$page->title}}
                <div class="btn-group visible-xs" style="position: absolute; right: 0; top: 0;">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-io-menu2"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @if($editable)
                            <li>
                                <a href="{!!route('wiki.edit', ['url' => $page->url])!!}">
                                    <i class="icon-io-pencil"></i>
                                    &nbsp;@lang('wiki::page/show.btn.edit.content')
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="#" class="js-btn-page-history">
                                <i class="icon-io-history"></i>
                                &nbsp;@lang('wiki::page/show.btn.history.content')
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-btn-page-link">
                                <i class="icon-io-link"></i>
                                &nbsp;@lang('wiki::page/show.btn.link.content')
                            </a>
                        </li>

                        @if($movable)
                            <li>
                                <a href="#" class="js-btn-page-move">
                                    <i class="icon-io-folder"></i>
                                    &nbsp;@lang('wiki::page/show.btn.move.content')
                                </a>
                            </li>
                        @endif

                        @if($destroyable)
                            <li>
                                <a href="#" class="js-btn-page-destroy">
                                    <i class="icon-io-remove2"></i>
                                    &nbsp;@lang('wiki::page/show.btn.destroy.content')
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </h1>
        </div>
        <div class="col-sm-6 text-right valign-bottom">
            <p>
                @lang('wiki::page/show.header.last_modified', ['date' => $page->lastContent()->created_at->toATOMString()])
            </p>
            <div class="btn-group btn-group-sm hidden-xs">
                @if($editable)
                    <a href="{!!route('wiki.edit', ['url' => $page->url])!!}" class="btn btn-primary">
                        <i class="icon-io-pencil"></i>
                        <span class="hidden-sm">&nbsp;@lang('wiki::page/show.btn.edit.content')</span>
                    </a>
                @endif

                <a href="#" class="btn btn-default js-btn-page-history">
                    <i class="icon-io-history"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/show.btn.history.content')</span>
                </a>

                <a href="#" class="btn btn-default js-btn-page-link">
                    <i class="icon-io-link"></i>
                    <span class="hidden-sm">&nbsp;@lang('wiki::page/show.btn.link.content')</span>
                </a>

                @if($movable)
                    <a href="#" class="btn btn-default js-btn-page-move">
                        <i class="icon-io-folder"></i>
                        <span class="hidden-sm">&nbsp;@lang('wiki::page/show.btn.move.content')</span>
                    </a>
                @endif

                @if($destroyable)
                    <a href="#" class="btn btn-danger js-btn-page-destroy">
                        <i class="icon-io-bin2"></i>
                        <span class="hidden-sm">&nbsp;@lang('wiki::page/show.btn.destroy.content')</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <hr/>

    @if($message)
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! $message !!}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-9" style="margin-right: -1px; border-right: 1px solid #eee;">
            {!!$page->content!!}
        </div>
        <div class="col-sm-3">
            <div class="wiki-page-toc">
                <strong class="lead">@lang('wiki::page/show.toc.title')</strong>
                <div class="wiki-navbar-toc">
                    {!! app('html.wiki')->toc($page->toc, ['class' => 'nav']) !!}
                    <ul class="nav">
                        <li><a href="#top">@lang('wiki::page/show.toc.backToTop')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop