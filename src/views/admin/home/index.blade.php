@extends('wiki::layout')


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1>@lang('wiki::admin/home/index.header.title')</h1>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="list-group">

                @if(app('auth.role.user')->hasRole('admin.user.index'))
                    <a href="{!!route('admin.user.index')!!}" class="list-group-item">
                        <h4 class="list-group-item-heading">
                            <i class="icon-io-users"></i>&nbsp;
                            @lang('wiki::admin/home/index.menu.user-manager.title')
                        </h4>

                        <p class="list-group-item-text text-justify">
                            @lang('wiki::admin/home/index.menu.user-manager.description')
                        </p>
                    </a>
                @endif

                <a href="{!!route('admin.access-control.index')!!}" class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <i class="icon-io-key2"></i>&nbsp;
                        @lang('wiki::admin/home/index.menu.access-control.title')
                    </h4>

                    <p class="list-group-item-text text-justify">
                        @lang('wiki::admin/home/index.menu.access-control.description')
                    </p>
                </a>


                <a href="{!!route('admin.extension-manager.index')!!}" class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <i class="icon-io-drawer"></i>&nbsp;
                        @lang('wiki::admin/home/index.menu.extension-manager.title')
                    </h4>

                    <p class="list-group-item-text text-justify">
                        @lang('wiki::admin/home/index.menu.extension-manager.description')
                    </p>
                </a>


                <a href="{!!route('admin.settings.index')!!}" class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <i class="icon-io-cog"></i>&nbsp;
                        @lang('wiki::admin/home/index.menu.settings.title')
                    </h4>

                    <p class="list-group-item-text text-justify">
                        @lang('wiki::admin/home/index.menu.settings.description')
                    </p>
                </a>
            </div>
        </div>
    </div>
@append