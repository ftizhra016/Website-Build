    // Bootstrap 5 Modal/Toast helpers
    function modalInstance(id) {
        const el = document.getElementById(id);
        if (!el) return null;
        return bootstrap.Modal.getOrCreateInstance(el);
    }
    function toastInstance(id) {
        const el = document.getElementById(id);
        if (!el) return null;
        return (typeof bootstrap !== 'undefined' && bootstrap.Toast)
            ? bootstrap.Toast.getOrCreateInstance(el)
            : null;
    }
    function showToast(id) {
        const inst = toastInstance(id);
        if (inst) {
            inst.show();
        } else {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('show');
            el.style.display = 'block';
            setTimeout(() => {
                el.classList.remove('show');
                el.style.display = '';
            }, 3000);
        }
    }
$(document).ready(function () {
    const url = "/cms/page-builder";
    let selectedMonth = "";
    let selectedTextMonth = "";
    let selectedYear = "";
    let selectedStatus = "";

    let table = $("#PageBuilderTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            data: function (d) {
                d.month = selectedMonth;
                d.year = selectedYear;
                d.status = selectedStatus;
            },
        },
        columns: [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title", searchable: true, orderable: false },
            { data: "short_description", searchable: true, orderable: false },
            { data: "updated_at", searchable: false, orderable: true },
            { data: "aksi", orderable: false, searchable: false },
        ],
        dom: "rt<'clear'>",
        drawCallback: function (settings) {
            let info = this.api().page.info();
            $(".table-show").text(info.start + 1);
            $(".table-end").text(info.end);
            $(".table-total").text(info.recordsTotal);
            $("#prevBtn").prop("disabled", info.page === 0);
            $("#nextBtn").prop("disabled", info.page === info.pages - 1);
            $("#customPageLength").val(info.length);
        },
    });

    function applyFilters() {
        let buttonText = "Bulan & Tahun";
        if (selectedMonth && selectedYear) {
            buttonText = `${selectedTextMonth} ${selectedYear}`;
        } else if (selectedMonth) {
            buttonText = selectedTextMonth;
        } else if (selectedYear) {
            buttonText = selectedYear;
        }
        $("#dateFilterText").text(buttonText);

        table.draw();
    }

    $(".month-item").on("click", function (e) {
        e.preventDefault();
        const $this = $(this);
        if ($this.hasClass("active")) {
            $this.removeClass("active");
            selectedMonth = "";
            selectedTextMonth = "";
        } else {
            $(".month-item").removeClass("active");
            $this.addClass("active");
            selectedMonth = $this.data("value");
            selectedTextMonth = $this.text();
        }
        applyFilters();
    });

    $(".year-item").on("click", function (e) {
        e.preventDefault();
        const $this = $(this);
        if ($this.hasClass("active")) {
            $this.removeClass("active");
            selectedYear = "";
        } else {
            $(".year-item").removeClass("active");
            $this.addClass("active");
            selectedYear = $this.data("value");
        }
        applyFilters();
    });

    $(".status-item").on("click", function (e) {
        e.preventDefault();
        selectedStatus = $(this).data("value");
        $("#statusFilterText").text($(this).text());
        table.draw();
    });

    $("#searchForm").on("submit", function (e) {
        e.preventDefault();
        table.search($("#searchInput").val()).draw();
    });

    $("#resetFilter").on("click", function () {
        selectedMonth = "";
        selectedTextMonth = "";
        selectedYear = "";
        selectedStatus = "";
        $("#searchInput").val("");

        $("#dateFilterText").text("Bulan & Tahun");
        $("#statusFilterText").text("Status");
        $(".month-item, .year-item").removeClass("active");

        table.search("").draw();
    });

    $("#prevBtn").on("click", function () {
        table.page("previous").draw("page");
    });
    $("#nextBtn").on("click", function () {
        table.page("next").draw("page");
    });
    $("#customPageLength").on("change", function () {
        table.page.len($(this).val()).draw();
    });

    // --- Open Create Modal ---
    $("body").on("click", "#addBtn", function (e) {
        e.preventDefault();
        const m = modalInstance("createModal");
        if (m) m.show();
    });

    // --- Fungsi Hapus Data (menggunakan ID) ---
    let deleteItemId;
    $("body").on("click", ".delete-btn", function () {
        const id = $(this).data("id");
        deleteItemId = id;
        const m = modalInstance("modalDelete");
        if (m) m.show();
    });

    $("body").on("click", "#buttonDelete", function () {
        $.ajax({
            // Deleting uses RESTful Pages resource
            url: "/pages/" + deleteItemId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                const m = modalInstance("modalDelete");
                if (m) m.hide();
                if ($("#notificationToast").length) {
                    $("#notificationToast .toast-body").text(
                        response.message || "Page berhasil dihapus."
                    );
                    $("#notificationToast")
                        .removeClass("text-bg-danger")
                        .addClass("text-bg-success");
                    showToast("notificationToast");
                }
                table.draw();
            },
            error: function (xhr) {
                const m = modalInstance("modalDelete");
                if (m) m.hide();
                const msg = xhr.status === 419 ? "Sesi berakhir. Muat ulang halaman." : (xhr.responseJSON?.message || "Gagal menghapus data.");
                if ($("#notificationToast").length) {
                    $("#notificationToast .toast-body").text(msg);
                    $("#notificationToast")
                        .removeClass("text-bg-success")
                        .addClass("text-bg-danger");
                    const t = toastInstance("notificationToast");
                    if (t) t.show();
                }
            }
        });
    });

    // --- Edit Modal ---
    let editItemId = null;
    $("body").on("click", ".edit-btn", function () {
        const btn = $(this);
        editItemId = btn.data("id");
        $("#editTitle").val(btn.data("title") || "");
        $("#editShortDescription").val(btn.data("short_description") || "");
        const m = modalInstance("editModal");
        if (m) m.show();
    });

    $("body").on("click", "#saveEditBtn", function () {
        if (!editItemId) return;
        const payload = {
            title: $("#editTitle").val(),
            short_description: $("#editShortDescription").val(),
            _method: "PUT",
        };
        $.ajax({
            url: "/pages/" + editItemId,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: payload,
            success: function (response) {
                const m = modalInstance("editModal");
                if (m) m.hide();
                if ($("#notificationToast").length) {
                    $("#notificationToast .toast-body").text(response.message || "Page berhasil diperbarui.");
                    $("#notificationToast")
                        .removeClass("text-bg-danger")
                        .addClass("text-bg-success");
                    const t = toastInstance("notificationToast");
                    if (t) t.show();
                }
                table.draw(false);
            },
            error: function (xhr) {
                const msg = xhr.status === 422 ? (xhr.responseJSON?.message || "Validasi gagal.") : (xhr.responseJSON?.message || "Gagal memperbarui data.");
                if ($("#notificationToast").length) {
                    $("#notificationToast .toast-body").text(msg);
                    $("#notificationToast")
                        .removeClass("text-bg-success")
                        .addClass("text-bg-danger");
                    showToast("notificationToast");
                }
            }
        });
    });

    // Modal detail tidak digunakan pada Page Builder list; tombol preview langsung dari kolom 'aksi'
});
