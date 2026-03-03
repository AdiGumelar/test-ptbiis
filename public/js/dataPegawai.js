$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//Lihat Pegawai
function showData() {
    $.get("/dataPegawai", function (response) {
        let rows = "";
        response.data.forEach((pegawai) => {
            rows += `
                            <tr>
                                <td>${pegawai.employee_code}</td>
                                <td>
                                    <img
                                        src="${
                                            pegawai.photo &&
                                            pegawai.photo.trim() !== ""
                                                ? `/storage/${pegawai.photo}`
                                                : `https://ui-avatars.com/api/?name=${encodeURIComponent(pegawai.name)}&background=0D8ABC&color=fff`
                                        }"
                                        class="rounded-circle"
                                        width="40"
                                        height="40"
                                    />
                                </td>
                                <td>${pegawai.name}</td>
                                <td>${pegawai.email}</td>
                                <td>${pegawai.phone}</td>
                                <td>${pegawai.positions.name}</td>
                                <td>${pegawai.hire_date}</td>
                                <td>
                                    <span class="badge ${pegawai.status === "active" ? "bg-success" : "bg-danger"}">
                                        ${pegawai.status}
                                    </span></td>
                                <td>
                                    <!-- View -->
                                    <button
                                        class="btn btn-sm btn-info text-white viewBtn"
                                        onclick="detailPegawai(${pegawai.id})"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <button
                                        class="btn btn-sm btn-warning"
                                        onclick="editPegawaiShow(${pegawai.id})"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Delete -->
                                    <button
                                        class="btn btn-sm btn-danger"
                                        onclick="hapusPegawai(${pegawai.id})"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
        });
        if ($.fn.DataTable.isDataTable("#employeeTable")) {
            $("#employeeTable").DataTable().destroy();
        }

        $("#dataPegawai").html(rows);

        $("#employeeTable").DataTable();
    });
}

showData();

//Tambah Pegawai
$("#tambahPegawai").submit(function (e) {
    e.preventDefault();

    let isValid = true;

    // Hapus error lama
    $(".form-control, .form-select").removeClass("is-invalid");
    $(".invalid-feedback").text("");

    // Ambil semua field kecuali photo
    let requiredFields = [
        "employee_code",
        "name",
        "email",
        "phone",
        "gender",
        "birth_place",
        "birth_date",
        "hire_date",
        "positions_id",
        "salary",
        "status",
    ];

    requiredFields.forEach(function (field) {
        let value = $(`#${field}`).val();

        if (!value || value.trim() === "") {
            isValid = false;
            $(`#${field}`).addClass("is-invalid");
            $(`#error-${field}`).text("Wajib diisi!");
        }
    });

    // Validasi email
    let email = $("#email").val();
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email && !emailPattern.test(email)) {
        isValid = false;
        $("#email").addClass("is-invalid");
        $("#error-email").text("Format email tidak valid");
    }

    if (!isValid) {
        return;
    }

    let formData = new FormData();
    formData.append("employee_code", $("#employee_code").val());
    formData.append("name", $("#name").val());
    formData.append("email", $("#email").val());
    formData.append("phone", $("#phone").val());
    formData.append("gender", $("#gender").val());
    formData.append("birth_place", $("#birth_place").val());
    formData.append("birth_date", $("#birth_date").val());
    formData.append("hire_date", $("#hire_date").val());
    formData.append("positions_id", $("#positions_id").val());
    formData.append("salary", $("#salary").val());
    formData.append("status", $("#status").val());

    if ($("#photo")[0].files[0]) {
        formData.append("photo", $("#photo")[0].files[0]);
    }

    $.ajax({
        url: "/tambahPegawai",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            Swal.fire({
                title: "Menyimpan...",
                text: "Sedang memproses data",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },
        success: function (response) {
            if (response.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
                $("#tambahPegawai")[0].reset();
                $("#tambahModal").modal("hide");
                showData();
            }
        },
        error: function (xhr) {
            Swal.close();
            $(".form-control, .form-select").removeClass("is-invalid");
            $(".invalid-feedback").text("");

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                for (let field in errors) {
                    let customMessage = "";

                    // Custom pesan sendiri
                    if (field === "employee_code") {
                        customMessage = "Kode pegawai sudah digunakan!";
                    } else if (field === "email") {
                        customMessage = "Email sudah terdaftar!";
                    } else if (field === "salary") {
                        customMessage = "Gaji harus berupa angka!";
                    }

                    $(`#${field}`).addClass("is-invalid");
                    $(`#error-${field}`).text(customMessage);
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan",
                    text: "Server Error",
                });
            }
        },
    });
});

//Hapus Pegawai
function hapusPegawai(id) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Menghapus...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                url: `/hapusPegawai/${id}`,
                type: "DELETE",
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    showData();
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan saat menghapus data",
                    });
                },
            });
        }
    });
}

