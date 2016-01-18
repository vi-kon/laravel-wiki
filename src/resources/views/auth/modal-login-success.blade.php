@extends('vi-kon.bootstrap::modal.modal')

<?php $onlyContent = true ?>


@section('title')
    <i class="icon-io-key"></i>
    &nbsp;
    @lang('wiki::auth/login.modal.login.title')
@overwrite


@section('body')
    <div class="alert alert-success">
        @lang('wiki::auth/login.modal.login.form.alert.success.content')
    </div>
@overwrite

@section('append')
    <script type="text/javascript">
        (function ($) {
            @if($url === null)
            window.location.reload();
            @elseif(starts_with($url, '__ajax'))
            $('#modal').find('.modal-content').load("{{$url}}", null, function () {
                $('#modal').trigger('reload.bs.modal');
            });
            @else
                    window.location.href = '{{$url}}';
            @endif
        })(jQuery);
    </script>
@append
