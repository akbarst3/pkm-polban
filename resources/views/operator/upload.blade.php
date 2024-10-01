<form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="file">Pilih file:</label>
    <input type="file" name="file" id="file" required>
    <button type="submit">Unggah</button>
</form>

@if (session('success'))
    <div>
        <strong>{{ session('success') }}</strong>
        <p>File yang diunggah: {{ session('file') }}</p>
    </div>
@endif
