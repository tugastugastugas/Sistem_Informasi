<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Pengumuman Terpilih</h4>
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
                                <th>Kepada</th>
                                <th>Tanggal Buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengumuman as $sm)
                            <tr>
                                <td>{{ $sm->username }}</td>
                                <td>{{ $sm->judul_pengumuman_guru }}</td>
                                <td>CONTOH</td>
                                <td>{{ $sm->tgl_buat }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary edit-barang"
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id_pengumuman_guru="{{ $sm->id_pengumuman_guru }}"
                                        data-isi_pengumuman="{{ $sm->isi_pengumuman }}"
                                         data-judul_pengumuman_guru="{{ $sm->judul_pengumuman_guru }}"
                                         data-file_pengumuman="{{ $sm->file_pengumuman_guru }}">
                                        Detail
                                    </button>


                                    <form action="{{ route('pengumuman_guru.destroy', $sm->id_pengumuman_guru) }}" method="POST" style="display:inline;">
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
                                <td>Kepada</td>
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
                <form action="{{ route('buat_pengumuman_guru') }}" method="POST" id="createForm">
                    @csrf
                    <div class="mb-3">
                        <label for="judul_pengumuman_guru" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="judul_pengumuman_guru" name="judul_pengumuman_guru" required>
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
                <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Ganti GET dengan POST -->
                    <input type="hidden" name="id_pengumuman_guru" id="edit-id_pengumuman_guru">
                    <div class="mb-3">
                        <label for="edit-judul_pengumuman_guru" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="edit-judul_pengumuman_guru" name="judul_pengumuman_guru" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-isi_pengumuman" class="form-label">Isi Pengumuman</label>
                        <input type="text" class="form-control" id="edit-isi_pengumuman" name="isi_pengumuman" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-file_pengumuman_guru" class="form-label">File Pengumuman</label>
                        <input type="file" class="form-control" id="edit-file_pengumuman_guru" name="file_pengumuman_guru">
                        <div id="file-download-container"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

                <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <div>
                            @foreach ($jurusan as $j)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="jurusan-{{ $j->id_jurusan }}" name="jurusan[]" value="{{ $j->id_jurusan }}">
                                    <label class="form-check-label" for="jurusan-{{ $j->id_jurusan }}">
                                        {{ $j->nama_jurusan }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <div>
                            @foreach ($kelas as $k)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="kelas-{{ $k->id_kelas }}" name="kelas[]" value="{{ $k->id_kelas }}">
                                    <label class="form-check-label" for="kelas-{{ $k->id_kelas }}">
                                        {{ $k->nama_kelas }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                <!-- Tombol Share -->
                <div class="mt-4">
                    <label class="form-label">Bagikan Pengumuman:</label>
                    <div class="d-flex gap-2">
                        <!-- Tombol Share ke Email -->
                        <a href="#" id="shareEmail" class="btn btn-secondary btn-sm" onclick="sendEmail()">
                            Share ke Email
                        </a>

                        <!-- Tombol Share ke WhatsApp -->
                        <a href="#" id="shareWhatsapp" class="btn btn-success btn-sm">
                                Share ke WhatsApp
                        </a>
                    </div>
                </div>

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
            url: '{{ route("buat_pengumuman_guru") }}', // Sesuaikan dengan route yang benar
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
        let id_pengumuman_guru = $(this).data('id_pengumuman_guru');
        let judul_pengumuman_guru = $(this).data('judul_pengumuman_guru');
        let isi_pengumuman = $(this).data('isi_pengumuman');
        let file_pengumuman = $(this).data('file_pengumuman');

        console.log('Data Edit:', {
        id: id_pengumuman_guru,
        judul: judul_pengumuman_guru,
        isi: isi_pengumuman,
        file: file_pengumuman
    });

        // Set nilai form action untuk edit
        $('#editForm').attr('action', '{{ route("pengumuman_guru.update", ":id") }}'.replace(':id', id_pengumuman_guru));

        // Isi nilai input di modal edit dengan id yang benar
        $('#edit-id_pengumuman_guru').val(id_pengumuman_guru);
        $('#edit-judul_pengumuman_guru').val(judul_pengumuman_guru);
        $('#edit-isi_pengumuman').val(isi_pengumuman);

         // Jika file pengumuman ada, tampilkan nama file dan link untuk mengunduh
    if (file_pengumuman) {
        $('#file-download-container').html(
            `<p>Download File: <a href="{{ asset('uploads') }}/${file_pengumuman}" class="btn btn-link">Download</a></p>`
        );
    } else {
        $('#file-download-container').html('Tidak ada file.');
    }
    });

</script>

<script>
    function sendEmail() {
    const jurusan = [];
    const kelas = [];

    // Ambil jurusan yang dipilih
    document.querySelectorAll('input[name="jurusan[]"]:checked').forEach((checkbox) => {
        jurusan.push(checkbox.value);
    });

    // Ambil kelas yang dipilih
    document.querySelectorAll('input[name="kelas[]"]:checked').forEach((checkbox) => {
        kelas.push(checkbox.value);
    });

    // Ambil elemen form
    const formData = new FormData();
    formData.append('judul_pengumuman_guru', document.getElementById('edit-judul_pengumuman_guru').value);
    formData.append('isi_pengumuman', document.getElementById('edit-isi_pengumuman').value);

    // Tambahkan file jika ada
    const fileInput = document.getElementById('edit-file_pengumuman_guru');
    if (fileInput.files[0]) {
        formData.append('file_pengumuman_guru', fileInput.files[0]);
    }

    // Tambahkan jurusan dan kelas
    jurusan.forEach((id) => formData.append('jurusan[]', id));
    kelas.forEach((id) => formData.append('kelas[]', id));

    // Kirim request
    fetch('/send-email-guru', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Failed to send email.');
        }
        return response.json();
    })
    .then((data) => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Email berhasil dikirim.',
        });
    })
    .catch((error) => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat mengirim email.',
        });
    });
}

</script>

<script>
     $('#shareWhatsapp').click(function () {
    let id_pengumuman_guru = $('#edit-id_pengumuman_guru').val();
    let judul_pengumuman_guru = $('#edit-judul_pengumuman_guru').val();
    let isi_pengumuman = $('#edit-isi_pengumuman').val();

    // Ambil jurusan dan kelas yang dipilih
    let selectedJurusan = [];
    $('input[name="jurusan[]"]:checked').each(function () {
        selectedJurusan.push($(this).val());
    });

    let selectedKelas = [];
    $('input[name="kelas[]"]:checked').each(function () {
        selectedKelas.push($(this).val());
    });

    // Kirim permintaan ke controller untuk mengirim pesan WhatsApp
    $.ajax({
        url: '/send-whatsapp-guru',
        method: 'POST',
        data: {
            id_pengumuman_guru: id_pengumuman_guru,
            judul_pengumuman_guru: judul_pengumuman_guru,
            isi_pengumuman: isi_pengumuman,
            jurusan: selectedJurusan,
            kelas: selectedKelas,
            _token: '{{ csrf_token() }}' // Pastikan CSRF token disertakan
        },
        success: function (response) {
            alert('Pesan WhatsApp berhasil dikirim!');
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan saat mengirim pesan WhatsApp');
        }
    });
});

</script>