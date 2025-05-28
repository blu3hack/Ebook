<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/kelas.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Archivo:ital,wght@1,200&family=Caveat:wght@500&family=Cormorant+Garamond&family=IBM+Plex+Serif:wght@300&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,500;1,300;1,500&family=Shadows+Into+Light&display=swap"
      rel="stylesheet"
    />
    <title>Kelas 7</title>
</head>
<body>
  <div class="container-fluid">
    <div class="container header">
      <img src="header/1.png" alt="">
    </div>

    <div class="container content">
    @foreach ($ebooks as $data)
      <div class="book">
        <div>
          <!-- ID modal disesuaikan per data -->
          <img src="{{ asset('cover/' . $data->cover) }}" alt="" data-bs-toggle="modal" data-bs-target="#infoModal{{ $data->id }}" style="cursor: pointer;">
        </div>
      </div>

      {{-- Modal --}}
      <div class="modal fade" id="infoModal{{ $data->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="infoModalLabel{{ $data->id }}">Detil Ebook</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="modal-content-ebook">
                <div class="modal-img-ebook">
                  <img src="{{ asset('cover/' . $data->cover) }}" alt="" width="150">
                </div>
                <div class="modal-detail-ebook">
                  <h1>{{ $data->ebook }}</h1>
                  <span>{{ $data->kelas }}th Grade</span>
                  <h6>Author : {{ $data->author }}</h6>
                  <form action="{{ url('/ebook/' . $data->file_pdf) }}" class="d-flex align-items-center mt-2">
                    <input type="hidden" name="file_pdf" value="{{ $data->file_pdf }}">
                    <input type="password" name="Token" class="form-control me-2 text-center" placeholder="Masukkan Token">
                    <button type="submit" class="btn btn-primary">GO</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="container footer">
    <img src="header/footer.png" alt="">
  </div>
  </div>
<!-- Tambahkan sebelum penutup </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>