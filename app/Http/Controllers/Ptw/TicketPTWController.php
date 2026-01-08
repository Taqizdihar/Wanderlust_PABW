<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use App\Models\TiketTempatWisata;
use Illuminate\Support\Facades\File;

class TicketPTWController extends Controller {
    public function index(Request $request, $id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)->where('id_ptw', $ptw->id_ptw)->firstOrFail();
		$query = $property->tiketTempatWisata(); 

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_tiket', 'like', "%{$search}%");
        }

        $tickets = $query->get();

        return view('ptw.tickets.index', compact('user', 'ptw', 'property', 'tickets'));
    }


    public function destroy($id) {

        $ticket = TiketTempatWisata::findOrFail($id);

        if ($ticket->url_foto && File::exists(public_path($ticket->url_foto))) {
            File::delete(public_path($ticket->url_foto));
        }

        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus.');
    }
}