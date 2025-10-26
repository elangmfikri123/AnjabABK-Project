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
                                        <h5>Manage Sekolah</h5>
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
                                                        <th class="text-center">NPSN</th>
                                                        <th class="text-center">Nama Sekolah</th>
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
                                <h5 class="modal-title" id="addUserModalLabel">Tambah Sekolah</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addSekolahForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="vnpsn_sekolah">NPSN Sekolahan</label>
                                        <input type="text" class="form-control" id="vnpsn_sekolah" name="vnpsn_sekolah"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vnama_sekolah">Nama Sekolahan</label>
                                        <input type="text" class="form-control" id="vnama_sekolah" name="vnama_sekolah"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatans_id">Asal Kecamatan</label>
                                        <select class="form-control" id="kecamatans_id" name="kecamatans_id" required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @foreach ($kecamatans as $k)
                                                <option value="{{ $k->id }}">{{ $k->vnama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Sekolah -->
                <div class="modal fade" id="editSekolahModal" tabindex="-1" role="dialog"
                    aria-labelledby="editSekolahModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="editSekolahForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id" name="edit_id">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSekolahModalLabel">Edit Sekolah</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <!-- Modal body (dibungkus rapi di sini) -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="vnpsn_sekolah">NPSN Sekolahan</label>
                                        <input type="text" class="form-control" id="vnpsn_sekolah" name="vnpsn_sekolah"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vnama_sekolah">Nama Sekolahan</label>
                                        <input type="text" class="form-control" id="vnama_sekolah" name="vnama_sekolah"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatans_id">Asal Kecamatan</label>
                                        <select class="form-control" id="kecamatans_id" name="kecamatans_id" required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @foreach ($kecamatans as $k)
                                                <option value="{{ $k->id }}">{{ $k->vnama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
                ajax: '{{ url('/get-sekolah/data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'vnpsn_sekolah',
                        name: 'vnpsn_sekolah'
                    },
                    {
                        data: 'vnama_sekolah',
                        name: 'vnama_sekolah'
                    },
                    {
                        data: 'kecamatan',
                        name: 'kecamatan'
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
            $('#addSekolahForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('/sekolah/store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Sekolah berhasil ditambahkan!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            $('#addSekolahForm')[0].reset();
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

                $.get('/sekolah/edit/' + id, function(response) {
                    let data = response.data;

                    // Isi data ke form modal
                    $('#edit_id').val(data.id);
                    $('#editSekolahModal #vnpsn_sekolah').val(data.vnpsn_sekolah);
                    $('#editSekolahModal #vnama_sekolah').val(data.vnama_sekolah);
                    $('#editSekolahModal #kecamatans_id').val(data.kecamatans_id);

                    // Tampilkan modal edit
                    $('#editSekolahModal').modal('show');
                });
            });

            $('#editSekolahForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let formData = $(this).serialize();

                $.ajax({
                    url: '/sekolah/update/' + id,
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        $('#editSekolahModal').modal('hide');
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
