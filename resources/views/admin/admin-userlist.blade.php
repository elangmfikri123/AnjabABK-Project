@extends('layout.template')
@section('title', 'User List')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Ajax data source (Arrays) table start -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>User List</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#addUserModal"><i class="icofont icofont-plus"></i> Tambah</button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 20px;">No</th>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Username</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center">Role</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#myTable').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: '/get-user/data',
                                                        columns: [{
                                                                data: 'DT_RowIndex',
                                                                name: 'DT_RowIndex',
                                                                orderable: false,
                                                                searchable: false
                                                            },
                                                            {
                                                                data: 'nama',
                                                                name: 'nama'
                                                            },
                                                            {
                                                                data: 'username',
                                                                name: 'username'
                                                            },
                                                            {
                                                                data: 'email',
                                                                name: 'email'
                                                            },
                                                            {
                                                                data: 'role',
                                                                name: 'role'
                                                            },
                                                            {
                                                                data: 'status',
                                                                name: 'status',
                                                                className: 'text-center'
                                                            },
                                                            {
                                                                data: 'action',
                                                                name: 'action',
                                                                orderable: false,
                                                                searchable: false,
                                                                className: 'text-center'
                                                            },
                                                        ]
                                                    });
                                                });
                                            </script>
                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                            <script>
                                                function handleStatusClick(userId, element) {
                                                    Swal.fire({
                                                        title: 'Force Logout?',
                                                        text: "Apakah Anda yakin ingin memaksa logout user ini?",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#01a9ac',
                                                        confirmButtonText: 'Ya, Logout',
                                                        cancelButtonText: 'Cancel'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $.ajax({
                                                                url: '/force-logout/' + userId,
                                                                type: 'POST',
                                                                data: {
                                                                    _token: '{{ csrf_token() }}'
                                                                },
                                                                success: function(response) {
                                                                    if (response.success) {
                                                                        $(element).removeClass('bg-success').addClass('bg-secondary');
                                                                        $(element).text('Offline');

                                                                        Swal.fire(
                                                                            'Berhasil!',
                                                                            response.message,
                                                                            'success'
                                                                        );
                                                                    }
                                                                },
                                                                error: function(xhr) {
                                                                    Swal.fire(
                                                                        'Error!',
                                                                        xhr.responseJSON.message || 'Terjadi kesalahan',
                                                                        'error'
                                                                    );
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Error container -->
                                <div id="addUserError" class="alert alert-danger" style="display: none;"></div>

                                <form id="createUserForm" action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control" required
                                            onchange="toggleForm()">
                                            <option value="Admin">Admin</option>
                                            <option value="Operator">Operator</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="sekolahField" style="display:none">
                                        <label>NPSN (Sekolahan)</label>
                                        <select class="form-control select2-sekolah" name="daftar_sekolahs_id">
                                            <option value="">Pilih Sekolah</option>
                                            @foreach ($sekolahs as $s)
                                                <option value="{{ $s->id }}">{{ $s->vnpsn_sekolah }} -
                                                    {{ $s->vnama_sekolah }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Detail User -->
                <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Nama</th>
                                                <td id="detail_nama"></td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td id="detail_username"></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td id="detail_email"></td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td id="detail_role"></td>
                                            </tr>
                                            <tr>
                                                <th>Operator Sekolah</th>
                                                <td id="detail_sekolah"></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td id="detail_status"></td>
                                            </tr>
                                            <tr>
                                                <th>Dibuat Pada</th>
                                                <td id="detail_created"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="editUserForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="editUserError" class="alert alert-danger" style="display: none;"></div>

                                    <form id="editUserForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="user_id" id="edit_user_id">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" id="edit_nama" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" id="edit_email" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" id="edit_username"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control"
                                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                                <span class="input-group-addon" onclick="togglePassword()"
                                                    style="cursor: pointer;">
                                                    <i class="ion-eye-disabled" id="eye-icon"></i>
                                                </span>
                                            </div>
                                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah
                                                password</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" id="edit_role" class="form-control"
                                                onchange="toggleEditFields()">
                                                <option value="Admin">Admin</option>
                                                <option value="Operator">Operator</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="edit_sekolah_field" style="display:none;">
                                            <label>NPSN (Sekolahan)</label>
                                            <select class="form-control select2-sekolahedit" name="daftar_sekolahs_id"
                                                id="edit_daftar_sekolahs_id">
                                                <option value="">Pilih Sekolah</option>
                                                @foreach ($sekolahs as $s)
                                                    <option value="{{ $s->id }}">{{ $s->vnpsn_sekolah }} -
                                                        {{ $s->vnama_sekolah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </div>
                        </form>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
                    function toggleForm() {
                        var role = $('#role').val();
                        if (role === 'Operator') $('#sekolahField').show();
                        else $('#sekolahField').hide();
                    }

                    $(document).ready(function() {
                        $('.select2-sekolah').select2({
                            placeholder: "Pilih Sekolah",
                            dropdownParent: $('#addUserModal')
                        });

                        $('#addUserModal').on('show.bs.modal', function() {
                            toggleForm();
                            $('.select2-sekolah').val(null).trigger('change');
                        });
                    });
                </script>

                <script>
                    $('#createUserForm').on('submit', function(e) {
                        e.preventDefault();
                        let form = $(this);
                        let url = form.attr('action');
                        let formData = form.serialize();
                        let btn = form.find('button[type="submit"]');
                        let errorDiv = $('#addUserError');

                        btn.prop('disabled', true).text('Menyimpan...');
                        errorDiv.hide().html('');

                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    $('#addUserModal').modal('hide');
                                    form[0].reset();
                                    $('#myTable').DataTable().ajax.reload(null, false);
                                } else {
                                    errorDiv.show().html(response.message || 'Terjadi kesalahan.');
                                }
                            },
                            error: function(xhr) {
                                let msg = 'Terjadi kesalahan.';
                                if (xhr.status === 422 && xhr.responseJSON.errors) {
                                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                }
                                errorDiv.show().html(msg);
                            },
                            complete: function() {
                                btn.prop('disabled', false).text('Simpan');
                            }
                        });
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        $('#editUserForm').on('submit', function(e) {
                            e.preventDefault();

                            var form = $(this);
                            var url = form.attr('action');
                            var formData = form.serialize();

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        $('#editUserModal').modal('hide');
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonColor: '#01a9ac',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $('#myTable').DataTable().ajax.reload();
                                            }
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    var errorMessage = xhr.responseJSON.message ||
                                        'Terjadi kesalahan saat memperbarui data';
                                    Swal.fire({
                                        title: 'Error!',
                                        text: errorMessage,
                                        icon: 'error',
                                        confirmButtonColor: '#01a9ac'
                                    });
                                }
                            });
                        });
                    });

                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const eyeIcon = document.getElementById('eye-icon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.classList.remove('ion-eye-disabled');
                            eyeIcon.classList.add('ion-eye');
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.classList.remove('ion-eye');
                            eyeIcon.classList.add('ion-eye-disabled');
                        }
                    }

                    function editUser(userId) {
                        $.ajax({
                            url: '/user/' + userId,
                            method: 'GET',
                            success: function(data) {
                                $('#edit_user_id').val(data.id);
                                $('#edit_nama').val(data.nama);
                                $('#edit_email').val(data.email);
                                $('#edit_username').val(data.username);
                                $('#edit_role').val(data.role);
                                $('#password').val('');
                                $('#edit_daftar_sekolahs_id').val(data.daftar_sekolahs_id);

                                if (data.role === 'Operator') {
                                    $('#edit_sekolah_field').show();
                                } else {
                                    $('#edit_sekolah_field').hide();
                                }

                                $('#editUserForm').attr('action', '/user/' + userId);
                                $('#editUserModal').modal('show');
                            }
                        });
                    }

                    function toggleEditFields() {
                        var role = $('#edit_role').val();
                        if (role === 'Operator') $('#edit_sekolah_field').show();
                        else $('#edit_sekolah_field').hide();
                    }
                    // Fungsi untuk menampilkan detail user
                    function showUserDetail(userId) {
                        $.ajax({
                            url: '/user/detail/' + userId,
                            method: 'GET',
                            success: function(data) {
                                $('#detail_nama').text(data.nama);
                                $('#detail_username').text(data.username);
                                $('#detail_email').text(data.email);
                                $('#detail_role').text(data.role);
                                $('#detail_sekolah').text(data.sekolah);
                                $('#detail_kodemd').text(data.npsn);
                                $('#detail_status').text(data.status);
                                $('#detail_created').text(data.created_at);
                                $('#detailUserModal').modal('show');
                            },
                            error: function() {
                                Swal.fire('Error!', 'Gagal memuat data user', 'error');
                            }
                        });
                    }
                    $(document).ready(function() {
                        $('.select2-sekolahedit').select2({
                            placeholder: "Pilih Sekolah",
                            dropdownParent: $('#editUserModal')
                        });

                        $('#editUserModal').on('shown.bs.modal', function() {
                            $('.select2-sekolahedit').select2({
                                placeholder: "Pilih Sekolah",
                                dropdownParent: $('#editUserModal')
                            });
                        });
                    });
                </script>
                <style>
                    .icon-black {
                        color: #444 !important;
                        font-size: 16px;
                    }

                    #eye-icon {
                        font-size: 16px;
                        color: #444;
                    }

                    input::-ms-reveal {
                        display: none;
                    }
                </style>
                <script>
                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const eyeIcon = document.getElementById('eye-icon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.classList.remove('ion-eye-disabled');
                            eyeIcon.classList.add('ion-eye');
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.classList.remove('ion-eye');
                            eyeIcon.classList.add('ion-eye-disabled');
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    </div>
@endsection
