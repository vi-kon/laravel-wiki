@extends('utilities::html5-layout')


@section('title')
    @lang('site.title')
@stop


@section('head')
    <meta name="author" content="Kovács Vince">
    <meta name="description" content="@lang('site.description')">
@append


@section('styles')
    <link type="text/css" rel="stylesheet" media="all" href="{!!asset('vendor/bootstrap/bootstrap.min.css')!!}"/>
    <link type="text/css" rel="stylesheet" media="all" href="{!!asset('vendor/icomoon/style.css')!!}"/>
    <link type="text/css" rel="stylesheet" media="all" href="{!!asset('vendor/wiki/wiki.css')!!}"/>
@append

@section('scripts-head')
    <script type="text/javascript" src="{!!asset('vendor/jquery-2.1.3.min.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('vendor/jquery.timeago.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('vendor/bootstrap/bootstrap.min.js')!!}"></script>
@append


@section('scripts')
    <script type="text/javascript" src="{!!asset('vendor/wiki/wiki.js')!!}"></script>

    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                if ($.fn.timeago) {
                    $.timeago.settings.strings = {
                        prefixAgo    : '@lang('wiki::base.js.jquery-timeago.prefixAgo')',
                        prefixFromNow: '@lang('wiki::base.js.jquery-timeago.prefixFromNow')',
                        suffixAgo    : '@lang('wiki::base.js.jquery-timeago.suffixAgo')',
                        suffixFromNow: '@lang('wiki::base.js.jquery-timeago.suffixFromNow')',
                        seconds      : '@lang('wiki::base.js.jquery-timeago.seconds')',
                        minute       : '@lang('wiki::base.js.jquery-timeago.minute')',
                        minutes      : '@lang('wiki::base.js.jquery-timeago.minutes')',
                        hour         : '@lang('wiki::base.js.jquery-timeago.hour')',
                        hours        : '@lang('wiki::base.js.jquery-timeago.hours')',
                        day          : '@lang('wiki::base.js.jquery-timeago.day')',
                        days         : '@lang('wiki::base.js.jquery-timeago.days')',
                        month        : '@lang('wiki::base.js.jquery-timeago.month')',
                        months       : '@lang('wiki::base.js.jquery-timeago.months')',
                        year         : '@lang('wiki::base.js.jquery-timeago.year')',
                        years        : '@lang('wiki::base.js.jquery-timeago.years')'
                    };

                    $('time').timeago();
                }

                $('.js-btn-login').click(function () {
                    modal.ajax('{!!route('ajax.modal.auth.login')!!}', {ajax: {type: 'get'}});
                });

                $('.js-btn-settings').click(function () {
                    modal.ajax('{!!route('ajax.modal.user.settings')!!}', {ajax: {type: 'get'}});
                });
            });
        }(jQuery));
    </script>
@append


@section('body')
    <div id="top" class="container">
        <header class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="wiki-page-header">
                        <a href="{!!route('home')!!}">{!!config_db('wiki::title')!!}</a>
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <ul>
                        @if(Auth::check())

                            <li>
                                {!!$user->username!!}
                            </li>

                            <li>
                                <a href="#" class="js-btn-settings">@lang('wiki::base.header.btn.settings.content')</a>
                            </li>

                            @if(user_has_role('admin.index'))
                                <li>
                                    <a href="{!!route('admin.index')!!}">@lang('wiki::base.header.btn.admin.content')</a>
                                </li>
                            @endif

                            <li>
                                <a href="{!!route('auth.logout')!!}">@lang('wiki::base.header.btn.logout.content')</a>
                            </li>

                        @else
                            <li>
                                <a href="#" class="js-btn-login">@lang('wiki::base.header.btn.login.content')</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-sm-6 text-right search-form valign-bottom">

                    {!!app('form')->open(['method' => 'get', 'class' => 'form-inline', 'role' => 'search'])!!}

                    <div class="form-group">
                        <div class="input-group">
                            {!!app('form')->text('search', null, ['class' => 'form-control input-sm'])!!}
                            <div class="input-group-btn">
                                <input class="btn btn-sm btn-primary" type="submit" value="Search">
                            </div>
                        </div>
                    </div>

                    {!!app('form')->close()!!}

                </div>

            </div>
        </header>

        {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#">Home</a></li>--}}
        {{--<li><a href="#">Library</a></li>--}}
        {{--<li class="active">Data</li>--}}
        {{--</ol>--}}

        <div class="content">
            @yield('content')
        </div>

        <footer class="footer text-center">
            <hr/>
            @lang('wiki::base.footer.author', ['name'=>'Kovács Vince'])
        </footer>
    </div>

    <div id="modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
@stop