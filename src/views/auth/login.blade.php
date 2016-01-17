@extends('wiki::layout')

@section('content')
    {!!app('form')->open(['class' => 'form-horizontal'])!!}

    @if($errors->has('form'))
        <i class="alert alert-danger">
            {!!$errors->first('form')!!}
        </i>
    @endif

    @include('bootstrap::form/group-text', [
        'label' => 'wiki::auth/login.form.field.username.label',
        'name'  => 'username',
        'index' => 1,
    ])

    @include('bootstrap::form/group-password', [
        'label' => 'wiki::auth/login.form.field.password.label',
        'name'  => 'password',
        'index' => 2,
    ])

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">

            {!!app('form')->submit(trans('wiki::auth/login.btn.login.content'), [
                'class'      => 'btn btn-primary',
                'data-index' => 3
            ])!!}

        </div>
    </div>

    {!!app('form')->close()!!}
@stop