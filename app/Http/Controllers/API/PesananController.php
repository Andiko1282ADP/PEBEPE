<?php

namespace App\Http\Controllers\API;
use Exception;

use App\Models\pesanan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as IlluminateValidationException;


class PesananController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Retrieve all pesanan records from the database
        $pesanans = pesanan::with(['users', 'metode_pembayarans','pembayarans','rutes'])->get();

        // Return a view with the retrieved pesanan records
       if ($pesanans) {
        return response()->json(
            ['code' => 200, 'message' => 'Data Dapat Terlihat', 'data' => $pesanans],
            200,
        );  } else {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
      //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
{
    try {
        $user_id = auth()->id();
        if (!$user_id) {
            return response()->json(['message' => 'User tidak terotentikasi'], 401);
        }

        $validatedData = $request->validate([
            'jumlah_orang' => ['required', 'string'],
            'tanggal_pergi' => ['required', 'date'],
            'status' => ['required', 'string'],
            'waktu_pesan' => ['required', 'string'],
            'total_tagihan' => ['required', 'string'],
            'seat' => ['required', 'string'],
        ]);

        $pesanan = pesanan::create([
            'jumlah_orang' => $request->jumlah_orang,
            'tanggal_pergi' => $request->tanggal_pergi,
            'status' => $request->status,
            'waktu_pesan' => $request->waktu_pesan,
            'total_tagihan' => $request->total_tagihan,
            'kode_booking' => $request->kode_booking,
            'seat' => $request->seat,
            'user_id' => $user_id, // Assigning the user_id here
            'rute_id' => $request->rute_id,
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'pembayaran_id' => $request->pembayaran_id
        ]);

        $pesanan = pesanan::with('rute_id','metode_pembayaran_id', 'user_id','pembayaran_id');

        if ($pesanan) {
            return response()->json([
                'code' => 200,
                'message' => 'Data Dapat Terlihat',
                'data' => $pesanan,
            ], 200);
        } else {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    // Display the specified resource.
    public function show(Pesanan $pesanan) // Laravel automatically injects the Pesanan instance if route model binding is set up correctly
    {
    $pesanan = pesanan::with(['users', 'metode_pembayarans', 'pembayarans', 'detail_pesanans'])->findOrFail($pesanan->id);
    if ($pesanan) {
        return response()->json(
            ['code' => 200, 'message' => 'Data Dapat Terlihat', 'data' => $pesanan],
            200
        );
    } else {
        return response()->json(['message' => 'Something went wrong'], 500);
    }
    }

    // Show the form for editing the specified resource.
    public function edit(Pesanan $pesanan)
    {
        //
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'jumlah_orang' => ['required', 'string'],
            'tanggal_pergi' => ['required', 'date'],
            'status' => ['required', 'string'],
            'waktu_pesan' => ['required', 'string'],
            'total_tagihan' => ['required', 'string'],
            'seat' => ['required', 'string'],
        ]);

        // Retrieve the pesanan instance with the specified ID
        $pesanan = Pesanan::find($id);

        if ($pesanan) {
            $pesanan->jumlah_orang = $request->jumlah_orang;
            $pesanan->tanggal_pergi = $request->tanggal_pergi;
            $pesanan->status = $request->status;
            $pesanan->waktu_pesan = $request->waktu_pesan;
            $pesanan->total_tagihan = $request->total_tagihan;
            $pesanan->kode_booking = $request->kode_booking;
            $pesanan->seat = $request->seat;
            $pesanan->user_id = $request->user_id;
            $pesanan->rute_id = $request->rute_id;
            $pesanan->metode_pembayaran_id = $request->metode_pembayaran_id;
            $pesanan->pembayaran_id = $request->pembayaran_id;
            $pesanan->update();

            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil diperbarui',
                'data' => $pesanan,
            ], 200);
        } else {
            return response()->json(['message' => 'Gagal memperbarui data'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    // Remove the specified resource from storage.
    public function destroy(pesanan $pesanan)
    {
        try {
            $pesanans = $pesanan->delete();
    
            if ($pesanans) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil dihapus',
                ], 200);
            } else {
                return response()->json(['message' => 'Gagal menghapus data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}