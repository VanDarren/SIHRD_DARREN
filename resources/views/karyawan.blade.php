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
                <a href="" class="btn btn-primary">Tambah Karyawan</a>
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
                          <a href="" class="btn btn-sm btn-warning">Edit</a>
                          <a href="" 
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
</main>

