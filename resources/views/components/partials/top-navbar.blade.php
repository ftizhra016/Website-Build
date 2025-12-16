<!-- Top Navbar -->
<nav class="navbar navbar-expand navbar-light bg-white border-bottom shadow-sm mb-4">
  <div class="container-fluid px-0">
    <button id="sidebarToggle" class="btn btn-outline-secondary d-lg-none">
      <i class="fas fa-bars"></i>
    </button>
    <div class="ms-auto me-2">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <i class="fas fa-user-circle fa-lg"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form action="" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>