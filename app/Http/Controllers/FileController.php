<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ClamAVTrait;

class FileController extends Controller
{
    use ClamAVTrait;

    public function upload(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|mimetypes:text/plain,image/jpeg,image/png,image/gif|max:2048',
            ]);

            dd($this->isFileClean($request->file('file')->getRealPath()));

            if ($request->file()) {
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                return response()->json(['message' => 'File uploaded successfully', 'file' => $fileName]);
            }

            return response()->json(['message' => 'File upload failed'], 500);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error($e);

            return response()->json(['message' => 'File upload failed', 'errors' => $e->errors()], 422);
        }
    }
}
