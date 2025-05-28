 <!-- Sidebar -->
<nav class="col-md-2 d-none d-md-block sidebar py-4">
    <div class="text-center mb-4">
    <h4>Admin Ebook</h4>
    </div>
    <ul class="nav flex-column px-3">
        <li class="nav-item mb-2"><a class="nav-link" href="/admin">Dashboard</a></li>
        <li class="nav-item mb-2"><a class="nav-link" href="add-ebook">Ebooks</a></li>
        <li class="nav-item mb-2"><a class="nav-link" href="add-users">Users</a></li>
        <li class="nav-item mb-2"><a class="nav-link" href="add-panel">Panel</a></li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="#">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-danger btn btn-link p-0 m-0" style="text-decoration: none;">Logout</button>
                </form>
            </a>
        </li>
    </ul>
</nav>