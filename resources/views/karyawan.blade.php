<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-2 page-title">Data Karyawan</h2>
        <p class="card-text">Berikut adalah daftar karyawan yang terdaftar dalam sistem.</p>
        <div class="row my-4">
          <!-- Small table -->
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Karyawan</h5>
              </div>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Gaji</th>
                      <th>Divisi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @foreach ($karyawan as $data)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->username }}</td>
                        <td>{{ number_format($data->gaji, 2, ',', '.') }}</td>
                        <td>{{ $data->divisi }}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning" 
                                  data-toggle="modal" data-target="#editEmployeeModal"
                                  data-id="{{ $data->id_karyawan }}" 
                                  data-username="{{ $data->username }}"
                                  data-gaji="{{ $data->gaji }}" 
                                  data-divisi="{{ $data->divisi }}">
                            Edit
                          </button>
                          <a href="{{ route('hapuskaryawan', $data->id_karyawan) }}" 
                             class="btn btn-sm btn-danger"
                             onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div> <!-- /.col -->
        </div> <!-- end section -->
      </div> <!-- /.col-12 -->
    </div> <!-- /.row -->
  </div> <!-- .container-fluid -->

 
  <!-- Edit Employee Modal -->
  <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEmployeeLabel">Edit Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('editkaryawan', $data->id_karyawan) }}" method="POST">
          @csrf
          <input type="hidden" name="id_karyawan" id="editIdKaryawan">
          <div class="modal-body">
            <div class="form-group">
              <label for="editUsername">Username</label>
              <input type="text" class="form-control" id="editUsername" name="username" required>
            </div>
            <div class="form-group">
              <label for="editGaji">Gaji</label>
              <input type="number" class="form-control" id="editGaji" name="gaji" required>
            </div>
            <div class="form-group">
              <label for="editDivisi">Divisi</label>
              <input type="text" class="form-control" id="editDivisi" name="divisi" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</main>

<!-- Script to handle the modal data filling -->
<script>
  $('#editEmployeeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var id = button.data('id'); 
    var username = button.data('username'); 
    var gaji = button.data('gaji'); 
    var divisi = button.data('divisi'); 

    var modal = $(this);
    modal.find('#editIdKaryawan').val(id);
    modal.find('#editUsername').val(username);
    modal.find('#editGaji').val(gaji);
    modal.find('#editDivisi').val(divisi);
  });
</script>