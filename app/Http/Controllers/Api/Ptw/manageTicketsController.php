<?php

namespace App\Http\Controllers\Api\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TiketTempatWisata;
use App\Models\TempatWisata;
use Illuminate\Support\Facades\Validator;

class manageTicketsController extends Controller {

    public function index($id_wisata) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id_wisata)
                                ->where('id_ptw', $ptw->id_ptw)
                                ->first();

        if (!$property) {
            return response()->json(['message' => 'Properti tidak ditemukan atau akses ditolak'], 404);
        }

        $tickets = TiketTempatWisata::where('id_wisata', $id_wisata)->get();

        return response()->json([
            'success' => true,
            'data' => $tickets
        ], 200);
    }

    public function store(Request $request, $id_wisata) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id_wisata)
                                ->where('id_ptw', $ptw->id_ptw)
                                ->first();

        if (!$property) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_tiket' => 'required|string|max:255',
            'harga'      => 'required|numeric',
            'jumlah'     => 'required|integer',
            'deskripsi'  => 'required|string',
            'foto_tiket' => 'nullable|string' // Sesuaikan jika menggunakan file upload
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket = TiketTempatWisata::create([
            'id_wisata'  => $id_wisata,
            'nama_tiket' => $request->nama_tiket,
            'harga'      => $request->harga,
            'jumlah'     => $request->jumlah,
            'deskripsi'  => $request->deskripsi,
            'foto_tiket' => $request->foto_tiket,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil ditambahkan',
            'data'    => $ticket
        ], 201);
    }

    public function show($id_tiket) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $ticket = TiketTempatWisata::where('id_tiket', $id_tiket)
            ->whereHas('tempatWisata', function($query) use ($ptw) {
                $query->where('id_ptw', $ptw->id_ptw);
            })->first();

        if (!$ticket) {
            return response()->json(['message' => 'Tiket tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $ticket], 200);
    }

    public function update(Request $request, $id_tiket) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $ticket = TiketTempatWisata::where('id_tiket', $id_tiket)
            ->whereHas('tempatWisata', function($query) use ($ptw) {
                $query->where('id_ptw', $ptw->id_ptw);
            })->first();

        if (!$ticket) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $ticket->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data tiket berhasil diperbarui',
            'data'    => $ticket
        ], 200);
    }

    public function destroy($id_tiket) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $ticket = TiketTempatWisata::where('id_tiket', $id_tiket)
            ->whereHas('tempatWisata', function($query) use ($ptw) {
                $query->where('id_ptw', $ptw->id_ptw);
            })->first();

        if (!$ticket) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $ticket->delete();

        return response()->json(['message' => 'Tiket berhasil dihapus'], 200);
    }
}