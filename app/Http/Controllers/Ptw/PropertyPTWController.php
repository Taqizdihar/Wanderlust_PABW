<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use Illuminate\Support\Facades\File;

class PropertyPTWController extends Controller {
    public function index(Request $request) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $query = TempatWisata::with(['fotoTempatWisata', 'tiketTempatWisata'])->where('id_ptw', $ptw->id_ptw);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_wisata', 'like', "%{$search}%");
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('jenis_wisata', $request->category);
        }

        $properties = $query->get();
        $categories = ['Nature', 'Historical', 'Amusement Park', 'Education', 'Other'];

        return view('ptw.properties', compact('user', 'ptw', 'properties', 'categories'));
    }

    public function destroy($id) {
        $property = TempatWisata::where('id_wisata', $id)->firstOrFail();

        $property->delete();

        return redirect()->back()->with('success', 'Properti berhasil dihapus.');
    }
}