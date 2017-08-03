<ul>
    @foreach ($items as $page)
        @include('SimpleMenu::menu.partials.r_params')

        <li>
            <a href="{{ SimpleMenu::urlRoute() }}" class="{{ SimpleMenu::urlRouteCheck() ? 'is-active' : '' }}">{{ $page->title }}</a>

            @if ($childs = $page->nests)
                @include('SimpleMenu::menu.partials.nested', ['items' => $childs])
            @endif
        </li>
    @endforeach
</ul>