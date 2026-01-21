<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB ERP PRO | {{ session('lab_name', 'System') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons & Styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 
                            400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 
                            800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        },
                        slate: { 950: '#020617' }
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .menu-item-active { @apply bg-white/10 text-white border-l-4 border-blue-500; }
        .glass-effect { backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.8); }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .sidebar-collapsed { width: 80px !important; }
        .sidebar-collapsed .menu-label, .sidebar-collapsed .user-info { display: none !important; }
        .sidebar-collapsed .menu-icon { margin-right: 0 !important; width: 100% !important; text-align: center; }
        
        .treeview-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
        .menu-open .treeview-menu { max-height: 500px; transition: max-height 0.5s ease-in; }
        .menu-open .chevron-icon { transform: rotate(90deg); }
        .chevron-icon { transition: transform 0.3s ease; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 overflow-hidden">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="mainSidebar" class="sidebar-transition relative w-64 bg-slate-950 text-slate-400 flex flex-col z-50 shadow-2xl">
            <!-- Brand -->
            <div class="h-16 flex items-center px-6 bg-slate-900/50 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-600 rounded-lg shadow-lg shadow-blue-500/20">
                        <i class="fas fa-microscope text-white text-xl"></i>
                    </div>
                    <span class="menu-label font-black text-white tracking-tighter text-xl">LAB<span class="text-blue-500">ERP</span></span>
                </div>
            </div>

            <!-- User Status -->
            <div class="user-info p-6 border-b border-white/5 bg-slate-950/20">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ substr(session('user_name'), 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-slate-950 rounded-full"></div>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm leading-none truncate w-32">{{ session('user_name') }}</p>
                        <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest font-black">{{ session('role', 'Staff') }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all group">
                    <i class="fas fa-chart-pie w-6 text-lg menu-icon group-hover:scale-110 transition-transform"></i>
                    <span class="menu-label ml-3">Overview</span>
                </a>

                <div class="px-6 py-4">
                    <p class="menu-label text-[10px] font-black text-slate-600 uppercase tracking-[0.2em]">Management</p>
                </div>

                <!-- Master Data -->
                <div class="treeview group">
                    <button class="w-full flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all outline-none">
                        <i class="fas fa-layer-group w-6 text-lg menu-icon"></i>
                        <span class="menu-label ml-3 flex-1 text-left">Master Data</span>
                        <i class="fas fa-chevron-right text-[10px] menu-label chevron-icon"></i>
                    </button>
                    <div class="treeview-menu bg-slate-900/50">
                        <a href="{{ route('users.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> User Management
                        </a>
                        <a href="{{ route('clients.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Party / Agencies
                        </a>
                        <a href="{{ route('occupations.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Occupation List
                        </a>
                        <a href="{{ route('doctors.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Doctor Registry
                        </a>
                    </div>
                </div>

                <!-- Medical Services -->
                <div class="treeview">
                    <button class="w-full flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all outline-none">
                        <i class="fas fa-stethoscope w-6 text-lg menu-icon"></i>
                        <span class="menu-label ml-3 flex-1 text-left">Medical Works</span>
                        <i class="fas fa-chevron-right text-[10px] menu-label chevron-icon"></i>
                    </button>
                    <div class="treeview-menu bg-slate-900/50">
                        <a href="{{ route('medical.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Lab Reports
                        </a>
                        <a href="{{ route('medical-tests.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Test Parameters
                        </a>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="treeview">
                    <button class="w-full flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all outline-none">
                        <i class="fas fa-boxes w-6 text-lg menu-icon"></i>
                        <span class="menu-label ml-3 flex-1 text-left">Inventory</span>
                        <i class="fas fa-chevron-right text-[10px] menu-label chevron-icon"></i>
                    </button>
                    <div class="treeview-menu bg-slate-900/50">
                        <a href="{{ route('inventory.index') }}" class="flex items-center pl-15 pr-6 py-2.5 text-xs font-medium hover:text-blue-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700 mr-3"></span> Stock Control
                        </a>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <p class="menu-label text-[10px] font-black text-slate-600 uppercase tracking-[0.2em]">Reporting</p>
                </div>

                <a href="#" class="flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all group">
                    <i class="fas fa-file-invoice-dollar w-6 text-lg menu-icon group-hover:scale-110"></i>
                    <span class="menu-label ml-3">Finance Ledger</span>
                </a>
                
                <a href="#" class="flex items-center px-6 py-3.5 text-sm font-medium hover:text-white hover:bg-white/5 transition-all group">
                    <i class="fas fa-wallet w-6 text-lg menu-icon group-hover:scale-110"></i>
                    <span class="menu-label ml-3">Agent Balances</span>
                </a>

                <div class="mt-auto px-6 py-10">
                    <a href="{{ route('logout') }}" class="flex items-center px-6 py-3 rounded-2xl bg-white/5 text-slate-300 hover:bg-red-500 hover:text-white transition-all group shadow-inner">
                        <i class="fas fa-power-off w-4 text-xs"></i>
                        <span class="menu-label ml-3 font-bold text-xs">Sign Out</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50 relative overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 flex items-center justify-between px-8 border-b border-slate-200 glass-effect sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <button id="toggleSidebar" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                    <nav class="flex items-center space-x-2 text-sm font-medium text-slate-400 overflow-hidden truncate">
                        <span class="hidden md:inline">{{ session('lab_name') }}</span>
                        <i class="fas fa-chevron-right text-[10px] hidden md:inline"></i>
                        <span class="text-slate-900 font-bold uppercase tracking-tight">Active Terminal</span>
                    </nav>
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden lg:flex items-center gap-3 px-4 py-1.5 bg-blue-50 border border-blue-100 rounded-full">
                        <i class="fas fa-calendar-alt text-blue-500 text-xs"></i>
                        <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">FY {{ session('financial_year_name') }}</span>
                    </div>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="flex items-center gap-3 group cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-black text-slate-900 leading-none group-hover:text-blue-600 transition-colors uppercase">{{ session('user_name') }}</p>
                            <p class="text-[10px] text-emerald-500 font-bold mt-1 uppercase">Connected</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user_name')) }}&background=2563eb&color=fff&bold=true" 
                             class="w-10 h-10 rounded-xl shadow-md border-2 border-white group-hover:scale-110 transition-transform">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-8 lg:p-10 custom-scrollbar">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="mb-8 flex items-center p-5 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-3xl animate-bounce shadow-sm">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-emerald-600"></i>
                        </div>
                        <p class="font-bold text-sm tracking-tight">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-3xl shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center mr-4">
                                <i class="fas fa-triangle-exclamation text-red-600"></i>
                            </div>
                            <h4 class="font-black text-red-900 uppercase tracking-tighter">System Interruption</h4>
                        </div>
                        <ul class="space-y-2">
                            @foreach($errors->all() as $error)
                                <li class="text-red-700 text-sm font-medium flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-3"></span> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="relative z-0">
                    @yield('content')
                </div>
            </div>

            <!-- Global Footer Status -->
            <footer class="h-10 border-t border-slate-200 glass-effect flex items-center justify-between px-8 text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] relative z-40">
                <div>&copy; {{ date('Y') }} Lab ERP Production Unit</div>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> System Optimized</span>
                    <span class="hidden sm:inline">Build 2.0.4-STABLE</span>
                </div>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('mainSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
        });

        // Treeview Logic
        document.querySelectorAll('.treeview button').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.closest('.treeview');
                parent.classList.toggle('menu-open');
                
                // Accordion behavior (optional)
                document.querySelectorAll('.treeview').forEach(other => {
                    if (other !== parent) other.classList.remove('menu-open');
                });
            });
        });

        // Highlight active menu item based on current URL (Simplified)
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav a').forEach(link => {
            if (link.getAttribute('href') !== '#' && currentPath.includes(link.getAttribute('href'))) {
                link.classList.add('bg-blue-600/10', 'text-blue-500', 'font-black');
                const treeview = link.closest('.treeview');
                if (treeview) treeview.classList.add('menu-open');
            }
        });
    </script>
</body>
</html>
