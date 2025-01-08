<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Kelas</h4>
                    <br>
                    <button type="button" class="btn btn-outline-primary kirim-surat" data-bs-toggle="modal" data-bs-target="#folderModal">
                        Buat Kelas
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Nama Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $sm)
                            <tr>
                                <td>{{ $sm->nama_kelas }}</td>
                                <td>{{ $sm->nama_jurusan }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary edit-barang"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id_kelas="{{ $sm->id_kelas }}"
                                        data-id_jurusan="{{ $sm->id_jurusan }}"
                                        data-nama_kelas="{{ $sm->nama_kelas }}"
                                        data-nama_jurusan="{{ $sm->nama_jurusan }}">
                                        Detail
                                    </button>
                                    <form action="{{ route('kelas.destroy', $sm->id_kelas) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Hapus</button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                            <th>Nama Kelas</th>
                                <th>Nama Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk membuat pengumuman -->
<div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="folderModalLabel">Buat Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buat_kelas') }}" method="POST" id="createForm">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk edit pengumuman -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <!-- Ganti GET dengan POST -->
                    <input type="hidden" name="id_kelas" id="edit-id_kelas">
                    <div class="mb-3">
                        <label for="edit-nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="edit-nama_kelas" name="nama_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nama_jurusan" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="edit-nama_jurusan" name="nama_jurusan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript untuk Mengisi Data di Modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   $(document).ready(function() {
    // Fungsi untuk membuka modal dan mengisi form
    function openModal() {
        // Reset form sebelum membuka modal
        $('#editForm')[0].reset();
    
        // Buka modal
        $('#folderModal').modal('show');
    }

    // Tangani submit form
    $('#createForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form submit biasa

        // Ambil data dari form
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("buat_kelas") }}', // Sesuaikan dengan route yang benar
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Tampilkan pesan sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pengumuman berhasil dibuat.',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Tutup modal
                $('#folderModal').modal('hide');

                // Refresh tabel atau data lain
                refreshData();
            },
            error: function(xhr) {
                // Tangani error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                });

                // Tampilkan pesan error dari server jika ada
                console.log(xhr.responseText);
            }
        });
    });

    // Fungsi untuk refresh data
    function refreshData() {
        // Contoh jika Anda menggunakan DataTables
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().ajax.reload();
        } else {
            // Jika tabel statis, Anda bisa memuat ulang halaman
            location.reload();
        }
    }

    // Contoh cara membuka modal (bisa dipasang di tombol atau event lain)
    $('#btnTambahPengumuman').on('click', function() {
        openModal();
    });
});
</script>
<script>
   
    $(document).on('click', '.edit-barang', function() {
        // Ambil data dari atribut tombol Edit
        let id_jurusan = $(this).data('id_jurusan');
        let id_kelas = $(this).data('id_kelas');
        let nama_jurusan = $(this).data('nama_jurusan');
        let nama_kelas = $(this).data('nama_kelas');

        // Set nilai form action untuk edit
        $('#editForm').attr('action', '{{ route("kelas.update", ":id") }}'.replace(':id', id_kelas));

        // Isi nilai input di modal edit dengan id yang benar
        $('#edit-nama_jurusan').val(nama_jurusan);
        $('#edit-nama_kelas').val(nama_kelas);
    });

</script>