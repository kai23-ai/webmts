<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\NavbarFull;
use App\Http\Controllers\layouts\NavbarFullSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\Tabler;
use App\Http\Controllers\icons\FontAwesome;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\apps\GuruList;
use App\Http\Controllers\apps\KelasList;
use App\Http\Controllers\apps\TahunAjaranList;
use App\Http\Controllers\apps\MataPelajaranList;
use App\Http\Controllers\apps\SemesterList;
use App\Http\Controllers\apps\SiswaList;
use App\Http\Controllers\apps\WaliKelasList;
use App\Http\Controllers\apps\MuatanLokalList;
use App\Http\Controllers\apps\KelasSiswaList;
use App\Models\Guru;
use App\Models\Siswa;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InputNilaiController;

// Main Page Route dan SEMUA route aplikasi yang wajib login
Route::middleware(['auth'])->group(function () {
    // Main Page Route
    Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');
    Route::get('/dashboard/guru', function () {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role === 'guru') {
            return app(\App\Http\Controllers\dashboard\Guru::class)->index();
        }
        abort(403);
    })->name('dashboard-guru');
    
    Route::get('/dashboard/siswa', function () {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role === 'siswa') {
            return app(\App\Http\Controllers\dashboard\Siswa::class)->index();
        }
        abort(403);
    })->name('dashboard-siswa');
    
    Route::get('/history-siswa', function () {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role === 'siswa') {
            return app(\App\Http\Controllers\dashboard\Siswa::class)->history();
        }
        abort(403);
    })->name('history-siswa');
    
    Route::get('/history', function () {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role === 'guru') {
            return app(\App\Http\Controllers\dashboard\Guru::class)->history();
        }
        abort(403);
    })->name('history');
    
    // Input Nilai Routes (Guru only)
    Route::middleware(['auth'])->group(function () {
        Route::get('/input-nilai', [InputNilaiController::class, 'index'])->name('input-nilai');
        Route::post('/input-nilai/get-siswa', [InputNilaiController::class, 'getSiswaByMataPelajaran'])->name('input-nilai.get-siswa');
        Route::post('/input-nilai/store', [InputNilaiController::class, 'store'])->name('input-nilai.store');
        Route::post('/input-nilai/batch-store', [InputNilaiController::class, 'batchStore'])->name('input-nilai.batch-store');
        Route::post('/input-nilai/get-nilai', [InputNilaiController::class, 'getNilaiByMapel'])->name('input-nilai.get-nilai');
        Route::post('/input-nilai/get-mapel-status', [InputNilaiController::class, 'getMapelStatus'])->name('input-nilai.get-mapel-status');
    });
    // layout
    Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
    Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
    Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
    Route::get('/layouts/navbar-full', [NavbarFull::class, 'index'])->name('layouts-navbar-full');
    Route::get('/layouts/navbar-full-sidebar', [NavbarFullSidebar::class, 'index'])->name('layouts-navbar-full-sidebar');
    Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
    Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');
    // Front Pages
    Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
    Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
    Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
    Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
    Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
    Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');
    // apps
    Route::get('/app/email', [Email::class, 'index'])->name('app-email');
    Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
    Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
    Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
    Route::get('/app/ecommerce/dashboard', [EcommerceDashboard::class, 'index'])->name('app-ecommerce-dashboard');
    Route::get('/app/ecommerce/product/list', [EcommerceProductList::class, 'index'])->name('app-ecommerce-product-list');
    Route::get('/app/ecommerce/product/add', [EcommerceProductAdd::class, 'index'])->name('app-ecommerce-product-add');
    Route::get('/app/ecommerce/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
    Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
    Route::get('app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
    Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
    Route::get('app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
    Route::get('app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
    Route::get('app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
    Route::get('app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
    Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
    Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
    Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
    Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
    Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
    Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
    Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
    Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
    Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
    Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
    Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
    Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
    Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
    Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
    Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
    Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
    Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
    Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
    Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
    Route::post('/app/user/store', [UserList::class, 'store']);
    Route::post('/app/user/update', [UserList::class, 'update']);
    Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
    Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
    Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
    Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
    Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
    Route::get('/app/user/getbyid/{id}', [App\Http\Controllers\apps\UserList::class, 'getById']);
    Route::post('/app/user/delete', [App\Http\Controllers\apps\UserList::class, 'delete']);
    Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
    Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');
    Route::get('/app/guru/list', [GuruList::class, 'index'])->name('app-guru-list');
    Route::get('/app/guru/data', [GuruList::class, 'data']);
    Route::post('/app/guru/store', [GuruList::class, 'store']);
    Route::post('/app/guru/update', [GuruList::class, 'update']);
    Route::post('/app/guru/delete', [GuruList::class, 'destroy']);
    Route::get('/app/guru/getbynip/{nip}', [App\Http\Controllers\apps\GuruList::class, 'getByNip']);
    Route::post('/app/guru/updatebynip', [App\Http\Controllers\apps\GuruList::class, 'updateByNip']);
    Route::post('/app/guru/deletebynip', [App\Http\Controllers\apps\GuruList::class, 'deleteByNip']);

    // Kelas routes (mirroring Guru)
    Route::get('/app/kelas/list', [KelasList::class, 'index'])->name('app-kelas-list');
    Route::get('/app/kelas/data', [KelasList::class, 'data']);
    Route::post('/app/kelas/store', [KelasList::class, 'store']);
    Route::post('/app/kelas/update', [KelasList::class, 'update']);
    Route::post('/app/kelas/delete', [KelasList::class, 'destroy']);
    Route::get('/app/kelas/getbyid/{id}', [App\Http\Controllers\apps\KelasList::class, 'getById']);
    Route::post('/app/kelas/updatebyid', [App\Http\Controllers\apps\KelasList::class, 'updateById']);
    Route::post('/app/kelas/deletebyid', [App\Http\Controllers\apps\KelasList::class, 'deleteById']);

    // Tahun Ajaran routes (mirroring Guru/Kelas)
    Route::get('/app/tahun-ajaran/list', [TahunAjaranList::class, 'index'])->name('app-tahun-ajaran-list');
    Route::get('/app/tahun-ajaran/data', [TahunAjaranList::class, 'data']);
    Route::post('/app/tahun-ajaran/store', [TahunAjaranList::class, 'store']);
    Route::post('/app/tahun-ajaran/update', [TahunAjaranList::class, 'update']);
    Route::post('/app/tahun-ajaran/delete', [TahunAjaranList::class, 'destroy']);
    Route::get('/app/tahun-ajaran/getbyid/{id}', [App\Http\Controllers\apps\TahunAjaranList::class, 'getById']);
    Route::post('/app/tahun-ajaran/updatebyid', [App\Http\Controllers\apps\TahunAjaranList::class, 'updateById']);
    Route::post('/app/tahun-ajaran/deletebyid', [App\Http\Controllers\apps\TahunAjaranList::class, 'deleteById']);

    // Mata Pelajaran routes
    Route::get('/app/mata-pelajaran/list', [MataPelajaranList::class, 'index'])->name('app-mata-pelajaran-list');
    Route::post('/app/mata-pelajaran/store', [MataPelajaranList::class, 'store']);
    Route::post('/app/mata-pelajaran/update', [MataPelajaranList::class, 'update']);
    Route::post('/app/mata-pelajaran/delete', [MataPelajaranList::class, 'destroy']);
    Route::get('/app/mata-pelajaran/getbyid/{id}', [MataPelajaranList::class, 'getById']);
    Route::post('/app/mata-pelajaran/updatebyid', [MataPelajaranList::class, 'updateById']);
    Route::post('/app/mata-pelajaran/deletebyid', [MataPelajaranList::class, 'deleteById']);

    // Semester routes
    Route::get('/app/semester/list', [SemesterList::class, 'index'])->name('app-semester-list');
    Route::get('/app/semester/data', [SemesterList::class, 'data']);
    Route::post('/app/semester/store', [SemesterList::class, 'store']);
    Route::post('/app/semester/updatebyid', [SemesterList::class, 'updatebyid']);
    Route::get('/app/semester/getbyid/{id}', [SemesterList::class, 'getbyid']);
    Route::post('/app/semester/deletebyid', [SemesterList::class, 'deletebyid']);

    // Siswa List
    Route::get('app/siswa/list', [\App\Http\Controllers\apps\SiswaList::class, 'index'])->name('app-siswa-list');
    Route::get('app/siswa/data', [\App\Http\Controllers\apps\SiswaList::class, 'data']);
    Route::get('app/siswa/getbyid/{id}', [\App\Http\Controllers\apps\SiswaList::class, 'getbyid']);
    Route::post('app/siswa/store', [\App\Http\Controllers\apps\SiswaList::class, 'store']);
    Route::post('app/siswa/updatebyid', [\App\Http\Controllers\apps\SiswaList::class, 'updatebyid']);
    Route::post('app/siswa/deletebyid', [\App\Http\Controllers\apps\SiswaList::class, 'deletebyid']);

    // Wali Kelas routes
    Route::get('/app/wali-kelas/list', [WaliKelasList::class, 'index'])->name('app-wali-kelas-list');
    Route::get('/app/wali-kelas/data', [WaliKelasList::class, 'data']);
    Route::post('/app/wali-kelas/store', [WaliKelasList::class, 'store']);
    Route::post('/app/wali-kelas/updatebyid', [WaliKelasList::class, 'updatebyid']);
    Route::post('/app/wali-kelas/deletebyid', [WaliKelasList::class, 'deletebyid']);
    Route::get('/app/wali-kelas/getbyid/{id}', [WaliKelasList::class, 'getbyid']);

    // Muatan Lokal routes
    Route::get('/app/muatan-lokal/list', [\App\Http\Controllers\apps\MuatanLokalList::class, 'index'])->name('app-muatan-lokal-list');
    Route::post('/app/muatan-lokal/store', [\App\Http\Controllers\apps\MuatanLokalList::class, 'store']);
    Route::post('/app/muatan-lokal/update', [\App\Http\Controllers\apps\MuatanLokalList::class, 'update']);
    Route::post('/app/muatan-lokal/delete', [\App\Http\Controllers\apps\MuatanLokalList::class, 'destroy']);
    Route::get('/app/muatan-lokal/getbyid/{id}', [\App\Http\Controllers\apps\MuatanLokalList::class, 'getById']);
    Route::post('/app/muatan-lokal/updatebyid', [\App\Http\Controllers\apps\MuatanLokalList::class, 'updateById']);
    Route::post('/app/muatan-lokal/deletebyid', [\App\Http\Controllers\apps\MuatanLokalList::class, 'deleteById']);

    // Kelas Siswa routes
    Route::get('/app/kelas-siswa/list', function() {
        return view('content.apps.app-kelas-siswa-list');
    })->name('app-kelas-siswa-list');
    Route::get('/app/kelas-siswa/data', [\App\Http\Controllers\apps\KelasSiswaList::class, 'list']);
    Route::prefix('app/kelas-siswa')->group(function() {
        Route::post('/store', [\App\Http\Controllers\apps\KelasSiswaList::class, 'store']);
        Route::post('/update', [\App\Http\Controllers\apps\KelasSiswaList::class, 'update']);
        Route::post('/delete', [\App\Http\Controllers\apps\KelasSiswaList::class, 'delete']);
        Route::get('/getbyid/{id}', [\App\Http\Controllers\apps\KelasSiswaList::class, 'getById']);
    });

    // pages
    Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
    Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
    Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
    Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
    // Route untuk profile-security
    Route::get('/profile-security', function () {
        return view('pages.profile-security');
    })->name('profile-security');
    Route::get('/pages/profile-security', [UserViewSecurity::class, 'index'])->name('pages-profile-security');
    Route::post('/profile-security/password', [\App\Http\Controllers\pages\AccountSettingsSecurity::class, 'changePassword']);
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
    Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
    Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
    Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
    Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');

    // wizard example
    Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
    Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
    Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

    // modal
    Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

    // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
    Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
    Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
    Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
    Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
    Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

    // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
    Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
    Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
    Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
    Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
    Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
    Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
    Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
    Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
    Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

    // icons
    Route::get('/icons/tabler', [Tabler::class, 'index'])->name('icons-tabler');
    Route::get('/icons/font-awesome', [FontAwesome::class, 'index'])->name('icons-font-awesome');

    // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
    Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
    Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
    Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
    Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
    Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
    Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
    Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
    Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

    // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
    Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

    // form wizards
    Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
    Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
    Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

    // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
    Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
    Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
    Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

    // charts
    Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
    Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

    // maps
    Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

    // laravel example
    Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
    Route::resource('/user-list', UserManagement::class);

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/auth/login');
    })->name('logout');

    Route::get('/app/guru/list-all', function() {
        $data = \App\Models\Guru::select('id', 'nama')->get()->map(function($guru) {
            return [
                'id' => (string) $guru->id,
                'text' => $guru->nama
            ];
        });
        return response()->json($data);
    });

    Route::get('/app/siswa/list-all', function() {
        $data = \App\Models\Siswa::select('id', 'nama')->get()->map(function($siswa) {
            return [
                'id' => (string) $siswa->id,
                'text' => $siswa->nama
            ];
        });
        return response()->json($data);
    });

    Route::get('/export-legger', [App\Http\Controllers\dashboard\Guru::class, 'exportLegger'])->name('export-legger');
});
// Route yang TIDAK WAJIB LOGIN (auth)
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/login', [Login::class, 'index'])->name('auth-login');
Route::post('/auth/login', [Login::class, 'authenticate'])->name('auth.login');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

// Tambahkan alias agar route('login') berfungsi
Route::get('/login', function() {
    return redirect()->route('auth-login');
})->name('login');

// Admin Dashboard Route
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (auth()->user() && auth()->user()->role === 'admin') {
            return view('pages.admin-dashboard');
        }
        abort(403);
    })->name('admin.dashboard');
});

