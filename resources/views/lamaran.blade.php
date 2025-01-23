<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="h3 mb-3 page-title">Lamaran</h2>
        <div class="row">
          @foreach($pelamars as $pelamar)
            <div class="col-md-12 mb-4">
              <div class="card shadow mb-4 d-flex flex-row align-items-center">
                <div class="card-body d-flex flex-grow-1 align-items-center">
                  <div class="circle circle-md bg-secondary">
                    <span class="fe fe-user fe-16 text-white"></span>
                  </div>    
                  <div class="flex-fill ml-4 fname">
                    <strong>{{ $pelamar->nama_lowongan }}</strong><br />
                    <span class="badge badge-light text-muted">Nama Lengkap: {{ $pelamar->nama_lengkap }}</span><br />
                    <span class="badge badge-light text-muted">Tanggal Lahir: {{ $pelamar->tgl_lahir }}</span><br />
                    <span class="badge badge-light text-muted">Alamat: {{ $pelamar->alamat }}</span><br />
                    <span class="badge badge-light text-muted">Status: {{ $pelamar->status }}</span>
                  </div>
                  <div class="ml-4">
                    <!-- Button untuk membuka modal -->
                    <button 
                      type="button" 
                      class="btn btn-info" 
                      data-toggle="modal" 
                      data-target="#detailModal"
                      data-nama-lowongan="{{ $pelamar->nama_lowongan }}"
                      data-nama-lengkap="{{ $pelamar->nama_lengkap }}"
                      data-tgl-lahir="{{ $pelamar->tgl_lahir }}"
                      data-alamat="{{ $pelamar->alamat }}"
                      data-status="{{ $pelamar->status }}">
                      Lihat Detail
                    </button>
                    <form action="{{ route('acceptPelamar', $pelamar->id_pelamar) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menerima pelamar ini?')">Accept</button>
                    </form>
                    <form action="{{ route('declinePelamar', $pelamar->id_pelamar) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pelamar ini?')">Decline</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</main>


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Lamaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal-content">
          <!-- Detail pelamar akan ditampilkan disini -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
 $('#detailModal').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget); // Tombol yang membuka modal
    var modal = $(this);

    // Mengambil data dari atribut data-*
    var namaLowongan = button.data('nama-lowongan');
    var namaLengkap = button.data('nama-lengkap');
    var tglLahir = button.data('tgl-lahir');
    var alamat = button.data('alamat');
    var status = button.data('status');

    // Menampilkan data pelamar dalam modal
    modal.find('#modal-content').html(`
      <p><strong>Nama Lowongan: </strong>${namaLowongan}</p>
      <p><strong>Nama Lengkap: </strong>${namaLengkap}</p>
      <p><strong>Tanggal Lahir: </strong>${tglLahir}</p>
      <p><strong>Alamat: </strong>${alamat}</p>
      <p><strong>Status: </strong>${status}</p>
    `);
});

</script>
