<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
  @livewireStyles
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      @include('components.navbar')
      <!-- Main content -->
      <main class="col-md-10 ms-sm-auto px-4 py-4">
        <div class="container mt-5">
          <h4 class="mb-4">Data User</h4>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#infoModal">+ Data</button>
          @if ($errors->any())
            <div style="color: red; margin-bottom: 10px;">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @livewire('search-ebook');
        </div>
      </main>
    </div>
  </div>
 <!-- Tambahkan modal di akhir body -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infoModalLabel">Form Input New Users</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <form action="/add-ebook" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <input class="form-control" type="text" name="Author" placeholder="Author..."/>
            </div>
            <div class="mb-3">
              <select class="form-select" id="ebook" name="Ebook">
                <option selected disabled>Ebook</option>
                <option value="Al-Quran dan Hadist">Al-Quran dan Hadist</option>
                <option value="Bahasa Arab">Bahasa Arab </option>
                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                <option value="PPKN">PPKN</option>
                <option value="Bahasa Inggris">Bahasa Inggris</option>
                <option value="IPA">IPA</option>
                <option value="IPAS">IPAS</option>
                <option value="IPS">IPS</option>
                <option value="Matematika">Matematika</option>
                <option value="PABP">PABP</option>
                <option value="Seni Budaya">Seni Budaya</option>
              </select>
            </div>

            <div class="mb-3">
              <select class="form-select" id="Kelas" name="Kelas">
                <option selected disabled>Kelas</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
            </div>

            <label>Upload Cover (JPG, PNG, max 2MB):</label><br>
            <input class="form-control" type="file" name="cover"><br><br>

            <label>Upload Ebook (PDF, max 5MB):</label><br>
            <input class="form-control" type="file" name="file_pdf"><br><br>
            <button type="submit" class="btn btn-primary">Kirim</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
</body>
</html>
