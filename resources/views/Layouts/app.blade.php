<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Sekolah - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color:rgb(52, 64, 195);
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            display: flex;
            min-height: 100vh;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s;
            min-height: 100vh;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #4e73df;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul p {
            color: white;
            padding: 10px;
        }
        
        #sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        #sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
        }
        
        #sidebar ul li.active > a {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }
        
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 1rem;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
            color: var(--dark-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: white;
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .page-link {
            color: var(--primary-color);
        }
        
        /* Mobile view */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
                position: fixed;
                z-index: 1;
                height: 100%;
            }
            
            #sidebar.active {
                margin-left: 0;
            }
            
            #content {
                width: 100%;
            }
            
            #sidebarCollapse {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            #sidebarCollapse {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <h4>Sistem Absensi</h4>
        </div>

        <ul class="list-unstyled components">
            @if(auth()->user()->role == 'admin')
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <a href="{{ url('admin/siswa') }}">
                        <i class="fas fa-user-graduate"></i> Data Siswa
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.guru.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i> Data Guru
                    </a>
                </li>
            @elseif(auth()->user()->role == 'guru')
                <li class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('guru.profil') ? 'active' : '' }}">
                    <a href="{{ route('guru.profil') }}">
                        <i class="fas fa-user"></i> Profil
                    </a>
                </li>
                <li class="{{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
                    <a href="{{ route('guru.siswa.index') }}">
                        <i class="fas fa-user-graduate"></i> Data Siswa
                    </a>
                </li>
                <li class="{{ request()->routeIs('guru.absensi.*') ? 'active' : '' }}">
                    <a href="{{ route('guru.absensi.index') }}">
                        <i class="fas fa-clipboard-check"></i> Konfirmasi Absensi
                    </a>
                </li>
            @elseif(auth()->user()->role == 'siswa')
                <li class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('siswa.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
                    <a href="{{ route('siswa.profil') }}">
                        <i class="fas fa-user"></i> Profil
                    </a>
                </li>
                <li class="{{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}">
                    <a href="{{ route('siswa.absensi.index') }}">
                        <i class="fas fa-clipboard-list"></i> Absensi
                    </a>
                </li>
            @endif
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn" id="sidebarCollapse">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="ms-auto">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->nama ?? auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            @if(auth()->user()->role == 'guru')
                                <li><a class="dropdown-item" href="{{ route('guru.profil') }}">Profil</a></li>
                            @elseif(auth()->user()->role == 'siswa')
                                <li><a class="dropdown-item" href="{{ route('siswa.profil') }}">Profil</a></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @yield('scripts')
</body>
</html>