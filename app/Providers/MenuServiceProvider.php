<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    view()->composer('*', function ($view) {
        if (\Auth::check()) {
            $user = \Auth::user();
            $role = $user->role;
            $menuData = $this->getMenuByRole($role);
            $view->with('menuData', $menuData);

            // Share notifPengumuman ke semua view
            $notifPengumuman = \App\Models\Announcement::where('status', 'aktif')
                ->where(function($q) use ($role) {
                    $q->where('role', $role)->orWhere('role', 'semua');
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $notifCount = $notifPengumuman->count();
            $view->with('notifPengumuman', $notifPengumuman);
            $view->with('notifCount', $notifCount);
        } else {
            $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
            $verticalMenuData = json_decode($verticalMenuJson);
            $horizontalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
            $horizontalMenuData = json_decode($horizontalMenuJson);
            $view->with('menuData', [$verticalMenuData, $horizontalMenuData]);
            $view->with('notifPengumuman', collect());
            $view->with('notifCount', 0);
        }
    });
  }

  private function getMenuByRole($role)
  {
    $baseMenu = [
      "menu" => [
        [
          "name" => "Beranda",
          "icon" => "menu-icon tf-icons ti ti-smart-home",
          "url" => "/",
          "slug" => "dashboard-analytics"
        ]
      ]
    ];

    $routeSlugMap = [
      // Data Master
      'app/guru/list' => 'app-guru-list',
      'app/kelas/list' => 'app-kelas-list',
      'app/kelas-siswa/list' => 'app-kelas-siswa-list',
      'app/mata-pelajaran/list' => 'app-mata-pelajaran-list',
      'app/muatan-lokal/list' => 'app-muatan-lokal-list',
      'app/pengumuman/list' => 'app-pengumuman-list',
      'app/semester/list' => 'app-semester-list',
      'app/siswa/list' => 'app-siswa-list',
      'app/tahun-ajaran/list' => 'app-tahun-ajaran-list',
      'app/users/list' => 'app-user-list',
      'app/wali-kelas/list' => 'app-wali-kelas-list',
      // Admin Data Master (old url)
      'data-master/guru' => 'data-master-guru',
      'data-master/kelas' => 'data-master-kelas',
      'data-master/kelas-siswa' => 'data-master-kelas-siswa',
      'data-master/mata-pelajaran' => 'data-master-mata-pelajaran',
      'data-master/muatan-lokal' => 'data-master-muatan-lokal',
      'data-master/pengumuman' => 'data-master-pengumuman',
      'data-master/semester' => 'data-master-semester',
      'data-master/siswa' => 'data-master-siswa',
      'data-master/tahun-ajaran' => 'data-master-tahun-ajaran',
      'data-master/users' => 'data-master-users',
      'data-master/wali-kelas' => 'data-master-wali-kelas',
      // Account
      'profile-account' => 'profile-account',
      'profile-security' => 'profile-security',
      'logout' => 'logout',
      // Ranking
      'ranking' => 'ranking',
    ];

    $accountMenu = [
      [
        "name" => "Akun",
        "icon" => "menu-icon tf-icons ti ti-user",
        "slug" => "account",
        "submenu" => [
          [
            "url" => "profile-account",
            "name" => "Profil",
            "slug" => $routeSlugMap['profile-account'] ?? 'profile-account',
          ],
          [
            "url" => "profile-security",
            "name" => "Keamanan",
            "slug" => $routeSlugMap['profile-security'] ?? 'profile-security',
          ],
          [
            "url" => "logout",
            "name" => "Keluar",
            "slug" => $routeSlugMap['logout'] ?? 'logout',
          ]
        ]
      ]
    ];

    switch ($role) {
      case 'admin':
        \Log::info('MenuServiceProvider: case admin', ['role' => $role]);
        $adminMenu = array_merge([
          [
            "name" => "Beranda",
            "icon" => "menu-icon tf-icons ti ti-smart-home",
            "url" => "/",
            "slug" => "dashboard-analytics"
          ],
          [
            "name" => "Data Master",
            "icon" => "menu-icon tf-icons ti ti-database",
            "slug" => "data-master",
            "submenu" => [
              [
                "url" => "app/guru/list",
                "name" => "Guru",
                "slug" => $routeSlugMap['app/guru/list'] ?? 'app-guru-list',
              ],
              [
                "url" => "app/kelas/list",
                "name" => "Kelas",
                "slug" => $routeSlugMap['app/kelas/list'] ?? 'app-kelas-list',
              ],
              [
                "url" => "app/kelas-siswa/list",
                "name" => "Kelas Siswa",
                "slug" => $routeSlugMap['app/kelas-siswa/list'] ?? 'app-kelas-siswa-list',
              ],
              [
                "url" => "app/mata-pelajaran/list",
                "name" => "Mata Pelajaran",
                "slug" => $routeSlugMap['app/mata-pelajaran/list'] ?? 'app-mata-pelajaran-list',
              ],
              [
                "url" => "app/muatan-lokal/list",
                "name" => "Muatan Lokal",
                "slug" => $routeSlugMap['app/muatan-lokal/list'] ?? 'app-muatan-lokal-list',
              ],
              [
                "url" => "app/pengumuman/list",
                "name" => "Pengumuman",
                "slug" => $routeSlugMap['app/pengumuman/list'] ?? 'app-pengumuman-list',
              ],
              [
                "url" => "app/semester/list",
                "name" => "Semester",
                "slug" => $routeSlugMap['app/semester/list'] ?? 'app-semester-list',
              ],
              [
                "url" => "app/siswa/list",
                "name" => "Siswa",
                "slug" => $routeSlugMap['app/siswa/list'] ?? 'app-siswa-list',
              ],
              [
                "url" => "app/tahun-ajaran/list",
                "name" => "Tahun Ajaran",
                "slug" => $routeSlugMap['app/tahun-ajaran/list'] ?? 'app-tahun-ajaran-list',
              ],
              [
                "url" => "app/users/list",
                "name" => "Pengguna",
                "slug" => $routeSlugMap['app/users/list'] ?? 'app-user-list',
              ],
              [
                "url" => "app/wali-kelas/list",
                "name" => "Wali Kelas",
                "slug" => $routeSlugMap['app/wali-kelas/list'] ?? 'app-wali-kelas-list',
              ]
            ]
          ]
        ], $accountMenu);
        
        return [
          (object) ["menu" => $adminMenu],
          (object) ["menu" => $adminMenu] // Horizontal menu sama dengan vertical
        ];

      case 'guru':
        \Log::info('MenuServiceProvider: case guru', ['role' => $role]);
        $guruMenu = array_merge([
          [
            "name" => "Beranda Guru",
            "icon" => "menu-icon tf-icons ti ti-smart-home",
            "url" => "/dashboard/guru",
            "slug" => "dashboard-guru"
          ],
          [
            "name" => "Riwayat",
            "icon" => "menu-icon tf-icons ti ti-history",
            "url" => "history",
            "slug" => "history"
          ],
          [
            "name" => "Input Nilai",
            "icon" => "menu-icon tf-icons ti ti-edit",
            "url" => "input-nilai",
            "slug" => "input-nilai"
          ],
          [
            "name" => "Ranking Siswa",
            "icon" => "menu-icon tf-icons ti ti-trophy",
            "url" => "ranking",
            "slug" => $routeSlugMap['ranking'] ?? 'ranking',
          ],
          [
            "name" => "Pengumuman",
            "icon" => "menu-icon tf-icons ti ti-bell",
            "url" => "app/pengumuman/list",
            "slug" => $routeSlugMap['app/pengumuman/list'] ?? 'app-pengumuman-list',
          ]
        ], $accountMenu);
        
        return [
          (object) ["menu" => $guruMenu],
          (object) ["menu" => $guruMenu] // Horizontal menu sama dengan vertical
        ];

      case 'siswa':
        \Log::info('MenuServiceProvider: case siswa', ['role' => $role]);
        $siswaMenu = array_merge([
          [
            "name" => "Beranda Siswa",
            "icon" => "menu-icon tf-icons ti ti-smart-home",
            "url" => "/dashboard/siswa",
            "slug" => "dashboard-siswa"
          ],
          [
            "name" => "Histori",
            "icon" => "menu-icon tf-icons ti ti-history",
            "url" => "histori",
            "slug" => "histori"
          ],
          [
            "name" => "Lihat Nilai",
            "icon" => "menu-icon tf-icons ti ti-eye",
            "url" => "lihat-nilai",
            "slug" => "lihat-nilai"
          ],
          [
            "name" => "Ranking Kelas",
            "icon" => "menu-icon tf-icons ti ti-trophy",
            "url" => "ranking",
            "slug" => $routeSlugMap['ranking'] ?? 'ranking',
          ]
        ], $accountMenu);
        
        return [
          (object) ["menu" => $siswaMenu],
          (object) ["menu" => $siswaMenu] // Horizontal menu sama dengan vertical
        ];

      default:
        \Log::info('MenuServiceProvider: case default', ['role' => $role]);
        return [
          (object) $baseMenu,
          (object) $baseMenu
        ];
    }
  }
}
