<ul>
    @foreach ($PAGES as $one)
        @php
            $route = $menu->getRoute($one->route_name);
        @endphp
        
        <li>
            <a href="{{ $route }}" class="{{ request()->url() == $route ? 'is-active' : '' }}">{{ $one->title }}</a>
            
            @if (count($childs = $one->getImmediateDescendants()))
                <ul>
                    @include('menu._nested', ['items' => $childs])
                </ul>
            @endif
        </li>
    @endforeach
</ul>