//View Detail
function detailPegawai(id) {
    $.get(`/dataPegawai/${id}`, function (response) {
        let dataPegawai = response.data;
        let avatarUrl = dataPegawai.photo
            ? `/storage/${dataPegawai.photo}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(dataPegawai.name)}&background=0D8ABC&color=fff`;

        $("#detailPhoto").attr("src", avatarUrl);
        $("#detailName").text(dataPegawai.name);

        // Status
        if (dataPegawai.status == "active") {
            $("#detailStatus")
                .removeClass()
                .addClass("badge bg-success")
                .text("Active");
        } else {
            $("#detailStatus")
                .removeClass()
                .addClass("badge bg-danger")
                .text("Inactive");
        }

        $("#d_employeeCode").text(dataPegawai.employee_code);
        $("#d_email").text(dataPegawai.email);
        $("#d_phone").text(dataPegawai.phone);
        $("#d_gender").text(dataPegawai.gender);
        $("#d_birth").text(
            `${dataPegawai.birth_place}, ${dataPegawai.birth_date}`,
        );
        $("#d_position").text(dataPegawai.positions?.name ?? "-");
        $("#d_hire").text(dataPegawai.hire_date);
        $("#d_salary").text(`${formatRupiah(dataPegawai.salary)}`);
        $("#detailModal").modal("show");
    });
}

function editPegawaiShow(id) {
    $.get(`/dataPegawai/${id}`, function (response) {
        let dataPegawai = response.data;
        $("#editId").val(dataPegawai.id);
        $("#editEmployeeCode").val(dataPegawai.employee_code);
        $("#editName").val(dataPegawai.name);
        $("#editEmail").val(dataPegawai.email);
        $("#editPhone").val(dataPegawai.phone);
        $("#editGender").val(dataPegawai.gender);
        $("#editBirthPlace").val(dataPegawai.birth_place);
        $("#editBirthDate").val(dataPegawai.birth_date);
        $("#editHireDate").val(dataPegawai.hire_date);
        $("#editPositions").val(dataPegawai.positions_id).trigger("change");
        $("#editSalary").val(dataPegawai.salary);
        $("#editStatus").val(dataPegawai.status);
        $("#editModal").modal("show");
    });
}

$("#editPegawai").submit(function (e) {
    e.preventDefault();

    let isValid = true;

    // Hapus error lama
    $(".form-control, .form-select").removeClass("is-invalid");
    $(".invalid-feedback").text("");

    // Ambil semua field kecuali photo
    let requiredFields = [
        "editEmployeeCode",
        "editName",
        "editEmail",
        "editPhone",
        "editGender",
        "editBirthPlace",
        "editBirthDate",
        "editHireDate",
        "editPositions",
        "editSalary",
        "editStatus",
    ];

    requiredFields.forEach(function (field) {
        let value = $(`#${field}`).val();

        if (!value || value.trim() === "") {
            isValid = false;
            $(`#${field}`).addClass("is-invalid");
            $(`#error-${field}`).text("Wajib diisi!");
        }
    });

    // Validasi email
    let email = $("#editEmail").val();
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email && !emailPattern.test(email)) {
        isValid = false;
        $("#editEmail").addClass("is-invalid");
        $("#error-editEmail").text("Format email tidak valid");
    }

    if (!isValid) {
        return;
    }

    let id = $("#editId").val();

    let formData = new FormData();
    formData.append("employee_code", $("#editEmployeeCode").val());
    formData.append("name", $("#editName").val());
    formData.append("email", $("#editEmail").val());
    formData.append("phone", $("#editPhone").val());
    formData.append("gender", $("#editGender").val());
    formData.append("birth_place", $("#editBirthPlace").val());
    formData.append("birth_date", $("#editBirthDate").val());
    formData.append("hire_date", $("#editHireDate").val());
    formData.append("positions_id", $("#editPositions").val());
    formData.append("salary", $("#editSalary").val());
    formData.append("status", $("#editStatus").val());

    if ($("#editPhoto")[0].files[0]) {
        formData.append("photo", $("#editPhoto")[0].files[0]);
    }

    $.ajax({
        url: `/editPegawai/${id}`,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            Swal.fire({
                title: "Menyimpan...",
                text: "Sedang memproses data",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },

        success: function (response) {
            if (response.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false,
                });

                $("#editModal").modal("hide");
                showData();
            }
        },

        error: function (xhr) {
            Swal.close();
            $(".form-control, .form-select").removeClass("is-invalid");
            $(".invalid-feedback").text("");

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                for (let field in errors) {
                    let customMessage = "";

                    if (field === "employee_code") {
                        customMessage = "Kode pegawai sudah digunakan!";
                        $(`#editEmployeeCode`).addClass("is-invalid");
                        $(`#error-editEmployeeCode`).text(customMessage);
                    } else if (field === "email") {
                        customMessage = "Email sudah terdaftar!";
                        $(`#editEmail`).addClass("is-invalid");
                        $(`#error-editEmail`).text(customMessage);
                    } else if (field === "salary") {
                        customMessage = "Gaji harus berupa angka!";
                        $(`#editSalary`).addClass("is-invalid");
                        $(`#error-editSalary`).text(customMessage);
                    }
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Terjadi Kesalahan",
                    text: "Server Error",
                });
            }
        },
    });
});

function formatRupiah(angka) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(angka);
}

function showTambahPegawaiModal() {
    $("#tambahModal").modal("show");
}

$(document).ready(function () {
    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: "YYYY-MM-DD",
        },
    });

    $(".selectgender").select2({
        dropdownParent: $("#tambahModal"),
    });

    $(".selectpositions").select2({
        dropdownParent: $("#tambahModal"),
    });

    $(".selectstatus").select2({
        dropdownParent: $("#tambahModal"),
    });
});
