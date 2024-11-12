<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        // $response = $client->request('GET', 'http://localhost:8000/api/buku');k
        // $data = $response->getBody();
        // $data = json_decode($data);
        // return $data;

        $url = 'http://localhost:8000/api/buku';
        $response = $client->request('GET', $url);
        // dd($response);
        $content = $response->getBody()->getContents(); // masih json
        // echo $response->getStatusCode(); // utk mengetahui status code

        // mengubah json menjadi array
        $contentArray = json_decode($content, true);
        // ambil semua data
        // print_r($contentArray);

        $data = $contentArray['data'];
        // agar tidak ambil status dan message, hanya mengambil data
        // print_r($data);
        return view('buku.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $parameter = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi
        ];

        $client = new Client();
        $url = 'http://localhost:8000/api/buku';
        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($parameter)
            ]);

            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            if ($contentArray['status'] != true) {
                // Jika validasi gagal, ambil pesan error dari API
                $errors = $contentArray['data']; // Ambil bagian pesan error dari API
                return redirect()->back()->withErrors($errors); // Gunakan withErrors untuk menangani error
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            // Jika terjadi error lain, kirim pesan error generik
            // withInput() digunakan untuk mengembalikan input yang telah diisi sebelumnya
            return redirect()->back()->with('error', 'Ada masalah saat menyimpan data.')->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
