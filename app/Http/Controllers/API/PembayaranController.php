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
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pembayarans = pembayaran::all();
            foreach ($pembayarans as $pembayaran) {
                if ($pembayaran->image) {
                    $pembayaran->image = base64_encode($pembayaran->image);
                }
            }
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Data retrieved successfully',
                'data' => $pembayarans,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
                $imageFile = $request->file('image');
                $imageName = time().'.'.$imageFile->extension();  
                $imageFile->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $pembayaran = pembayaran::create($validatedData);

            return response()->json([
                'code' => Response::HTTP_CREATED,
                'message' => 'Data saved successfully',
                'data' => $pembayaran,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error: ' . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pembayaran = pembayaran::findOrFail($id);
            if ($pembayaran->image) {
                $pembayaran->image = base64_encode($pembayaran->image);
            }
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Data retrieved successfully',
                'data' => $pembayaran,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => 'Data not found: ' . $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
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
                $imageFile = $request->file('image');
                $imageName = time().'.'.$imageFile->extension();  
                $imageFile->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $pembayaran->update($validatedData);

            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Data updated successfully',
                'data' => $pembayaran,
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error: ' . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pembayaran = pembayaran::findOrFail($id);
            $pembayaran->delete();

            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => 'Data deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}