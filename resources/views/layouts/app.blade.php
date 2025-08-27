<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Admin</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { font-family: "Segoe UI", sans-serif; background: #f5f5f5; }
        .sidebar { width: 250px; background: #1e1e1e; color: #fff; min-height: 100vh; transition: 0.3s; }
        .sidebar .nav-link { color: #ddd; margin-bottom: 5px; border-radius: 6px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(13,110,253,0.15); color: #fff; }

        /* Collapsed Sidebar */
        .sidebar.collapsed { width: 70px; overflow: hidden; }
        .sidebar.collapsed .link-text,
        .sidebar.collapsed .admin-info,
        .sidebar.collapsed .sidebar-heading { display: none; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 12px 0; }
        .sidebar.collapsed .submenu { position: absolute; left: 70px; width: 180px; background: #1e1e1e; display: none; z-index: 999; border-radius: 8px; }
        .sidebar.collapsed .nav-link:hover + .submenu,
        .sidebar.collapsed .submenu.show { display: block !important; }

        #sidebarCollapseBtn { margin-bottom: 10px; }

        /* Admin Profile Section */
        .admin-profile-section { background: linear-gradient(135deg, rgba(79,195,247,0.1) 0%, rgba(33,150,243,0.1) 100%); border-radius: 12px; border: 1px solid rgba(79,195,247,0.2); margin: 15px; }
        .admin-avatar { position: relative; }
        .admin-avatar img { transition: all 0.3s ease; }
        .admin-avatar img:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(79,195,247,0.3); }
        .status-indicator { position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background: #28a745; border: 2px solid #1e1e1e; border-radius: 50%; animation: pulse-status 2s infinite; }
        @keyframes pulse-status { 0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.7); } 70% { box-shadow: 0 0 0 8px rgba(40,167,69,0); } 100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); } }

        /* Mobile Responsive */
        @media (max-width: 767px) { 
            .sidebar.d-md-block { display: none !important; }
            .admin-profile-section { margin: 10px; padding: 15px !important; }
            .admin-avatar img { width: 40px; height: 40px; }
        }
    </style>
</head>
<body>
<div class="d-flex">

    <!-- Desktop Sidebar -->
    <div id="sidebar" class="sidebar d-none d-md-block p-3">
        <button id="sidebarCollapseBtn" class="btn btn-sm btn-outline-light w-100 mb-3">
            <i class="bi bi-chevron-left"></i>
        </button>
        @include('partials.sidebar')
    </div>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start sidebar d-md-none" tabindex="-1" id="sidebarOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('partials.sidebar')
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1 p-4">
        <!-- Mobile Toggle Button -->
        <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list"></i> Menu
        </button>

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const collapseBtn = document.getElementById('sidebarCollapseBtn');

    collapseBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        collapseBtn.classList.toggle('collapsed');

        const icon = collapseBtn.querySelector('i');
        if(icon){ icon.classList.toggle('bi-chevron-right'); icon.classList.toggle('bi-chevron-left'); }

        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });

    if(localStorage.getItem('sidebarCollapsed') === 'true'){
        sidebar.classList.add('collapsed');
        collapseBtn.classList.add('collapsed');
        const icon = collapseBtn.querySelector('i');
        if(icon){ icon.classList.remove('bi-chevron-left'); icon.classList.add('bi-chevron-right'); }
    }

    // Close mobile offcanvas on link click
    document.querySelectorAll('#sidebarOffcanvas .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('sidebarOffcanvas'));
            if(offcanvas) offcanvas.hide();
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')


</body>
</html>





