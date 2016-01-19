@extends('wiki::layout')

@section('content')
    <form method="post" class="form-horizontal">
        {!! csrf_field() !!}

        @if($errors->has('form'))
            <p class="alert alert-danger">
                {!!$errors->first('form')!!}
            </p>
        @endif

        {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupText('username', null, [
                           'label' => trans('wiki::auth/login.form.field.username.label'),
                           'index' => 1,
                       ]) !!}

        {!! app(\ViKon\Bootstrap\FormBuilder::class)->groupPassword('password', [
                           'label' => trans('wiki::auth/login.form.field.password.label'),
                           'index' => 2,
                       ]) !!}

        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">

                <button type="submit" class="btn btn-primary" data-index="3">
                    @lang('wiki::auth/login.btn.login.content')
                </button>

            </div>
        </div>
    </form>
@stop