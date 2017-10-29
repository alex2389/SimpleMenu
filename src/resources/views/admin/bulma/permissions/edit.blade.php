@extends("SimpleMenu::admin.$css_fw.shared")
@section('title'){{ trans('SimpleMenu::messages.app_edit') }} "{{ $permission->name }}"@endsection

@section('sub')
    <div class="level">
        <div class="level-left">
            <h3 class="title">
                <a href="{{ url()->previous() }}">{{ trans('SimpleMenu::messages.go_back') }}</a>
            </h3>
        </div>
        <div class="level-right">
            <a href="{{ route($crud_prefix.'.permissions.create') }}"
                class="button is-success">
                {{ trans('SimpleMenu::messages.app_add_new') }}
            </a>
        </div>
    </div>

    {{ Form::model($permission, ['method' => 'PUT', 'route' => [$crud_prefix.'.permissions.update', $permission->id]]) }}

        {{-- name --}}
        <div class="field">
            {{ Form::label('name', trans('SimpleMenu::messages.name'), ['class' => 'label']) }}
        </div>
        <div class="field has-addons">
            <div class="control is-expanded">
                {{ Form::text('name', $permission->name, ['class' => 'input']) }}
                @if($errors->has('name'))
                    <p class="help is-danger">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="control">
                {{ Form::submit(trans('SimpleMenu::messages.app_update'), ['class' => 'button is-warning']) }}
            </div>
        </div>

    {{ Form::close() }}
@endsection
