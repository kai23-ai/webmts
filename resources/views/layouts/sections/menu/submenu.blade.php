<ul class="menu-sub">
  @if (isset($menu))
    @foreach ($menu as $submenu)
      @php
        if (is_array($submenu)) $submenu = (object) $submenu;
        $activeClass = '';
        $currentRouteName = Route::currentRouteName();
        if (isset($submenu->slug) && $currentRouteName === $submenu->slug) {
          $activeClass = 'active';
        }
        // Jika parent menu Account, dan currentRouteName cocok dengan salah satu slug submenu, tetap beri class active
        if (isset($submenu->slug) && in_array($currentRouteName, [$submenu->slug])) {
          $activeClass = 'active';
        }
        // Cek sub-submenu
        elseif (isset($submenu->submenu)) {
          foreach ($submenu->submenu as $subsubmenu) {
            if (is_array($subsubmenu)) $subsubmenu = (object) $subsubmenu;
            if (isset($subsubmenu->slug) && $currentRouteName === $subsubmenu->slug) {
              $activeClass = 'active open';
              break;
            }
          }
        }
      @endphp
      <li class="menu-item{{ $activeClass ? ' ' . $activeClass : '' }}">
        <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}" class="menu-link{{ isset($submenu->submenu) ? ' menu-toggle' : '' }}{{ $activeClass ? ' router-link-active router-link-exact-active' : '' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
          @if (isset($submenu->icon))
          <i class="{{ $submenu->icon }}"></i>
          @endif
          <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
          @isset($submenu->badge)
            <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
          @endisset
        </a>
        @if (isset($submenu->submenu))
          @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
        @endif
      </li>
    @endforeach
  @endif
</ul>
