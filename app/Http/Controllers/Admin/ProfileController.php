<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller {
    
    public function edit() {
        $user = auth()->user() ?? User::first() ?? new User(['name' => 'Admin Riska', 'email' => 'admin@test.com']);
        return view('admin', [
            'page' => 'profile',
            'user' => $user,
            'users' => [], 
            'chartLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        ]);
    }

    public function update(Request $request) {
        $user = auth()->user() ?? User::first();
        
        if (!$user) {
            $user = new User();
            $user->password = bcrypt('admin123');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->back()->with('success', 'Profil Berhasil Diperbarui!');
    }
}