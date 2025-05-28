<div class="table-responsive mt-1">
    <input type="text" wire:model.lazy="search" class="form-control mb-3" placeholder="Cari nama atau username...">
    <table class="table table-hover table-bordered table-striped align-middle">
        <thead class="table-dark">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Ebook</th>
            <th class="text-center">Author</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($ebooks as $data)
            <tr>
            <td class="text-center">1</td>
            <td>{{ $data->ebook }}</td>
            <td>{{ $data->author }}</td>
            <td class="text-center">{{ $data->kelas }}</td>
            <td class="text-center">
                <form action="{{ url('/delete-ebook/' . $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>