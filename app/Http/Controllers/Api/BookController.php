<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get semua data buku
        $books = Book::all();
        // Mengembalikan respon dalam bentuk json
        return response()->json([
            'status' => true,
            'message' => 'Berikut data semua buku',
            'data' => $books,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Membuat data baru dengan model Book
        $book = new Book;
        // Untuk rules validasi form
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'release_date' => 'required|date',
        ];
        // Inisialisasi inputan user dengan rules yang dibuat
        $validator = Validator::make($request->all(), $rules);
        // Kondisi jika rules tidak terpenuhi
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukan data!',
                'data' => $validator->errors(),
            ], 400);
        }
        // Membuat data buku berdasarkan inputan user
        $book->title = $request->title;
        $book->author = $request->author;
        $book->release_date = $request->release_date;
        $book->save();
        // Response jika buku berhasil dibuat
        return response()->json([
            'status' => true,
            'message' => 'Berhasil menambahkan data!',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get id dari endpoint
        $bookId = $id;
        // Find id tersebut di database
        $book = Book::find($id);
        // Jika id ditemukan, tampilkan datanya, jika tidak tampilkan response false
        if ($book) {
            return response()->json([
                'status' => true,
                'message' => 'Berikut adalah data buku dengan id : ' . $bookId,
                'data' => $book,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                "message" => 'ID tersebut tidak ditemukan!',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get id berdasarkan inputan user dari database
        $book = Book::find($id);
        // Kondisi jika id tidak ditemukan
        if (empty($book)) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak ditemukan!',
            ], 400);
        }
        // Untuk rules validasi form
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'release_date' => 'required|date',
        ];
        // Inisialisasi inputan user dengan rules yang dibuat
        $validator = Validator::make($request->all(), $rules);
        // Kondisi jika rules tidak terpenuhi
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal update data!',
                'data' => $validator->errors(),
            ], 400);
        }
        // Membuat data buku berdasarkan inputan user
        $book->title = $request->title;
        $book->author = $request->author;
        $book->release_date = $request->release_date;
        $book->save();
        // Response jika buku berhasil dibuat
        return response()->json([
            'status' => true,
            'message' => 'Berhasil update data!',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get id dari database
        $book = Book::find($id);
        // Kondisi jika id tidak ditemukan
        if (empty($book)) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak ditemukan!',
            ], 400);
        }
        // Hapus data berdasarkan id
        $book->delete();
        // Response jika berhasil hapus data
        return response()->json([
            "status" => true,
            "message" => "Data buku berhasil dihapus!",
        ], 200);
    }
}
