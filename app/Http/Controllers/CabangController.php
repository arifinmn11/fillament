<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangController extends Controller
{

    public function updateCabang(Request $request)
    {
        $auth = Auth::user();
        $user = User::where('id', $auth->id)->first();
        $user->cabang_id = $request->cabang_id;
        $user->save();

        return redirect()->back()->with('success', 'Cabang updated successfully.');
    }
}
