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
        // $response = $client->request('GET', 'http://localhost:8000/api/buku');
        // $data = $response->getBody();
        // $data = json_decode($data);
        // return $data;

        $url = 'http://localhost:8000/api/buku';
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents(); // masih json
        // echo $response->getStatusCode(); // utk mengetahui status code

        // echo $content;
        $contentArray = json_decode($content, true);
        $data = $contentArray['data']; // agar tidak ambil status dan message
        // print_r($contentArray);
        // print_r($data);
        return view('buku.index', [
            'data' => $data,
        ]);
        // dd($response);
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
        dd($request->all());
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
