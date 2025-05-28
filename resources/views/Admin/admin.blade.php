<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="container-fluid">
  <div class="row">
    @include('components.navbar')
    <!-- Main content -->
    <main class="col-md-10 ms-sm-auto px-4 py-4">
      <h2>Dashboard</h2>
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card text-white bg-primary h-100">
            <div class="card-body">
              <h5 class="card-title">Total Users</h5>
              <p class="card-text fs-4">1,204</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card text-white bg-success h-100">
            <div class="card-body">
              <h5 class="card-title">Total Ebook</h5>
              <p class="card-text fs-4">32</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card text-white bg-warning h-100">
            <div class="card-body">
              <h5 class="card-title">Revenue</h5>
              <p class="card-text fs-4">$12,340</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">Recent Activity</div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <li>✅ User John added a new post.</li>
            <li>✅ Sarah registered an account.</li>
            <li>✅ Backup completed successfully.</li>
          </ul>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
