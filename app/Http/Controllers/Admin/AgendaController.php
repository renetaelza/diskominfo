<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Bidang;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with('bidang');

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_agenda', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $agendas = $query->latest()->paginate(10)->withQueryString();
        $bidang = Bidang::all();

        return view('admin.agenda.index', compact('agendas', 'bidang'));
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
