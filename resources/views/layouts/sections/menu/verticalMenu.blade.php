@php
$configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["height"=>20])
      </span>
      <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  @endif


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)
      @php
        if (is_array($menu)) $menu = (object) $menu;
        $activeClass = '';
        $currentRouteName = Route::currentRouteName();
        $userRole = auth()->user()->role ?? null;
        // DEBUG: Uncomment untuk cek currentRouteName dan slug
        // echo '<!-- currentRouteName: ' . $currentRouteName . ' -->';
        // if (isset($menu->submenu)) { foreach ($menu->submenu as $sm) echo '<!-- submenu slug: ' . ($sm->slug ?? '') . ' -->'; }
        // Cek menu utama
        if (isset($menu->slug) && $currentRouteName === $menu->slug) {
          $activeClass = 'active';
        }
        // Cek submenu dan sub-submenu
        elseif (isset($menu->submenu)) {
          foreach ($menu->submenu as $submenu) {
            if (is_array($submenu)) $submenu = (object) $submenu;
            if (isset($submenu->slug) && $currentRouteName === $submenu->slug) {
              $activeClass = 'active open';
              break;
            }
            // Cek sub-submenu
            if (isset($submenu->submenu)) {
              foreach ($submenu->submenu as $subsubmenu) {
                if (is_array($subsubmenu)) $subsubmenu = (object) $subsubmenu;
                if (isset($subsubmenu->slug) && $currentRouteName === $subsubmenu->slug) {
                  $activeClass = 'active open';
                  break 2;
                }
              }
            }
          }
          // Tambahan: jika menu Data Master, aktifkan jika currentRouteName adalah salah satu slug submenu-nya
          if (isset($menu->name) && $menu->name === 'Data Master') {
            $dataMasterSlugs = collect($menu->submenu)->pluck('slug')->toArray();
            if (in_array($currentRouteName, $dataMasterSlugs)) {
              $activeClass = 'active open';
            }
          }
          // Tambahan: jika menu Account, aktifkan jika currentRouteName adalah salah satu slug submenu-nya
          if (isset($menu->name) && $menu->name === 'Account') {
            $accountSlugs = collect($menu->submenu)->pluck('slug')->toArray();
            if (in_array($currentRouteName, $accountSlugs)) {
              $activeClass = 'active open';
            }
          }
        }
      @endphp
      @if(!($menu->name === 'Pengumuman' && $userRole === 'guru'))
      <li class="menu-item{{ $activeClass ? ' ' . $activeClass : '' }}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="menu-link{{ isset($menu->submenu) ? ' menu-toggle' : '' }}{{ $activeClass ? ' router-link-active router-link-exact-active' : '' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
          @isset($menu->badge)
          <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
          @endisset
        </a>
        @isset($menu->submenu)
        @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
        @endisset
      </li>
      @endif
    @endforeach
  </ul>

</aside>
