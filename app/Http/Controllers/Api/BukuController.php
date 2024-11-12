<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Buku();
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal memasukan data',
                'data' => $validator->errors()
            ], 400);
        }
        $data->judul = $request->judul;
        $data->pengarang = $request->pengarang;
        $data->tanggal_publikasi = $request->tanggal_publikasi;
        $post = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Data ditambahkan',
            // 'data' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Buku::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'gagal update data',
                'data' => $validator->errors()
            ], 400);
        }
        $data->judul = $request->judul;
        $data->pengarang = $request->pengarang;
        $data->tanggal_publikasi = $request->tanggal_publikasi;
        $post = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Data diupdate',
            // 'data' => $post
        ], 200);
        // return view('anje;y');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Buku::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data dihapus',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}
