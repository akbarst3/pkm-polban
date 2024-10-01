<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;

class FileUploadController
{
    // Fungsi untuk menangani upload file
    public function uploadFile(Request $request)
    {
        // Validasi input file
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', // Menyesuaikan tipe file dan ukuran maksimal
        ]);

        // Ambil file yang diupload
        $file = $request->file('file');

        // Tentukan nama file baru dan lokasi penyimpanan
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Bisa disimpan di database jika diperlukan
        // Contoh: FileModel::create(['file_name' => $fileName, 'file_path' => $filePath]);

        // Kembalikan response setelah upload berhasil
        return back()
            ->with('success', 'File berhasil diunggah.')
            ->with('file', $fileName);
    }
}
