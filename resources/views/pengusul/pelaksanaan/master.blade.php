<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PKM POLBAN' }}</title>

    <!-- Meta Tags -->
    <meta name="author" content="POLBAN">
    <meta name="description" content="Sistem PKM POLBAN">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Additional CSS -->
    @stack('styles')
    <style>
        .nav-item .nav-link,
        .nav-item form button.nav-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: inherit;
        }

        .nav-item form button.nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .nav-item form {
            width: 100%;
        }

        .nav-icon {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="{{ route('pengusul.dashboard') }}">
                    <img src="{{ asset('images/PKMPOLBAN.png') }}" alt="PKM POLBAN" class="img-fluid"
                        style="max-width: 120px;">
                </a>
            </div>

            <div class="sidebar-wrapper">
                <div class="sidebar-info text-center p-1">

                </div>

                <!-- Navigation Menu -->
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('pengusul.dashboard-pelaksanaan') }}"
                                class="nav-link {{ Request::is('pengusul/dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-house"></i>
                                <p>Beranda</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ Request::is('pengusul/identitas-usulan*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-pencil-fill"></i>
                                <p>
                                    Logbook
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" " class="nav-link">
                                        <p>Logbook Kegiatan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengusul.dashboard-logbook-keuangan') }}" class="nav-link">
                                        <p>Logbook Keuangan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ Request::is('pengusul/identitas-usulan*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                                <p>
                                    Pelaksanaan Kegiatan
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengusul.lap-kemajuan') }}" class="nav-link {{ request()->routeIs('pengusul.lap-kemajuan') ? 'active' : '' }}">
                                        <p>Laporan Kemajuan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" " class="nav-link">
                                        <p>Luaran Kemajuan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengusul.laporan-akhir') }}" class="nav-link {{ request()->routeIs('pengusul.laporan-akhir') ? 'active' : '' }}">
                                        <p>Laporan Akhir</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" " class="nav-link">
                                        <p>Luaran Akhir</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ Request::is('pengusul/identitas-usulan*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-fill"></i>
                                <p>
                                    Profile
                                </p>
                            </a>


                            <li class="nav-item mt-5"> <!-- Menambahkan jarak di atas item ini -->
                                <form action="{{ route('pengusul.logout') }}" method="post" class="d-flex justify-content-center">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>


                    </ul>
                </nav>


            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            @yield('konten')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    <!-- Initialize OverlayScrollbars -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(".sidebar-wrapper");
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined") {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: "os-theme-light",
                        autoHide: "leave",
                        clickScroll: true
                    }
                });
            }
        });

        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#003c72',
            });
        @endif
        @if (session()->has('error'))
            Swal.fire({
                title: 'Perhatian!',
                text: "{{ session('error') }}",
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#003c72',
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>
