<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\pembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class PembayaranController extends Controller
{
    /**
     * Menampilkan semua pembayaran.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayarans = pembayaran::all();
        if ($pembayarans) {
        return response()->json(
            ['code' => 200, 'message' => 'Data Dapat Terlihat', 'data' => $pembayarans],
            200,
        );  } else {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    /**
     * Menampilkan formulir untuk membuat pembayaran baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan pembayaran yang baru dibuat ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
              'nama_transfer' => ['required','string'],
            'nomor_rekening' => ['required','string'],
            'bank_transfer' => ['required','string'],
            'jam_transfer' => ['required','string'],
            'nominal_transfer' => ['required','string'],
            ]);
    
            $pembayarans = pembayaran::create($validatedData);
    
            if ($pembayarans) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil disimpan',
                    'data' => $pembayarans,
                ], 200);
            } else {
                return response()->json(['message' => 'Gagal menyimpan data'], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan detail pembayaran.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            // Find the pembayaran by its ID
            $pembayaran = pembayaran::findOrFail($id);
    
            // Check if the pembayaran exists
            if (!$pembayaran) {
                return response()->json(['message' => ' pembayaran not found'], 404);
            }
    
            // Return the pembayaran data
            return response()->json([
                'code' => 200,
                'message' => 'pembayaran retrieved successfully',
                'data' => $pembayaran,
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Menampilkan formulir untuk mengedit pembayaran.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
//
    }

    /**
     * Memperbarui pembayaran yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pembayaran $pembayaran)
    {
        try {
            $validatedData = $request->validate([
                'nama_transfer' => ['required','string'],
                'nomor_rekening' => ['required','string'],
                'bank_transfer' => ['required','string'],
                'jam_transfer' => ['required','string'],
                'nominal_transfer' => ['required','string'],
                ]);
    
            // Update the pembayaran instance with the validated data
            $pembayaran->update($validatedData);
    
            // Retrieve the updated pembayaran
            $updatedPembayaran = pembayaran::find($pembayaran->id);
    
            if ($updatedPembayaran) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diperbarui',
                    'data' => $updatedPembayaran,
                ], 200);
            } else {
                return response()->json(['message' => 'Gagal memperbarui data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus pembayaran dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            // Find the pembayaran by its ID
            $pembayaran = pembayaran::findOrFail($id);
    
            // Check if the embayaran exists
            if (!$pembayaran) {
                return response()->json(['message' => 'pembayaran not found'], 404);
            }
    
            // Delete the pembayaran
            $pembayaran->delete();
    
            // Return a success response
            return response()->json(['message' => ' pembayaran deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
}