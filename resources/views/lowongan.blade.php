@php
  $id_level = session('id_level');
@endphp

<main role="main" class="main-content">
  <div class="container">
    <div class="row align-items-center mb-4">
      <div class="col">
        <strong>Lowongan</strong>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 mb-4">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahLowonganModal">Tambah Lowongan</button>
      </div>
      @foreach($lowongans as $lowongan)
        <div class="col-md-4 mb-4">
          <div class="card shadow mb-4 d-flex flex-column">
            <div class="card-body d-flex flex-column align-items-center">
              <div class="circle circle-md bg-secondary mb-3">
                <span class="fe fe-folder fe-16 text-white"></span>
              </div>
              <h5 class="card-title text-center">{{ $lowongan->nama_lowongan }}</h5>
              <p class="card-text text-muted text-center">{{ $lowongan->syarat }}</p>
              
              <!-- Button Apply - Only visible to users with id_level 3 -->
              @if($id_level == 3)
                <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#applyModal{{ $lowongan->id_lowongan }}">
                  Apply
                </button>
              @endif
              
              <!-- Actions (Edit and Delete) - Only visible to users with id_level 1 -->
              @if($id_level == 1)
                <div class="dropdown mt-3">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $lowongan->id_lowongan }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $lowongan->id_lowongan }}">
                    <button class="dropdown-item" data-toggle="modal" data-target="#editLowonganModal{{ $lowongan->id_lowongan }}">Edit</button>
                    <button class="dropdown-item" data-toggle="modal" data-target="#hapusLowonganModal{{ $lowongan->id_lowongan }}">Hapus</button>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Modal Apply -->
        <div class="modal fade" id="applyModal{{ $lowongan->id_lowongan }}" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel{{ $lowongan->id_lowongan }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="{{ route('addlamaran') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                  <h5 class="modal-title" id="applyModalLabel{{ $lowongan->id_lowongan }}">Lamaran untuk {{ $lowongan->nama_lowongan }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
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

        <!-- Modal Edit Lowongan -->
        <div class="modal fade" id="editLowonganModal{{ $lowongan->id_lowongan }}" tabindex="-1" role="dialog" aria-labelledby="editLowonganModalLabel{{ $lowongan->id_lowongan }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="{{ route('editlowongan', $lowongan->id_lowongan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                  <h5 class="modal-title" id="editLowonganModalLabel{{ $lowongan->id_lowongan }}">Edit Lowongan - {{ $lowongan->nama_lowongan }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="nama_lowongan">Nama Lowongan</label>
                    <input type="text" name="nama_lowongan" class="form-control" value="{{ $lowongan->nama_lowongan }}" required>
                  </div>
                  <div class="form-group">
                    <label for="syarat">Syarat Lowongan</label>
                    <textarea name="syarat" class="form-control" rows="3" required>{{ $lowongan->syarat }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update Lowongan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal Hapus Lowongan -->
        <div class="modal fade" id="hapusLowonganModal{{ $lowongan->id_lowongan }}" tabindex="-1" role="dialog" aria-labelledby="hapusLowonganModalLabel{{ $lowongan->id_lowongan }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="{{ route('hapuslowongan', $lowongan->id_lowongan) }}" method="POST">
                @csrf
                <div class="modal-header">
                  <h5 class="modal-title" id="hapusLowonganModalLabel{{ $lowongan->id_lowongan }}">Hapus Lowongan - {{ $lowongan->nama_lowongan }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Apakah Anda yakin ingin menghapus lowongan ini?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Hapus Lowongan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
<!-- Modal Tambah Lowongan -->
<div class="modal fade" id="tambahLowonganModal" tabindex="-1" role="dialog" aria-labelledby="tambahLowonganModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('tambahLowongan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahLowonganModalLabel">Tambah Lowongan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_lowongan">Nama Lowongan</label>
            <input type="text" name="nama_lowongan" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="syarat">Syarat Lowongan</label>
            <textarea name="syarat" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah Lowongan</button>
        </div>
      </form>
    </div>
  </div>
</div>

      @endforeach
    </div>
  </div>
  
</main>
