<?php

namespace App\Http\Controllers\Pengusul;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailPkm;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    function upload(){
        return view("pengusul.proposal");
    }

    function uploadPost(Request $request){
        $file = $request->file("file");
        // echo 'File Name: ' . $file->getClientOriginalName();
        // echo '<br>';
        // echo 'File Extension: ' . $file->getClientOriginalExtension();
        // echo '<br>';
        // echo 'File Real Path: ' . $file->getRealPath();
        // echo '<br>';
        // echo 'File Size: ' . $file->getSize();
        // echo '<br>';
        // echo 'File Mime Tyoe: ' . $file->getMimeType();
        // echo '<br>';

        if($path = $request->file('file')->store('proposals', 'private')){
            echo "File Upload Success";
            }
            else
                 echo "Failed to upload file";
        return view("pengusul.proposal");
    }
}

    // public function upload()
    // {
    //     // Mengambil data skema dan judul yang sudah ada
    //     $detailPkms = DetailPkm::with('skema')->get(['id', 'judul']);
    //     return view("pengusul.proposal", compact('detailPkms'));
    // }

    // public function uploadPost(Request $request)
    // {
    //     try {
    //         // Validasi input file
    //         $request->validate([
    //             'file' => 'required|file|mimes:pdf,doc,docx|max:5148',
    //             'id_skema' => 'required|integer',
    //             'judul' => 'required|string|max:255',
    //         ]);

    //         // Upload file ke storage private
    //         $filePath = $request->file('file')->store('proposals', 'private');

    //         // Simpan informasi ke database
    //         $detailPkm = new DetailPkm();
    //         $detailPkm->id_skema = $request->input('id_skema');
    //         $detailPkm->judul = $request->input('judul');
    //         $detailPkm->proposal = $filePath;
    //         $detailPkm->save();

    //         return redirect()->back()->with('success', 'File berhasil diupload!');
    //     } 
    //     catch (\Illuminate\Validation\ValidationException $e) {
    //         return redirect()->back()->withErrors($e->errors());
    //     }
    //     catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload file: ' . $e->getMessage());
    //     }
    // }
