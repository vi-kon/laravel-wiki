@extends('bootstrap::modal/modal-alert')


@section('title')
    <i class="icon-io-folder"></i>
    &nbsp;
    @lang('wiki::page/show.modal.move-success.title')
@overwrite


@section('type')
    alert-success
@overwrite


@section('message')
    @lang('wiki::page/show.modal.move-success.content', ['source' => $source, 'destination' => $page->url])
@overwrite

@section('append')
    <script type="text/javascript">
        history.replaceState(null, '{{$page->title}}', '{{route('wiki.show', ['url' => $page->url])}}');
    </script>
@append
