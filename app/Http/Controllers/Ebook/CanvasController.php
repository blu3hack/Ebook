<?php

namespace App\Http\Controllers\Ebook;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CanvasController extends Controller
{
    public function store(Request $request, $file_pdf)
    {
        $userId = Auth::id();

        foreach ($request->drawings as $pageNum => $base64Image) {
            // Bersihkan base64 menjadi data binary
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

            // Nama file unik
            $fileName = $userId . '_file_' . $file_pdf . '_page_' . $pageNum . '.png';

            // Simpan ke public/path-image/
            $path = public_path('path-image/' . $fileName);
            File::put($path, $imageData);

            // Path relatif untuk disimpan di DB
            $imagePath = 'path-image/' . $fileName;

            // Insert atau update berdasarkan user, halaman, dan file_pdf
            DB::table('canvas_drawings')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'page_num' => $pageNum,
                    'file_pdf' => $file_pdf
                ],
                [
                    'image_path' => $imagePath,
                    'updated_at' => now(),
                    'created_at' => now(), // ignored saat update
                ]
            );
        }

        return response()->json(['message' => 'Saved']);
    }

    public function get($file_pdf)
    {
        $userId = Auth::id();

        $records = DB::table('canvas_drawings')
            ->where('user_id', $userId)
            ->where('file_pdf', $file_pdf)
            ->get();

        $result = [];

        foreach ($records as $record) {
            $result[$record->page_num] = asset($record->image_path); // hasil berupa URL lengkap
        }

        return response()->json($result);
    }
}
