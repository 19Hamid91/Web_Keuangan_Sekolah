@extends('layout')
@section('css')
<!-- Tambahkan CSS khusus di sini jika diperlukan -->
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Backup Management</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Your Backups</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row mb-2">
                                {{-- <div class="col-sm-6 col-md-4 col-lg-2">
                                    <button id="backup-button" class="btn btn-primary" onclick="backupDatabase()">Backup Now</button>
                                </div>
                                <div class="col-sm-6 col-md-8 col-lg-10 text-right">
                                    <div id="backup-status"></div>
                                </div> --}}
                            </div>
                            <table id="backupTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>File Name</th>
                                        <th>Size (MB)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="backup-files">
                                    <!-- Daftar file backup akan ditambahkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal for Confirm Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Backup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this backup?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!-- Tambahkan jQuery dan Bootstrap JS untuk interaktivitas -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function backupDatabase() {
        $('#backup-status').html('<div class="alert alert-info">Backup sedang diproses...</div>');

        $.ajax({
            url: '{{ route("backup.run", ["instansi" => $instansi]) }}',
            type: 'GET',
            success: function(response) {
                $('#backup-status').html('<div class="alert alert-success">Backup selesai! File disimpan di ' + response.file + '</div>');
                loadBackupFiles();
            },
            error: function(xhr) {
                $('#backup-status').html('<div class="alert alert-danger">Gagal melakukan backup. Coba lagi nanti.</div>');
            }
        });
    }

    function loadBackupFiles() {
        $('#backup-files').html('');

        $.ajax({
            url: '{{ route("backup.list", ["instansi" => $instansi]) }}',
            type: 'GET',
            success: function(response) {
                console.log(response)
                response.files.forEach((file, index) => {
                    $('#backup-files').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${file.name}</td>
                            <td>${file.size}</td>
                            <td>
                                <a href="${file.download_url}" class="btn btn-success" download>Download</a>
                                <button class="btn btn-danger" data-filename="${file.name}" onclick="confirmDelete(this)">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr) {
                $('#backup-status').html('<div class="alert alert-danger">Gagal memuat daftar file backup.</div>');
            }
        });
    }

    function confirmDelete(button) {
        const filename = $(button).data('filename');
        $('#confirmDelete').data('filename', filename);
        $('#deleteModal').modal('show');
    }

    $('#confirmDelete').on('click', function() {
        const filename = $(this).data('filename');
        deleteBackup(filename);
        $('#deleteModal').modal('hide');
    });

    function deleteBackup(filename) {
        $.ajax({
            url: '{{ route("backup.delete", ["instansi" => $instansi]) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                filename: filename
            },
            success: function(response) {
                $('#backup-status').html('<div class="alert alert-success">' + response.message + '</div>');
                loadBackupFiles();
            },
            error: function(xhr) {
                $('#backup-status').html('<div class="alert alert-danger">Gagal menghapus file backup.</div>');
            }
        });
    }

    $(document).ready(function() {
        loadBackupFiles();
    });
</script>
@endsection
