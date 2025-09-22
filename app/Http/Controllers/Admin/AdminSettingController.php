<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingController extends Controller
{
    public function index()
    {
        return view('admin.adminSetting');
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        if ($request->action === 'username') {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $admin->name = $request->name;
            $admin->save();

            return back()->with('success', 'Username berhasil diperbarui.');
        }

        if ($request->action === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('error', 'Password lama tidak sesuai.');
            }

            $admin->password = Hash::make($request->password);
            $admin->save();

            return back()->with('success', 'Password berhasil diperbarui.');
        }

        return back()->with('error', 'Aksi tidak dikenali.');
    }
}
