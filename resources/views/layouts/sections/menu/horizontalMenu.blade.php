@php
$configData = Helper::appClasses();
@endphp
<!-- Horizontal Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
  <div class="{{$containerNav}} d-flex h-100">
    <ul class="menu-inner">
      @foreach ($menuData[1]->menu as $menu)

      {{-- Filter menu berdasarkan role --}}
      @php
      $showMenu = true;
      $userRole = auth()->user()->role ?? 'guest';
      
      // Kondisi untuk membatasi menu berdasarkan role
      if ($userRole === 'guru') {
          // Guru hanya boleh melihat menu tertentu
          $allowedMenus = ['Dashboard', 'History', 'Input Nilai', 'Account'];
          if (!in_array($menu->name, $allowedMenus)) {
              $showMenu = false;
          }
      } elseif ($userRole === 'siswa') {
          // Siswa hanya boleh melihat menu tertentu
          $allowedMenus = ['Dashboard', 'Histori', 'Lihat Nilai', 'Account'];
          if (!in_array($menu->name, $allowedMenus)) {
              $showMenu = false;
          }
      } elseif ($userRole === 'admin') {
          // Admin bisa melihat semua menu
          $showMenu = true;
      } else {
          // Guest atau role lain tidak boleh melihat menu
          $showMenu = false;
      }
      @endphp

      @if($showMenu)
      {{-- active menu method --}}
      @php
        $activeClass = null;
        $currentRouteName =  Route::currentRouteName();

        if ($currentRouteName === $menu->slug) {
            $activeClass = 'active';
        }
        elseif (isset($menu->submenu)) {
          if (gettype($menu->slug) === 'array') {
            foreach($menu->slug as $slug){
              if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                $activeClass = 'active';
              }
            }
          }
          else{
            if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
              $activeClass = 'active';
            }
          }

        }
      @endphp

      {{-- main menu --}}
      <li class="menu-item {{$activeClass}}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        </a>

        {{-- submenu --}}
        @isset($menu->submenu)
          @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
        @endisset
      </li>
      @endif
      @endforeach
    </ul>
  </div>
</aside>
<!--/ Horizontal Menu -->
