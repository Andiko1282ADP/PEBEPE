<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\pembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Illuminate\Http\Response; // Add this line
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
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
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validatedData['image'] = $imagePath;
            }

            $pembayaran = pembayaran::create($validatedData);

            return response()->json([
                'code' => Response::HTTP_CREATED,
                'message' => 'Data berhasil disimpan',
                'data' => $pembayaran,
            ], Response::HTTP_CREATED);
        } catch (IlluminateValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pembayaran = pembayaran::findOrFail($id);
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Pembayaran retrieved successfully',
                'data' => $pembayaran,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
    public function update(Request $request, pembayaran $pembayaran)
    {
        try {
            $validatedData = $request->validate([
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
            ]);

            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($pembayaran->image) {
                    Storage::disk('public')->delete($pembayaran->image);
                }
                $imagePath = $request->file('image')->store('images', 'public');
                $validatedData['image'] = $imagePath;
            }

            $pembayaran->update($validatedData);

            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Data berhasil diperbarui',
                'data' => $pembayaran,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pembayaran = pembayaran::findOrFail($id);

            // Delete the image if it exists
            if ($pembayaran->image) {
                Storage::disk('public')->delete($pembayaran->image);
            }

            $pembayaran->delete();

            return response()->json(['message' => 'Pembayaran deleted successfully'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}