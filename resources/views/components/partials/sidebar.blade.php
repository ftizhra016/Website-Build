<!-- Sidebar Overlay -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<!-- Sidebar -->
<nav id="sidebar" class="sidebar" style="background-color: #000000">
    <!-- Close button for mobile -->
    <button id="sidebarClose" class="sidebar-close">
        <i class="fas fa-times"></i>
    </button>

    <div class="sidebar-header d-flex align-items-center" style="border-bottom: 1px solid #5A5F6D;">
        <div class="logo-icon me-2">
            <!-- <img src="{{ asset('assets/img/logo-cms.svg') }}" class="img-fluid" alt="Logo"> -->
             <h5 class="fw-bold text-white">Landing Page Builder</h5>
        </div>
        <!-- <span class="fw-bold text-white">Sastra UM</span> -->
    </div>

    <ul class="sidebar-nav">
        <!-- Slideshow - Direct Link -->
        <li class="mt-2">
            <a href="{{ route('page-builder.index') }}" class="nav-link slideshow-link {{ active_class(['cms/page-builder*','/']) }}">
                <svg width="20" height="21" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.53648 0.876841C6.67861 0.753098 8.11821 0.753105 9.95475 0.753113H10.0452C11.8818 0.753105 13.3214 0.753098 14.4635 0.876841C15.6291 1.00312 16.5734 1.26544 17.3798 1.85127C17.8679 2.20592 18.2972 2.6352 18.6518 3.12335C19.2377 3.92967 19.5 4.87405 19.6263 6.03959C19.75 7.18171 19.75 8.62135 19.75 10.4578V10.5091C19.75 11.4434 19.75 12.2713 19.7348 13.0036C19.6903 15.1577 19.5217 16.6856 18.6518 17.8829C18.2972 18.371 17.8679 18.8003 17.3798 19.155C16.5734 19.7408 15.6291 20.0031 14.4635 20.1294C13.3214 20.2531 11.8818 20.2531 10.0453 20.2531H9.95473C8.11824 20.2531 6.67859 20.2531 5.53648 20.1294C4.37094 20.0031 3.42656 19.7408 2.62024 19.155C2.14981 18.8132 1.73405 18.4021 1.38706 17.9358C1.37399 17.9182 1.36102 17.9006 1.34815 17.8829C0.762324 17.0766 0.500006 16.1322 0.373728 14.9666C0.249985 13.8245 0.249992 12.3849 0.25 10.5484V10.4579C0.249992 8.62133 0.249986 7.18172 0.373729 6.03959C0.500007 4.87405 0.762324 3.92967 1.34815 3.12335C1.70281 2.6352 2.13209 2.20592 2.62024 1.85127C3.42656 1.26544 4.37094 1.00312 5.53648 0.876841ZM18.2453 12.2548L18.1823 12.1939C17.9063 11.9288 17.7024 11.7494 17.5106 11.6133C15.3618 10.0876 12.3978 10.4916 10.7358 12.5367C10.535 12.7837 10.3341 13.1128 10.0182 13.6653L9.5 13.5031C8.30448 13.264 7.70672 13.1445 7.15808 13.1561C5.68985 13.1873 4.30956 13.8624 3.38354 15.0022C3.07484 15.3821 2.82456 15.8571 2.38701 16.7294C2.44098 16.8249 2.49912 16.9151 2.56168 17.0012L2.59044 17.0403C2.8469 17.385 3.15421 17.6888 3.50191 17.9414C4.00992 18.3105 4.66013 18.5257 5.69804 18.6381C6.74999 18.7521 8.10843 18.7531 10 18.7531C11.8916 18.7531 13.25 18.7521 14.302 18.6381C15.3399 18.5257 15.9901 18.3105 16.4981 17.9414C16.8589 17.6793 17.1762 17.362 17.4383 17.0012C18 16.2281 18.19 15.1557 18.2352 12.9726C18.2399 12.7437 18.2431 12.5047 18.2453 12.2548ZM9 9.50311C7.89543 9.50311 7 8.60768 7 7.50311C7 6.39854 7.89543 5.50311 9 5.50311C10.1046 5.50311 11 6.39854 11 7.50311C11 8.60768 10.1046 9.50311 9 9.50311Z" />
                </svg>
                <span>Page Builder</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer d-flex align-items-center" style="border-top: 1px solid #5A5F6D;">
        <img src="{{ asset('assets/img/person-icon.png') }}" class="rounded-circle me-2 img-fluid" width="40">
        <div>
            <div class="fw-semibold text-white">Admin</div>
            <small class="fw-semibold" style="color: #707A91;">Administrator</small>
        </div>
    </div>
</nav>