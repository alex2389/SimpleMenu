@extends('SimpleMenu::admin.'.config('simpleMenu.framework').'.shared')
@section('title'){{ "Edit '$menu->name'" }}@endsection

@section('sub')
    <h3 class="title">
        <a href="{{ route($crud_prefix.'.menus.index') }}">Go Back</a>
    </h3>

    <menu-comp inline-template
        get-menu-pages="{{ route($crud_prefix.'.menus.getMenuPages',['id'=>$menu->id]) }}"
        del-page="{{ route($crud_prefix.'.menus.removePage',['id'=>$menu->id]) }}"
        del-child="{{ route($crud_prefix.'.menus.removeChild') }}"
        locale="{{ LaravelLocalization::getCurrentLocale() }}">
        <div>
            {{ Form::model($menu, ['method' => 'PUT', 'route' => [$crud_prefix.'.menus.update', $menu->id]]) }}

                {{-- name --}}
                <div class="field">
                    {{ Form::label('name', 'Name', ['class' => 'label']) }}
                </div>
                <div class="field has-addons">
                    <div class="control is-expanded">
                        {{ Form::text('name', $menu->name, ['class' => 'input']) }}
                    </div>
                    @if($errors->has('name'))
                        <p class="help is-danger">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                    <div class="control">
                        {{ Form::submit(trans('SimpleMenu::messages.app_update'), ['class' => 'button is-warning']) }}
                    </div>
                </div>

                <div class="columns">
                    {{-- pages --}}
                    <draggable v-model="pages"
                        class="column is-4 menu-list"
                        :class="{dragArea: isDragging}"
                        :options="{group:'pages', ghostClass: 'ghost'}"
                        :element="'ul'"
                        @change="updateList"
                        @start="dragStart"
                        @end="dragEnd">
                    <li v-for="item in pages" :key="item.id">
                        {{-- main --}}
                        <div class="notification is-info menu-item" :class="classObj(item)">
                            <span class="icon is-small"><i class="fa" :class="arrowObj(item)"></i></span>
                            <span>@{{ getTitle(item.title) }}</span>

                            {{-- ops --}}
                            <button type="button" v-if="checkFrom(item)" class="delete" @click="undoItem(item)" title="undo"></button>
                            <button type="button" v-else class="delete" @click.prevent="deletePage(item)" title="remove page"></button>
                        </div>

                        {{-- childs --}}
                        <menu-child :locale="locale"
                            :class="{dragArea: isDragging}"
                            :pages="pages"
                            :all-pages="allPages"
                            :del-child="delChild"
                            :childs="item.nests">
                        </menu-child>
                    </li>
                </draggable>

                {{-- all_pages --}}
                <draggable v-model="allPages"
                    class="column"
                    :element="'ul'"
                    :options="{group:{name:'pages', put:false}, chosenClass:'is-warning', sort: false}"
                    @start="dragStart"
                    @end="dragEnd">
                    <li v-for="item in allPages" :key="item.id" class="notification is-info menu-item">
                        <span class="icon is-small"><i class="fa fa-caret-right"></i></span>
                        <span>@{{ getTitle(item.title) }}</span>
                    </li>
                </draggable>
            </div>

            <input type="hidden" name="saveList" v-model="JSON.stringify(saveList)">
        {{ Form::close() }}
    </div>
</menu-comp>
@stop