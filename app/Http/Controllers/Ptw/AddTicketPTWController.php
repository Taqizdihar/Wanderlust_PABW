<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use App\Models\TiketTempatWisata;

class AddTicketPTWController extends Controller {

    public function create($id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)
                    ->where('id_ptw', $ptw->id_ptw)
                    ->firstOrFail();

        return view('ptw.tickets.add', compact('user', 'ptw', 'property'));
    }

    public function store(Request $request, $id) {
        $request->validate([
            'nama_tiket' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required',
            'foto_tiket' => 'required|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto_tiket')) {
            $file = $request->file('foto_tiket');
            $filename = time() . '_tiket_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/tickets'), $filename);
            $path = 'images/tickets/' . $filename;
        }

        TiketTempatWisata::create([
            'id_wisata' => $id,
            'nama_tiket' => $request->nama_tiket,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'foto_tiket' => $path
        ]);

        return redirect()->route('properties.ptw.tickets', $id)->with('success', 'Ticket added successfully!');
    }
}
