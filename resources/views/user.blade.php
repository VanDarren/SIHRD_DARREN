<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-2 page-title">Data Pengguna</h2>
        <p class="card-text">Berikut adalah daftar pengguna beserta informasi level akses mereka.</p>
        
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="level1-2-tab" data-toggle="tab" href="#level1-2" role="tab" aria-controls="level1-2" aria-selected="true">Level 1 & 2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="level3-tab" data-toggle="tab" href="#level3" role="tab" aria-controls="level3" aria-selected="false">Level 3</a>
          </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
          <!-- Tab Level 1 & 2 -->
          <div class="tab-pane fade show active" id="level1-2" role="tabpanel" aria-labelledby="level1-2-tab">
            <div class="card shadow mt-3">
              <div class="card-body">
                <table class="table datatables" id="dataTable1-2">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>No. HP</th>
                      <th>Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @foreach ($users as $user)
                      @if($user->id_level == 1 || $user->id_level == 2)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->nohp }}</td>
                          <td>
                            @if($user->id_level == 1 || $user->id_level == 2)
                            {{ $user->level }}
                            @endif
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <!-- Tab Level 3 -->
          <div class="tab-pane fade" id="level3" role="tabpanel" aria-labelledby="level3-tab">
            <div class="card shadow mt-3">
              <div class="card-body">
                <table class="table datatables" id="dataTable3">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>No. HP</th>
                      <th>Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @foreach ($users as $user)
                      @if($user->id_level == 3)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->nohp }}</td>
                          <td>{{ $user->level }}</td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> <!-- End Tab Content -->
      </div> <!-- /.col-12 -->
    </div> <!-- /.row -->
  </div> <!-- .container-fluid -->
</main>

<!-- Tambahkan Script DataTables -->
<script>
  $(document).ready(function() {
    $('#dataTable1-2, #dataTable3').DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json" // Mengatur Bahasa Indonesia (opsional)
      }
    });
  });
</script>
