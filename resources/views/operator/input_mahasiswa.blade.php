<form action="{{ route('simpan.mahasiswa') }}" method="POST">
    @csrf
    <label for="nim">NIM:</label>
    <input type="text" name="nim" id="nim" required>

    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" required>

    <button type="submit">Simpan</button>
</form>
