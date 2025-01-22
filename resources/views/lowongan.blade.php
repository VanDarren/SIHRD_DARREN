<main role="main" class="main-content">
  <div class="container">
    <div class="row align-items-center mb-4">
      <div class="col">
        <strong>Lowongan</strong>
      </div>
    </div>
    <div class="row">
      @foreach($lowongans as $lowongan)
        <div class="col-md-12 mb-4">
          <div class="card shadow mb-4 d-flex flex-row align-items-center">
            <div class="card-body d-flex flex-grow-1 align-items-center">
              <div class="circle circle-md bg-secondary">
                <span class="fe fe-folder fe-16 text-white"></span>
              </div>
              <div class="flex-fill ml-4 fname">
                <strong>{{ $lowongan->nama_lowongan }}</strong><br />
                <span class="badge badge-light text-muted">{{ $lowongan->syarat }}</span>
              </div>
              <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal{{ $lowongan->id_lowongan }}">
                  Apply
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Form -->
        <div class="modal fade" id="applyModal{{ $lowongan->id_lowongan }}" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel{{ $lowongan->id_lowongan }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="{{route('addlowongan')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                  <h5 class="modal-title" id="applyModalLabel{{ $lowongan->id_lowongan }}">Lamaran untuk {{ $lowongan->nama_lowongan }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="tanggal_lahir">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="cv">CV</label>
                    <input type="file" name="cv" class="form-control-file" required>
                  </div>
                  <div class="form-group">
                    <label for="surat">Surat Lamaran</label>
                    <input type="file" name="surat" class="form-control-file" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit Lamaran</button>
                </div>
                <input type="hidden" name="lowongan_id" value="{{ $lowongan->id_lowongan }}">
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</main>