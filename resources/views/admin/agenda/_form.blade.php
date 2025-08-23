{{-- resources/views/admin/agenda/_form.blade.php --}}

@csrf
<div class="space-y-6">
    {{-- Nama Agenda --}}
    <div>
        <label for="nama_agenda" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nama Agenda</label>
        <input type="text" name="nama_agenda" id="nama_agenda" value="{{ old('nama_agenda', isset($agenda) ? $agenda->nama_agenda : '') }}" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    {{-- Kategori --}}
    <div>
        <label for="kategori_id" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Kategori / Bidang</label>
        <select name="kategori_id" id="kategori_id" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @foreach ($bidang as $item)
                <option value="{{ $item->id }}" @selected(old('kategori_id', isset($agenda) ? $agenda->kategori_id : null) == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="deskripsi" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('deskripsi', isset($agenda) ? $agenda->deskripsi : '') }}</textarea>
    </div>
    
    {{-- Tanggal --}}
    <div>
        <label for="tanggal" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', isset($agenda) ? $agenda->tanggal->format('Y-m-d') : '') }}" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    {{-- Lokasi --}}
    <div>
        <label for="lokasi" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', isset($agenda) ? $agenda->lokasi : '') }}" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    {{-- Foto --}}
    <div>
        <label for="foto" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Foto</label>
        <input type="file" name="foto" id="foto" class="w-full p-2 border rounded">
        @if (isset($agenda) && $agenda->foto)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>
                <img src="{{ asset('storage/' . $agenda->foto) }}" alt="{{ $agenda->nama_agenda }}" class="h-40 w-auto rounded-md">
            </div>
        @endif
    </div>
</div>