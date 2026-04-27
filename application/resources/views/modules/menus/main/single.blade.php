@if(isset($menu['title']) && $menu['title'] != '' && $menu['visible'])
<li data-menu-wrapper-id="{{ $menu['id'] }}" class="sidenav-menu-item menu-with-tooltip" title="{{ $menu['title'] }}" id="{{ $menu['id'] }}">
    <a class="waves-effect waves-dark {{ $menu['class'] }}" href="{{ $menu['href'] }}" aria-expanded="false" 
        @include('modules.menus.misc.data-attributes') target="{{ $menu['target'] }}">
        <i class="{{ $menu['icon'] }}"></i>
        <span class="hide-menu">{{ $menu['title'] }}</span>
    </a>
</li>
@endif