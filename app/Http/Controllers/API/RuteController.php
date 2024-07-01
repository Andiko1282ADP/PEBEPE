<?php

namespace App\Http\Controllers\API;
use Exception;

use App\Models\rute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException as IlluminateValidationException;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $rute = rute::with('pesanans')->get();

        if ($rute) {
         return response()->json(
             ['code' => 200, 'message' => 'Data Dapat Terlihat', 'data' => $rute],
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

    /**x
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kota_asal' => ['required', 'string'],
                'kota_tujuan' => ['required', 'string'],
                'jam_berangkat' => ['required', 'date'],
                'jam_tiba' => ['required', 'date'],
                'tarif' => ['required', 'string'],
                'titik_pemberangkatan' => ['required', 'string'],
            ]);
    
    
            $rutes = rute::create([
                'kota_asal' => $request->kota_asal,
                'kota_tujuan' => $request->kota_tujuan,
                'jam_berangkat' => $request->jam_berangkat,
                'jam_tiba' => $request->jam_tiba,
                'tarif' => $request->tarif,
                'titik_pemberangkatan' => $request->titik_pemberangkatan,
            ]);
    
            if ($rutes) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data Dapat Terlihat',
                    'data' => $rutes,
                ], 200);
            } else {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(rute $rute)
{
    try {
        // Pastikan bahwa 'Rute' adalah penamaan yang benar untuk model Anda
        $rute = rute::with('pesanans')->findOrFail($rute->id);
        return response()->json([
            'code' => 200,
            'message' => 'Data Dapat Terlihat',
            'data' => $rute
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (\Exception $e) {
        // Tangkap pengecualian umum jika ada yang terlewat
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
    public function update(Request $request, Rute $rutes)
{
    try {
        $validatedData = $request->validate([
            // Define validation rules for the fields you want to update
                'kota_asal' => ['required', 'string', 'min:3', 'max:255'],
                'kota_tujuan' => ['required', 'string','min:3', 'max:255'],
                'jam_berangkat' => ['required', 'date',],
                'jam_tiba' => ['required', 'date'],
                'tarif' => ['required', 'string'],
                'titik_pemberangkatan' => ['required', 'string'],
        ]);

        // Update the rute instance with the validated data
        $rutes->update($validatedData);

        // Retrieve the updated rute
        $updatedrute = rute::find($rutes->id);

        if ($updatedrute) {
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil diperbarui',
                'data' => $updatedrute,
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
        // Find the rute by its ID
        $rutes = Rute::findOrFail($id);

        // Check if the rute exists
        if (!$rutes) {
            return response()->json(['message' => 'Rute not found'], 404);
        }

        // Delete the rute
        $rutes->delete();

        // Return a success response
        return response()->json(['message' => 'Rute deleted successfully'], 200);
    } catch (\Exception $e) {
        // Handle any exceptions and return an error response
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

}
