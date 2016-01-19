@extends('wiki::layout')


@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>@lang('wiki::page/not-exists.title')</h1>
        </div>
        <div class="col-md-6 text-right valign-bottom">
            <div class="btn-group btn-group-sm">
                @if($creatable)
                    <a href="{!!route('wiki.create', ['url' => $url])!!}" class="btn btn-primary">
                        <i class="icon-io-plus"></i>
                        &nbsp;
                        @lang('wiki::page/not-exists.btn.create.content')
                    </a>
                @endif
            </div>
        </div>
    </div>
    <hr/>
    <p>@lang('wiki::page/not-exists.content')</p>
@stop