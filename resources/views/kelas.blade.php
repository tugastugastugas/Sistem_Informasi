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
                                    <button type="button" class="btn btn-outline-primary btn-sm tambah-murid"
                                        data-bs-toggle="modal" data-bs-target="#tambahMuridModal"
                                        data-id_kelas="{{ $sm->id_kelas }}"
                                        data-nama_kelas="{{ $sm->nama_kelas }}">
                                        Tambah Murid
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
                        <label for="jurusan" class="form-label">Jurusan</label>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Pilih Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan">
                        <option value="" selected disabled>Pilih jurusan</option>
                        @foreach($jurusan as $item)
                            <option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk edit pengumuman -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_kelas" id="edit-id_kelas">
                    <div class="mb-3">
                        <label for="edit-nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="edit-nama_kelas" name="nama_kelas" required>
                    </div>

                    <label for="jurusan" class="form-label">Jurusan</label>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Pilih Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan">
                        <option value="" selected disabled>Pilih jurusan</option>
                        @foreach($jurusan as $item)
                            <option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    </div>  

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <hr>
                <h5>Daftar Murid</h5>
                <table class="table table-striped" id="muridTable">
                    <thead>
                        <tr>
                            <th>Nama Murid</th>
                            <th>Email Murid</th>
                            <th>Telepon Murid</th>
                            <th>Email Ortu</th>
                            <th>Telepon Ortu</th>
                            <th>Aksi</th> <!-- Kolom untuk aksi Hapus -->
                        </tr>
                    </thead>
                    <tbody id="muridTableBody">
                        <!-- Data murid akan dimasukkan di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="tambahMuridModal" tabindex="-1" aria-labelledby="tambahMuridModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMuridModalLabel">Tambah Murid ke Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('murid.store') }}" method="POST" id="tambahMuridForm">
                    @csrf
                    <input type="hidden" name="id_kelas" id="id_kelas">
                    <div id="murid-container">
                        <div class="murid-form">
                            <div class="mb-3">
                                <label for="nama_murid[]" class="form-label">Nama Murid</label>
                                <input type="text" class="form-control" id="nama_murid[]" name="nama_murid[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="email_murid[]" class="form-label">Email Murid</label>
                                <input type="text" class="form-control" id="email_murid[]" name="email_murid[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="email_ortu[]" class="form-label">Email Ortu</label>
                                <input type="text" class="form-control" id="email_ortu[]" name="email_ortu[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="nohp_murid[]" class="form-label">NoHp Murid</label>
                                <input type="text" class="form-control" id="nohp_murid[]" name="nohp_murid[]" required>
                            </div>
                            <div class="mb-3">
                                <label for="nohp_ortu[]" class="form-label">NoHp Ortu</label>
                                <input type="text" class="form-control" id="nohp_ortu[]" name="nohp_ortu[]" required>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="addMuridForm">Tambah Form</button>
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

        // Bersihkan tabel murid
        $('#muridTableBody').html('');

        // Ambil data murid via AJAX
        fetch(`/kelas/${id_kelas}/murid`)
            .then(response => response.json())
            .then(data => {
                data.forEach(murid => {
                    const row = `
                        <tr>
                            <td>${murid.nama_murid}</td>
                            <td>${murid.email_murid}</td>
                            <td>${murid.nohp_murid}</td>
                            <td>${murid.email_ortu}</td>
                            <td>${murid.nohp_ortu}</td>
                            <td>
                                       <form action="/murid/${murid.id_murid}/hapus" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-outline-danger btn-sm" type="submit">Hapus</button>
                        </form>
                               
                            </td>
                        </tr>
                    `;
                    $('#muridTableBody').append(row);
                });
            })
            .catch(error => console.error('Error fetching murid:', error));
    });

    // Event listener untuk tombol hapus murid
   
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const addMuridFormButton = document.getElementById('addMuridForm');
    const muridContainer = document.getElementById('murid-container');
    const idKelasInput = document.getElementById('id_kelas');


    document.querySelectorAll('.tambah-murid').forEach(button => {
        button.addEventListener('click', function () {
            const idKelas = this.getAttribute('data-id_kelas');
            idKelasInput.value = idKelas;
        });
    });

    addMuridFormButton.addEventListener('click', function () {
        // Ambil elemen form terakhir
        const lastForm = muridContainer.querySelector('.murid-form:last-child');
        // Klon elemen tersebut
        const newForm = lastForm.cloneNode(true);

        // Reset nilai input pada form baru
        newForm.querySelectorAll('input').forEach(input => input.value = '');

        // Tambahkan form baru ke container
        muridContainer.appendChild(newForm);
    });
});


</script>