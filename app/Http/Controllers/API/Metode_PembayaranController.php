<?php

namespace App\Http\Controllers\API;

use Exception;

use App\Models\metode_pembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as IlluminateValidationException;

class Metode_PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $metode_pembayarans = metode_pembayaran::all();
       if ($metode_pembayarans) {
        return response()->json(
            ['code' => 200, 'message' => 'Data Dapat Terlihat', 'data' => $metode_pembayarans],
            200,
        );  } else {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
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
    try {
        $validatedData = $request->validate([
            'jenis_pembayaran' => ['required', 'string'],
            'bank' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        $metode_pembayarans = metode_pembayaran::create($validatedData);

        if ($metode_pembayarans) {
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil disimpan',
                'data' => $metode_pembayarans,
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Find the metode_pembayaran by its ID
            $metode_pembayaran = metode_pembayaran::findOrFail($id);
    
            // Check if the metode_pembayaran exists
            if (!$metode_pembayaran) {
                return response()->json(['message' => 'Metode pembayaran not found'], 404);
            }
    
            // Return the metode_pembayaran data
            return response()->json([
                'code' => 200,
                'message' => 'Metode pembayaran retrieved successfully',
                'data' => $metode_pembayaran,
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
    public function update(Request $request, metode_pembayaran $metode_pembayaran)
{
    try {
        $validatedData = $request->validate([
            'jenis_pembayaran' => ['required', 'string'],
            'bank' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        // Update the metode_pembayaran instance with the validated data
        $metode_pembayaran->update($validatedData);

        // Retrieve the updated metode_pembayaran
        $updatedMetodePembayaran = metode_pembayaran::find($metode_pembayaran->id);

        if ($updatedMetodePembayaran) {
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil diperbarui',
                'data' => $updatedMetodePembayaran,
            ], 200);
        } else {
            return response()->json(['message' => 'Gagal memperbarui data'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    try {
        // Find the metode_pembayaran by its ID
        $metode_pembayaran = metode_pembayaran::findOrFail($id);

        // Check if the metode_pembayaran exists
        if (!$metode_pembayaran) {
            return response()->json(['message' => 'Metode pembayaran not found'], 404);
        }

        // Delete the metode_pembayaran
        $metode_pembayaran->delete();

        // Return a success response
        return response()->json(['message' => 'Metode pembayaran deleted successfully'], 200);
    } catch (\Exception $e) {
        // Handle any exceptions and return an error response
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
}
