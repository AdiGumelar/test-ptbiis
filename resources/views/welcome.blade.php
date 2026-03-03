<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Dashboard CRUD Pegawai</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Bootstrap 5 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />

        <!-- Google Font Poppins -->
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        />

        <!-- DateRangePicker -->
        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
        />

        <!-- Select2 -->
        <link
            href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet"
        />

        <!-- Datatables -->
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
        />

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f6f9;
            }

            .sidebar {
                background: linear-gradient(180deg, #4e73df, #224abe);
                color: white;
                padding-top: 20px;
            }

            .sidebar a {
                color: white;
                text-decoration: none;
                padding: 10px 20px;
                display: block;
                border-radius: 8px;
                margin: 5px 10px;
                transition: 0.3s;
            }

            .sidebar a:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }

            .card-dashboard {
                border: none;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            }

            .table thead {
                background-color: #4e73df;
                color: white;
            }

            .btn-primary {
                background-color: #4e73df;
                border: none;
            }

            .btn-primary:hover {
                background-color: #2e59d9;
            }

            .navbar {
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }

            .select2-container {
                width: 100% !important;
            }

            @media (max-width: 768px) {
                .sidebar {
                    height: auto;
                }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 sidebar">
                    <h4 class="text-center fw-bold mb-4">MyDashboard</h4>

                    <a href="#">
                        <i class="bi bi-people me-2"></i>
                        Data Pegawai
                    </a>
                </div>

                <!-- Content -->
                <div class="col-md-9 col-lg-10 p-4">
                    <!-- Navbar -->
                    <nav class="navbar bg-white rounded-3 mb-4 p-3">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h5">
                                CRUD Data Pegawai
                            </span>
                        </div>
                    </nav>

                    <!-- Card -->
                    <div class="card card-dashboard p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-semibold">Daftar Pegawai</h5>
                            <button
                                class="btn btn-primary"
                                onclick="showTambahPegawaiModal()"
                            >
                                <i class="bi bi-plus-circle"></i>
                                Tambah Pegawai
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table
                                class="table align-middle table-hover"
                                id="employeeTable"
                            >
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>HP</th>
                                        <th>Jabatan</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dataPegawai"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-4">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Pegawai</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <form id="tambahPegawai">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Kode Pegawai
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="EMP001"
                                        id="employee_code"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-employee_code"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-name"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-email"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No HP</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="phone"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-phone"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jenis Kelamin
                                    </label>
                                    <select
                                        class="form-select selectgender"
                                        id="gender"
                                    >
                                        <option>Pilih</option>
                                        <option value="laki-laki">
                                            Laki-laki
                                        </option>
                                        <option value="perempuan">
                                            Perempuan
                                        </option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-gender"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tempat Lahir
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="birth_place"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-birth_place"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Lahir
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control datepicker"
                                        id="birth_date"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-birth_date"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Masuk
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control datepicker"
                                        id="hire_date"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-hire_place"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select
                                        class="form-select selectpositions"
                                        id="positions_id"
                                    >
                                        <option value="1">
                                            Backend Developer
                                        </option>
                                        <option value="2">
                                            Frontend Developer
                                        </option>
                                        <option value="3">Manager</option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-positions_id"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="salary"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-salary"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select
                                        class="form-select selectstatus"
                                        id="status"
                                    >
                                        <option value="active">Active</option>
                                        <option value="inactive">
                                            Inactive
                                        </option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-birth_place"
                                    ></div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Upload Foto
                                    </label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="photo"
                                    />
                                </div>

                                <div class="col-12">
                                    <button
                                        class="btn btn-primary w-100"
                                        type="submit"
                                    >
                                        Simpan Data Pegawai
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-4">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Detail Pegawai</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <img
                                    id="detailPhoto"
                                    class="rounded-circle mb-3"
                                    width="120"
                                    height="120"
                                />
                                <h5 class="fw-semibold" id="detailName">
                                    Andi Saputra
                                </h5>
                                <span
                                    class="badge bg-success"
                                    id="detailStatus"
                                >
                                    Active
                                </span>
                            </div>

                            <div class="col-md-8">
                                <div class="px-2">
                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">
                                            Kode Pegawai
                                        </span>
                                        <span
                                            class="fw-semibold"
                                            id="d_id"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">Email</span>
                                        <span
                                            class="fw-semibold"
                                            id="d_email"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">No HP</span>
                                        <span
                                            class="fw-semibold"
                                            id="d_phone"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">
                                            Jenis Kelamin
                                        </span>
                                        <span
                                            class="fw-semibold"
                                            id="d_gender"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">
                                            Tempat, Tanggal Lahir
                                        </span>
                                        <span
                                            class="fw-semibold text-end"
                                            id="d_birth"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">Jabatan</span>
                                        <span
                                            class="fw-semibold text-primary"
                                            id="d_position"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between border-bottom py-2"
                                    >
                                        <span class="text-muted">
                                            Tanggal Masuk
                                        </span>
                                        <span
                                            class="fw-semibold"
                                            id="d_hire"
                                        ></span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between py-2"
                                    >
                                        <span class="text-muted">Gaji</span>
                                        <span
                                            class="fw-bold text-success"
                                            id="d_salary"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-4">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Update Pegawai</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <form id="editPegawai">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Kode Pegawai
                                    </label>
                                    <input
                                        id="editEmployeeCode"
                                        type="text"
                                        class="form-control"
                                        value="EMP001"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editEmployeeCode"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input
                                        id="editName"
                                        type="text"
                                        class="form-control"
                                        value="Andi Saputra"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editName"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        id="editEmail"
                                        type="email"
                                        class="form-control"
                                        value="andi@email.com"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editEmail"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No HP</label>
                                    <input
                                        id="editPhone"
                                        type="text"
                                        class="form-control"
                                        value="08123456789"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editPhone"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Jenis Kelamin
                                    </label>
                                    <select class="form-select" id="editGender">
                                        <option value="laki-laki" selected>
                                            Laki-laki
                                        </option>
                                        <option value="perempuan">
                                            Perempuan
                                        </option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-editGender"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tempat Lahir
                                    </label>
                                    <input
                                        id="editBirthPlace"
                                        type="text"
                                        class="form-control"
                                        value="Jakarta"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editBirthPlace"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Lahir
                                    </label>
                                    <input
                                        id="editBirthDate"
                                        type="text"
                                        class="form-control datepicker"
                                        value="12-01-1998"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editBirthDate"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Tanggal Masuk
                                    </label>
                                    <input
                                        id="editHireDate"
                                        type="text"
                                        class="form-control datepicker"
                                        value="10-01-2024"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editHireDate"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select
                                        class="form-select select2"
                                        id="editPositions"
                                    >
                                        <option value="1">
                                            Backend Developer
                                        </option>
                                        <option value="2">
                                            Frontend Developer
                                        </option>
                                        <option value="3">Manager</option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-editPositions"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji</label>
                                    <input
                                        id="editSalary"
                                        type="number"
                                        class="form-control"
                                        value="8000000"
                                    />
                                    <div
                                        class="invalid-feedback"
                                        id="error-editSalary"
                                    ></div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="editStatus">
                                        <option value="active" selected>
                                            Active
                                        </option>
                                        <option value="inactive">
                                            Inactive
                                        </option>
                                    </select>
                                    <div
                                        class="invalid-feedback"
                                        id="error-editStatus"
                                    ></div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">
                                        Upload Foto
                                    </label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="editPhoto"
                                    />
                                </div>

                                <div class="col-12">
                                    <button
                                        class="btn btn-warning w-100"
                                        type="submit"
                                    >
                                        Update Data Pegawai
                                    </button>
                                </div>
                                <input type="hidden" id="editId" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DateRangePicker -->
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Datatables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <!-- Sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset("js/dataPegawai.js") }}"></script>
    </body>
</html>