// Pengumuman (hanya admin di menu, data bisa diakses user login)
Route::get('app/pengumuman/list', [AnnouncementController::class, 'index'])->name('app-pengumuman-list');
Route::get('app/pengumuman/data', [AnnouncementController::class, 'data'])->name('pengumuman.data');
Route::post('app/pengumuman/{id}/status', [AnnouncementController::class, 'updateStatus'])->name('pengumuman.updateStatus');
Route::post('app/pengumuman/update/{id}', [AnnouncementController::class, 'update'])->name('pengumuman.update');
Route::get('app/pengumuman/{id}', [AnnouncementController::class, 'show'])->name('pengumuman.show');
Route::middleware(['auth'])->get('notifications/pengumuman', [AnnouncementController::class, 'notifications'])->name('pengumuman.notifications');

Route::get('/profile-account', function () {
    return view('pages.profile-account');
})->middleware('auth')->name('profile-account');

Route::get('/profile-security', function () {
    return view('pages.profile-security');
})->middleware('auth')->name('profile-security');

Route::post('/profile-account/update', [UserProfile::class, 'update'])->name('profile-account.update');

// Route untuk menu berdasarkan role
Route::middleware(['auth'])->group(function () {
    // Route untuk Admin - Data Master
    Route::get('/data-master/guru', function () {
        if (auth()->user()->role === 'admin') {
            return view('content.apps.app-guru-list');
        }
        abort(403);
    })->name('data-master-guru');
    
    Route::get('/data-master/siswa', function () {
        if (auth()->user()->role === 'admin') {
            return view('content.apps.app-siswa-list');
        }
        abort(403);
    })->name('data-master-siswa');
    
    Route::get('/data-master/kelas', function () {
        if (auth()->user()->role === 'admin') {
            return view('content.apps.app-kelas-list');
        }
        abort(403);
    })->name('data-master-kelas');
    
    Route::get('/data-master/mata-pelajaran', function () {
        if (auth()->user()->role === 'admin') {
            return view('content.apps.app-mata-pelajaran-list');
        }
        abort(403);
    })->name('data-master-mata-pelajaran');
    
    // Route untuk Guru
    Route::get('/history', [App\Http\Controllers\dashboard\Guru::class, 'history'])->name('history');
    

    
    // Route untuk Siswa
    Route::get('/histori', function () {
        if (auth()->user()->role === 'siswa') {
            return view('content.apps.app-histori-siswa');
        }
        abort(403);
    })->name('histori');
    
    Route::get('/lihat-nilai', function () {
        if (auth()->user()->role === 'siswa') {
            return view('content.apps.app-lihat-nilai');
        }
        abort(403);
    })->name('lihat-nilai');
    
    // Route untuk Account (semua role)
    Route::get('/profile-security', function () {
        return view('pages.profile-security');
    })->name('profile-security');
    
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/auth/login');
    })->name('logout');
});
// Ranking Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ranking', [\App\Http\Controllers\RankingController::class, 'index'])->name('ranking');
    Route::post('/ranking/save', [\App\Http\Controllers\RankingController::class, 'saveRanking'])->name('ranking.save');
    Route::get('/ranking/get', [\App\Http\Controllers\RankingController::class, 'getRanking'])->name('ranking.get');
});