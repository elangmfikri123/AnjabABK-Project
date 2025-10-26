@extends('layout.template')
@section('title', 'Manage Kecamatan - Admin')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Manage Kecamatan</h5>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#addUserModal">
                                            <i class="icofont icofont-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="myTable"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th class="text-center">Kecamatan</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah Kecamatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addKecamatan">
                                    @csrf
                                    <div class="form-group">
                                        <label for="vnama_kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="vnama_kecamatan" name="vnama_kecamatan" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Main Dealer -->
                <div class="modal fade" id="editKecamatan" tabindex="-1" role="dialog"
                    aria-labelledby="editKecamatanLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="editKecamatanForm">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kecamatan</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="edit_kecamatan" name="vnama_kecamatan" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/get-kecamatan/data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'vnama_kecamatan',
                        name: 'vnama_kecamatan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
            $('#addKecamatan').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('/kecamatan/store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kecamatan berhasil ditambahkan!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            $('#addKecamatan')[0].reset();
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan data.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            let table = $('#myTable').DataTable();

            $(document).on('click', '.edit-button', function() {
                let id = $(this).data('id');
                $.get('/kecamatan/edit/' + id, function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_kecamatan').val(data.vnama_kecamatan);
                    $('#editKecamatan').modal('show');
                });
            });

            $('#editKecamatanForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let formData = $(this).serialize();

                $.ajax({
                    url: '/kecamatan/update/' + id,
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        $('#editKecamatan').modal('hide');
                        Swal.fire('Berhasil!', res.success, 'success');
                        table.ajax.reload();
                    },
                    error: function(err) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat update.', 'error');
                    }
                });
            });


            // Konfirmasi hapus data
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var actionUrl = form.attr('action');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'DELETE',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Berhasil Dihapus!', response.success,
                                    'success').then(
                                    () => {
                                        form.closest('tr').remove();
                                    });
                            },
                            error: function() {
                                Swal.fire('Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
