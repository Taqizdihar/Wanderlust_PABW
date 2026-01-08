<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\TiketTempatWisata;

class EditTicketPTWController extends Controller {

    public function edit($id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $ticket = TiketTempatWisata::findOrFail($id);

        $property = $ticket->tempatWisata;

        return view('ptw.tickets.edit', compact('user', 'ptw', 'ticket', 'property'));
    }

    public function update(Request $request, $id){
        $ticket = TiketTempatWisata::findOrFail($id);

        if ($request->filled('nama_tiket')) $ticket->nama_tiket = $request->nama_tiket;
        if ($request->filled('harga')) $ticket->harga = $request->harga;
        if ($request->filled('jumlah')) $ticket->jumlah = $request->jumlah;
        if ($request->filled('deskripsi')) $ticket->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_tiket')) {
            if ($ticket->foto_tiket && File::exists(public_path($ticket->foto_tiket))) {
                File::delete(public_path($ticket->foto_tiket));
            }

            $file = $request->file('foto_tiket');
            $filename = time() . '_tiket_edit_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/tickets'), $filename);
            
            $ticket->foto_tiket = 'images/tickets/' . $filename;
        }

        $ticket->save();

        return redirect()->route('properties.ptw.tickets', $ticket->id_wisata)->with('success', 'Ticket updated successfully!');
    }
}