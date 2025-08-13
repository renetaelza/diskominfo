<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Bidang;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('bidang')->latest()->paginate(10);
        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        $bidang = Bidang::all();
        return view('admin.agenda.create', compact('bidang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:bidang,id',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('agenda-fotos', 'public');
        }

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        $bidang = Bidang::all();
        return view('admin.agenda.edit', compact('agenda', 'bidang'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:bidang,id',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if it exists
            if ($agenda->foto) {
                Storage::disk('public')->delete($agenda->foto);
            }
            $validated['foto'] = $request->file('foto')->store('agenda-fotos', 'public');
        }

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        // Delete photo from storage
        if ($agenda->foto) {
            Storage::disk('public')->delete($agenda->foto);
        }
        
        $agenda->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
