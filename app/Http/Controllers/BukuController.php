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
        // $url = 'http://localhost:8000/api/tambahbuku';
        try {
            // tambah data
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($parameter)
            ]);

            // buat ambil jika eeror
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
        try {
            $client = new Client();
            $url = "http://localhost:8000/api/buku/$id";
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            if ($contentArray['status'] == false) {
                // Jika data tidak ditemukan, redirect dengan pesan error
                return redirect()->route('buku.index')->with('error', $contentArray['message']);
            }

            // Jika data ditemukan, tampilkan form edit (misalnya)
            return view('buku.index', [
                'data' => $contentArray['data']
            ]);

        } catch (\Exception $e) {
            // Tangkap error lainnya
            return redirect()->route('buku.index')->with('error', 'Terjadi kesalahan saat mengambil data');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // $data = $contentArray['data'];
        // return view('buku.index.', [
        //     'data' => $data
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parameter = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'tanggal_publikasi' => $request->tanggal_publikasi
        ];

        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        try {
            $response = $client->request('PUT', $url, [
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
                return redirect()->back()->withErrors($errors)->withInput(); // Gunakan withErrors untuk menangani error
            }
            return redirect()->route('buku.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')->with('error', 'Terjadi kesalahan saat mengambil data');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://localhost:8000/api/deletebuku/$id";
        $response = $client->request('DELETE', $url);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->route('buku.index')->with('error', $error);
        } else {
            return redirect()->route('buku.index')->with('success', 'Data berhasil dihapus.');
        }
    }
}
