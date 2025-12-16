const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("sidebarToggle");
const closeBtn = document.getElementById("sidebarClose");
const overlay = document.getElementById("sidebarOverlay");

// Function to open sidebar
function openSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.add("show");
    overlay.classList.add("show");
    document.body.style.overflow = "hidden"; // Prevent background scrolling
}

// Function to close sidebar
function closeSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.remove("show");
    overlay.classList.remove("show");
    document.body.style.overflow = ""; // Restore scrolling
}

// Toggle sidebar when toggle button is clicked (safe-guard if button exists)
if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
        if (sidebar.classList.contains("show")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });
}

// Close sidebar when close button is clicked
if (closeBtn) closeBtn.addEventListener("click", closeSidebar);

// Close sidebar when overlay is clicked
if (overlay) overlay.addEventListener("click", closeSidebar);

// Close sidebar when pressing Escape key
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && sidebar && sidebar.classList.contains("show")) {
        closeSidebar();
    }
});

// Handle window resize - close sidebar if resizing to desktop
window.addEventListener("resize", () => {
    if (window.innerWidth > 991.98) {
        closeSidebar();
    }
});

// ==========================
// Submenu Toggle Logic
// ==========================
function initSubmenus() {
    const submenuToggles = document.querySelectorAll('.submenu-toggle');

    function closeAllSubmenus(exceptSelector) {
        document.querySelectorAll('.sidebar .submenu').forEach((ul) => {
            if (exceptSelector && ('#' + ul.id) === exceptSelector) return;
            ul.classList.remove('show');
        });
        document.querySelectorAll('.submenu-toggle[aria-expanded="true"]').forEach((t) => {
            if (exceptSelector && t.getAttribute('data-submenu') === exceptSelector) return;
            t.setAttribute('aria-expanded', 'false');
        });
    }

    submenuToggles.forEach((toggle) => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSel = toggle.getAttribute('data-submenu');
            if (!targetSel) return;
            const submenu = document.querySelector(targetSel);
            if (!submenu) return;

            const isOpen = submenu.classList.contains('show');
            // Close others first
            closeAllSubmenus(targetSel);
            // Toggle current
            submenu.classList.toggle('show', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });
    });

    // Close submenus when clicking outside the sidebar
    document.addEventListener('click', (e) => {
        const withinSidebar = e.target.closest('#sidebar');
        if (!withinSidebar) closeAllSubmenus();
    });

    // Expand the submenu that contains an active link on load
    document.querySelectorAll('.sidebar .submenu').forEach((submenu) => {
        const activeChild = submenu.querySelector('.submenu-link.active');
        if (activeChild) {
            submenu.classList.add('show');
            const parentToggle = submenu.parentElement.querySelector('.submenu-toggle');
            if (parentToggle) parentToggle.setAttribute('aria-expanded', 'true');
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSubmenus);
} else {
    initSubmenus();
}