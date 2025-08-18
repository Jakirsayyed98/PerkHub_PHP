<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('admin') }}" class="brand-link d-flex align-items-center px-4 py-3">
    <img src="{{ asset('adminpanel/dist/img/AdminLTELogo.png') }}" 
         alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .9; width: 36px; height: 36px;">
    <span class="brand-text font-weight-semibold text-lg">Admin Panel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') || request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- User Management -->
        <li class="nav-header">USER MANAGEMENT</li>
        <li class="nav-item">
          <a href="{{ url('Users') }}" class="nav-link {{ request()->is('Users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
          </a>
        </li>

        <!-- Content Management -->
        <li class="nav-header">CONTENT MANAGEMENT</li>
        <!-- Banners -->
        <li class="nav-item has-treeview {{ request()->is('bannerlist*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('bannerlist*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-image"></i>
            <p>
              Banners
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('bannerlist?id=1') }}" class="nav-link {{ request()->query('id') == '1' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Banner 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('bannerlist?id=2') }}" class="nav-link {{ request()->query('id') == '2' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Banner 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('bannerlist?id=3') }}" class="nav-link {{ request()->query('id') == '3' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Banner 3</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Stores -->
        <li class="nav-item has-treeview {{ request()->is('MiniApp*') || request()->is('AffiliateProviders*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('MiniApp*') || request()->is('AffiliateProviders*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-store"></i>
            <p>
              Stores
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('MiniAppCategoryList') }}" class="nav-link {{ request()->is('MiniAppCategoryList*') ? 'active' : '' }}">
                <i class="fas fa-tags nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('AffiliateProviders') }}" class="nav-link {{ request()->is('AffiliateProviders*') ? 'active' : '' }}">
                <i class="fas fa-handshake nav-icon"></i>
                <p>Affiliate Providers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('MiniAppList') }}" class="nav-link {{ request()->is('MiniAppList*') ? 'active' : '' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>Stores List</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Finance -->
        <li class="nav-header">FINANCE</li>
        <!-- Transactions -->
        <li class="nav-item">
          <a href="{{ url('MiniApptransaction') }}" class="nav-link {{ request()->is('MiniApptransaction*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-receipt"></i>
            <p>Transactions</p>
          </a>
        </li>
        <!-- Withdrawals -->
        <li class="nav-item has-treeview {{ request()->is('WithdrawalList*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('WithdrawalList*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-wallet"></i>
            <p>
              Withdrawals
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('WithdrawalList?status=pending') }}" class="nav-link {{ request()->query('status') == 'pending' ? 'active' : '' }}">
                <i class="far fa-clock nav-icon"></i>
                <p>Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('WithdrawalList?status=approved') }}" class="nav-link {{ request()->query('status') == 'approved' ? 'active' : '' }}">
                <i class="far fa-check-circle nav-icon"></i>
                <p>Completed</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('WithdrawalList?status=rejected') }}" class="nav-link {{ request()->query('status') == 'rejected' ? 'active' : '' }}">
                <i class="far fa-times-circle nav-icon"></i>
                <p>Rejected</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Notifications -->
        <li class="nav-header">COMMUNICATION</li>
        <li class="nav-item">
          <a href="{{ url('adminnotificationlist') }}" class="nav-link {{ request()->is('adminnotificationlist*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Notifications</p>
          </a>
        </li>

        <!-- Games -->
        <li class="nav-header">GAMING</li>
        <li class="nav-item has-treeview {{ request()->is('Games*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('Games*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-gamepad"></i>
            <p>
              Games
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('GamesCategoryList') }}" class="nav-link {{ request()->is('GamesCategoryList*') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('GamesList') }}" class="nav-link {{ request()->is('GamesList*') ? 'active' : '' }}">
                <i class="fas fa-th-list nav-icon"></i>
                <p>Games List</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Support -->
        <li class="nav-header">SUPPORT</li>
        <li class="nav-item has-treeview {{ request()->is('adminTicketList*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('adminTicketList*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
              Tickets
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('adminTicketList?status=open') }}" class="nav-link {{ request()->query('status') == 'open' ? 'active' : '' }}">
                <i class="far fa-folder-open nav-icon"></i>
                <p>Open</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('adminTicketList?status=in_progress') }}" class="nav-link {{ request()->query('status') == 'in_progress' ? 'active' : '' }}">
                <i class="fas fa-spinner nav-icon"></i>
                <p>In Progress</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('adminTicketList?status=resolved') }}" class="nav-link {{ request()->query('status') == 'resolved' ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Resolved</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- System -->
        <li class="nav-header">SYSTEM</li>
        <li class="nav-item">
          <a href="{{ url('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
            <p class="text-danger">Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<style>
/* Enhanced styles with new color scheme for professional look */
.main-sidebar {
  transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
  background: linear-gradient(to bottom, #2d3748, #4a5568); /* Charcoal gradient */
}

.brand-link {
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
  background-color: #2d3748; /* Matches sidebar top */
}

.brand-text {
  font-size: 1.2rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  color: #e2e8f0; /* Light slate for text */
}

.nav-header {
  font-size: 0.85rem;
  font-weight: 700;
  color: #a0aec0; /* Muted slate for headers */
  padding: 1rem 1.25rem;
  letter-spacing: 1px;
}

.nav-link {
  border-radius: 0 1.5rem 1.5rem 0;
  color: #cbd5e0; /* Light gray for links */
  transition: background-color 0.2s, color 0.2s, padding-left 0.2s;
}

.nav-link:hover {
  background-color: rgba(45, 212, 191, 0.1); /* Subtle teal hover */
  color: #ffffff;
  padding-left: 1.5rem;
}

.nav-link.active {
  background-color: #2dd4bf !important; /* Teal for active state */
  color: #ffffff !important;
}

.nav-treeview .nav-link {
  padding-left: 2.5rem;
  font-size: 0.95rem;
  color: #b8c7ce; /* Slightly darker gray for sub-links */
}

.nav-treeview .nav-link:hover {
  background-color: rgba(45, 212, 191, 0.05);
  color: #ffffff;
}

.nav-icon {
  width: 1.5rem;
  text-align: center;
  color: #e2e8f0; /* Light slate for icons */
}

.nav-link.active .nav-icon,
.nav-link:hover .nav-icon {
  color: #ffffff;
}

/* Mobile responsiveness */
@media (max-width: 767.98px) {
  .main-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    transform: translateX(-100%);
    width: 250px;
    z-index: 1050;
  }
  .main-sidebar.sidebar-open {
    transform: translateX(0);
  }
  .content-wrapper, .main-footer {
    transition: margin-left 0.3s ease-in-out;
  }
  .sidebar-open .content-wrapper,
  .sidebar-open .main-footer {
    margin-left: 0 !important;
  }
}

/* Scrollbar styling */
.sidebar {
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #718096 #2d3748;
}

.sidebar::-webkit-scrollbar {
  width: 6px;
}

.sidebar::-webkit-scrollbar-track {
  background: #2d3748;
}

.sidebar::-webkit-scrollbar-thumb {
  background: #718096;
  border-radius: 3px;
}
</style>

<script>
// JavaScript for sidebar toggle on mobile
document.addEventListener('DOMContentLoaded', function () {
  const sidebarToggle = document.querySelector('.sidebar-toggle');
  const sidebar = document.querySelector('.main-sidebar');
  const body = document.body;

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('sidebar-open');
      body.classList.toggle('sidebar-open');
    });
  }

  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function (event) {
    if (window.innerWidth <= 767.98 && sidebar.classList.contains('sidebar-open')) {
      if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
        sidebar.classList.remove('sidebar-open');
        body.classList.remove('sidebar-open');
      }
    }
  });
});
</script>