<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleBasedMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role;
            
            // Set menu berdasarkan role
            $menu = $this->getMenuByRole($role);
            
            // Share menu ke semua view
            view()->share('roleBasedMenu', $menu);
            view()->share('currentUserRole', $role);
        }

        return $next($request);
    }

    private function getMenuByRole($role)
    {
        $baseMenu = [
            [
                "name" => "Beranda",
                "icon" => "menu-icon tf-icons ti ti-smart-home",
                "url" => "/",
                "slug" => "dashboard-analytics"
            ]
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
                        "slug" => "profile-account"
                    ],
                    [
                        "url" => "profile-security",
                        "name" => "Keamanan",
                        "slug" => "profile-security"
                    ],
                    [
                        "url" => "logout",
                        "name" => "Keluar",
                        "slug" => "logout"
                    ]
                ]
            ]
        ];

        switch ($role) {
            case 'admin':
                return array_merge($baseMenu, [
                    [
                        "name" => "Data Master",
                        "icon" => "menu-icon tf-icons ti ti-database",
                        "slug" => "data-master",
                        "submenu" => [
                            [
                                "url" => "data-master/guru",
                                "name" => "Data Guru",
                                "slug" => "data-master-guru"
                            ],
                            [
                                "url" => "data-master/siswa",
                                "name" => "Data Siswa",
                                "slug" => "data-master-siswa"
                            ],
                            [
                                "url" => "data-master/kelas",
                                "name" => "Data Kelas",
                                "slug" => "data-master-kelas"
                            ],
                            [
                                "url" => "data-master/mata-pelajaran",
                                "name" => "Data Mata Pelajaran",
                                "slug" => "data-master-mata-pelajaran"
                            ]
                        ]
                    ],
                    [
                        "name" => "Pengguna",
                        "icon" => "menu-icon tf-icons ti ti-users",
                        "url" => "users",
                        "slug" => "users"
                    ]
                ], $accountMenu);

            case 'guru':
                return array_merge($baseMenu, [
                    [
                        "name" => "Beranda Guru",
                        "icon" => "menu-icon tf-icons ti ti-smart-home",
                        "url" => "/",
                        "slug" => "dashboard-analytics"
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
                        "name" => "Pengumuman",
                        "icon" => "menu-icon tf-icons ti ti-megaphone",
                        "url" => "pengumuman",
                        "slug" => "pengumuman"
                    ]
                ], $accountMenu);

            case 'siswa':
                return array_merge($baseMenu, [
                    [
                        "name" => "Beranda",
                        "icon" => "menu-icon tf-icons ti ti-smart-home",
                        "url" => "/",
                        "slug" => "dashboard-analytics"
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
                    ]
                ], $accountMenu);

            default:
                return $baseMenu;
        }
    }
} 