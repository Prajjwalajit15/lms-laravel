 

 <div class="admin-profile-section mb-4 p-3">
    <div class="d-flex align-items-center sidebar-expanded"> <!-- changed class -->
        <div class="admin-avatar position-relative">
            <img src="{{ asset('asset/images/user.jpg') }}" 
                 alt="Admin Avatar" 
                 class="rounded-circle border border-2 border-primary" 
                 width="50" height="50" 
                 style="object-fit: cover;">
            <div class="status-indicator"></div>
        </div>
        <div class="admin-info flex-grow-1 ms-2">
            <!-- <h4 class="admin-name mb-1 text-white fw-bold">{{ session('admin_name','Administrator') }}</h4> -->
            <h4 class="admin-name mb-1 text-white fw-bold">Administrator</h4>
            <small class="admin-role text-white fw-semibold">
                <i class="bi bi-shield-check me-1 text-white"></i>Super Admin
            </small>
        </div>
    </div>
</div>


<div id="sidebarAccordion">

    <h6 class="sidebar-heading mt-3">Main</h6>
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> <span class="link-text">Dashboard</span>
    </a>

    <h6 class="sidebar-heading mt-4">Inventory</h6>

    <!-- Books -->
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#booksMenu" aria-expanded="{{ request()->routeIs('books.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-book me-2"></i> <span class="link-text">Book Management</span></span>
        <i class="bi bi-caret-down"></i>
    </a>
    <div class="collapse submenu ps-3 {{ request()->routeIs('books.*') ? 'show' : '' }}" id="booksMenu" data-bs-parent="#sidebarAccordion">
        <a href="{{ route('books.add') }}" class="nav-link {{ request()->routeIs('books.add') ? 'active' : '' }}">
            <i class="bi bi-plus-circle me-2"></i> Add Book
        </a>
        <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark me-2"></i> View Books
        </a>
    </div>

    <!-- Students -->
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#studentsMenu" aria-expanded="{{ request()->routeIs('students.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-people me-2"></i> <span class="link-text">Student Management</span></span>
        <i class="bi bi-caret-down"></i>
    </a>
    <div class="collapse submenu ps-3 {{ request()->routeIs('students.*') ? 'show' : '' }}" id="studentsMenu" data-bs-parent="#sidebarAccordion">
        <a href="{{ route('students.add') }}" class="nav-link {{ request()->routeIs('students.add') ? 'active' : '' }}">
            <i class="bi bi-person-plus me-2"></i> Add Student
        </a>
        <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
            <i class="bi bi-card-list me-2"></i> View Students
        </a>
    </div>

    <!-- Loans -->
    <h6 class="sidebar-heading mt-4">Business</h6>
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#loansMenu" aria-expanded="{{ request()->routeIs('loans.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-journal-text me-2"></i> <span class="link-text">Borrowed Books</span></span>
        <i class="bi bi-caret-down"></i>
    </a>
    <div class="collapse submenu ps-3 {{ request()->routeIs('loans.*') ? 'show' : '' }}" id="loansMenu" data-bs-parent="#sidebarAccordion">
        <a href="{{ route('loans.add') }}" class="nav-link {{ request()->routeIs('loans.add') ? 'active' : '' }}">
            <i class="bi bi-plus-circle me-2"></i> Add New
        </a>
        <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index') ? 'active' : '' }}">
            <i class="bi bi-folder2-open me-2"></i> Manage All
        </a>
    </div>

    <h6 class="sidebar-heading mt-4">Account</h6>
    <a href="{{ route('logout') }}" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right me-2"></i> <span class="link-text">Logout</span>
    </a>
</div>




<style>
/* Admin Profile Section Styles */
.admin-profile-section {
    background: linear-gradient(135deg, rgba(79, 195, 247, 0.1) 0%, rgba(33, 150, 243, 0.1) 100%);
    border-radius: 12px;
    border: 1px solid rgba(79, 195, 247, 0.2);
    margin: 15px;
}

.admin-avatar {
    position: relative;
}

.admin-avatar img {
    transition: all 0.3s ease;
}

.admin-avatar img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(79, 195, 247, 0.3);
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #28a745;
    border: 2px solid #1e1e1e;
    border-radius: 50%;
    animation: pulse-status 2s infinite;
}

@keyframes pulse-status {
    0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
    70% { box-shadow: 0 0 0 8px rgba(40, 167, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

.admin-name {
    font-size: 16px;
    margin-bottom: 2px;
}

.admin-role {
    font-size: 12px;
    display: flex;
    align-items: center;
}

.admin-stats {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    padding: 10px;
}

.stat-item {
    transition: transform 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
}

.stat-number {
    font-size: 18px;
    line-height: 1;
}

.stat-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Dropdown menu styling */
.dropdown-menu {
    background: #1e1e1e;
    border: 1px solid #333;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.dropdown-item {
    color: #ddd;
    transition: all 0.3s ease;
    padding: 8px 16px;
}

.dropdown-item:hover {
    background: rgba(79, 195, 247, 0.1);
    color: #fff;
}

.dropdown-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .admin-profile-section {
        margin: 10px;
        padding: 15px !important;
    }
    
    .admin-avatar img {
        width: 40px;
        height: 40px;
    }
    
    .admin-name {
        font-size: 14px;
    }
    
    .stat-number {
        font-size: 16px;
    }
}

/* Collapsed sidebar styles */
.sidebar.collapsed .admin-profile-section {
    margin: 10px 5px;
    padding: 10px;
    text-align: center;
}

.sidebar.collapsed .admin-info,
.sidebar.collapsed .admin-stats,
.sidebar.collapsed .dropdown {
    display: none;
}

/* Make avatar smaller and centered */
.sidebar.collapsed .admin-avatar {
    margin: 0 auto;
}

.sidebar.collapsed .admin-avatar img {
    width: 40px;      /* smaller size */
    height: 40px;     /* smaller size */
    border-width: 1px; /* thinner border */
    object-fit: cover; /* maintain image proportion */
    margin-left: -20px;
}



</style>

<script>
document.getElementById('addProfileForm')?.addEventListener('submit', function(e){
    e.preventDefault();

    const name  = document.getElementById('profileName').value;
    const email = document.getElementById('profileEmail').value;

     

    // Update dashboard UI
    document.querySelector('.admin-name').textContent = name;
    document.getElementById('viewProfileName').textContent = name;
    document.getElementById('viewProfileEmail').textContent = email;

    // Save to localStorage
    localStorage.setItem("adminProfileAdded", "true");

    // Hide "Add Your Profile" menu item
    document.querySelector('#addProfileMenu')?.classList.add("d-none");

    // Close modal
    document.getElementById('profileModal').querySelector('.btn-close').click();
});

document.getElementById('updateProfileForm')?.addEventListener('submit', function(e){
    e.preventDefault();

    const name  = document.getElementById('updateName').value;
    const email = document.getElementById('updateEmail').value;

     

    // Update dashboard UI
    document.querySelector('.admin-name').textContent = name;
    document.getElementById('viewProfileName').textContent = name;
    document.getElementById('viewProfileEmail').textContent = email;

    // Close modal
    document.getElementById('settingsModal').querySelector('.btn-close').click();
});

// On page load → hide menu if profile already added
window.addEventListener("DOMContentLoaded", function() {
    if(localStorage.getItem("adminProfileAdded") === "true") {
        document.querySelector('#addProfileMenu')?.classList.add("d-none");
    }
});
</script>
