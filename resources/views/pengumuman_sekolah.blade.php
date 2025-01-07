<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Pengumuman Sekolah</h4>
                    <br>
                    <button type="button" class="btn btn-outline-primary kirim-surat" data-bs-toggle="modal" data-bs-target="#folderModal">
                        Buat Pengumuman
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>Nama Pembuat</th>
                                <th>Judul Pengumuman</th>
                                <th>Tanggal Buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengumuman as $sm)
                            <tr>
                                <td>{{ $sm->username }}</td>
                                <td>{{ $sm->judul_pengumuman_sekolah }}</td>
                                <td>{{ $sm->tgl_buat }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary edit-barang"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id_pengumuman_sekolah="{{ $sm->id_pengumuman_sekolah }}"
                                        data-isi_pengumuman="{{ $sm->isi_pengumuman }}"
                                         data-judul_pengumuman_sekolah="{{ $sm->judul_pengumuman_sekolah }}">
                                        Detail
                                    </button>


                                    <form action="{{ route('pengumuman_sekolah.destroy', $sm->id_pengumuman_sekolah) }}" method="POST" style="display:inline;">
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
                            <th>Nama Pembuat</th>
                                <th>Judul Pengumuman</th>
                                <th>Tanggal Buat</th>
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
                <h5 class="modal-title" id="folderModalLabel">Buat Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buat_pengumuman') }}" method="POST" id="createForm">
                    @csrf
                    <div class="mb-3">
                        <label for="judul_pengumuman_sekolah" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="judul_pengumuman_sekolah" name="judul_pengumuman_sekolah" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi_pengumuman" class="form-label">Isi Pengumuman</label>
                        <input type="text" class="form-control" id="isi_pengumuman" name="isi_pengumuman" required>
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
                <h5 class="modal-title" id="editModalLabel">Edit Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <!-- Ganti GET dengan POST -->
                    <input type="hidden" name="id_pengumuman_sekolah" id="edit-id_pengumuman_sekolah">
                    <div class="mb-3">
                        <label for="edit-judul_pengumuman_sekolah" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="edit-judul_pengumuman_sekolah" name="judul_pengumuman_sekolah" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-isi_pengumuman" class="form-label">Isi Pengumuman</label>
                        <input type="text" class="form-control" id="edit-isi_pengumuman" name="isi_pengumuman" required>
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
        
        // Atur tanggal otomatis hari ini
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#tgl_buat').val(today);

        // Buka modal
        $('#folderModal').modal('show');
    }

    // Tangani submit form
    $('#createForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form submit biasa

        // Ambil data dari form
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("buat_pengumuman") }}', // Sesuaikan dengan route yang benar
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
        let id_pengumuman_sekolah = $(this).data('id_pengumuman_sekolah');
        let judul_pengumuman_sekolah = $(this).data('judul_pengumuman_sekolah');
        let isi_pengumuman = $(this).data('isi_pengumuman');

        // Set nilai form action untuk edit
        $('#editForm').attr('action', '{{ route("pengumuman_sekolah.update", ":id") }}'.replace(':id', id_pengumuman_sekolah));

        // Isi nilai input di modal edit dengan id yang benar
        $('#edit-judul_pengumuman_sekolah').val(judul_pengumuman_sekolah);
        $('#edit-isi_pengumuman').val(isi_pengumuman);
    });

</script>