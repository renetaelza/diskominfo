@extends('layouts.admin')

@section('title', 'Edit Pengajuan Kunjungan')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
    <h3 class="font-semibold text-gray-800 dark:text-white">Edit Pengajuan Kunjungan</h3>
    <a href="{{ route('admin.kunjungan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg shadow transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="px-10">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.kunjungan.update', $kunjungan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama & Instansi --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pemohon</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $kunjungan->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="nama_instansi" class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                    <input type="text" name="nama_instansi" id="nama_instansi" value="{{ old('nama_instansi', $kunjungan->nama_instansi) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('nama_instansi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                {{-- Tanggal & Pukul Kunjungan --}}
                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" id="tanggalKunjungan" value="{{ old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('tanggal_kunjungan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="pukul_kunjungan" class="block text-sm font-medium text-gray-700">Pukul Kunjungan</label>
                    <select name="pukul_kunjungan" id="pukulKunjungan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Pilih Waktu</option>
                        @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '13:00'] as $time)
                        <option value="{{ $time }}" @selected(old('pukul_kunjungan', \Carbon\Carbon::parse($kunjungan->pukul_kunjungan)->format('H:i')) == $time)>{{ $time }}</option>
                        @endforeach
                    </select>
                    <div id="time-slot-message" class="text-red-500 mt-1 text-sm"></div>
                    @error('pukul_kunjungan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2" id="availability-display" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700">Waktu yang Tersedia:</label>
                    <div id="available-times-container" class="flex flex-wrap gap-2 mt-2">
                        {{-- Badges will be inserted here --}}
                    </div>
                </div>
                
                {{-- Tujuan OPD & Topik Diskusi --}}
                <div class="md:col-span-2">
                    <label for="bidang_ids" class="block text-sm font-medium text-gray-700">Tujuan OPD</label>
                    <select name="bidang_ids[]" id="bidang_ids" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach($bidang as $item)
                        <option value="{{ $item->id }}" @selected($kunjungan->bidangs->contains($item->id))>{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="topik_diskusi" class="block text-sm font-medium text-gray-700">Topik Diskusi</label>
                    <textarea name="topik_diskusi" id="topik_diskusi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('topik_diskusi', $kunjungan->topik_diskusi) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">
                    Update Kunjungan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bidang_ids').select2();
        
        const dateInput = $('#tanggalKunjungan');
        const timeSelect = $('#pukulKunjungan');
        const timeSlotMessage = $('#time-slot-message');
        const availabilityDisplay = $('#availability-display');
        const availableTimesContainer = $('#available-times-container');
        const currentKunjunganId = {{ $kunjungan->id }}; // Get the current visit ID

        function checkAvailability() {
            const selectedDate = dateInput.val();
            timeSlotMessage.text('');
            availabilityDisplay.hide();
            availableTimesContainer.empty();
            
            if (!selectedDate) return;

            // Pass the current visit ID to be ignored in the check
            $.get(`/api/unavailable-times?date=${selectedDate}&ignore_id=${currentKunjunganId}`, function(data) {
                timeSelect.find('option').prop('disabled', false);

                if (data.is_unavailable) {
                    timeSlotMessage.text('Tanggal ini tidak tersedia karena ada agenda lain.');
                    availableTimesContainer.html('<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak ada waktu yang tersedia</span>');
                } else {
                    const allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00"];
                    const unavailableTimes = data.unavailable_times;

                    unavailableTimes.forEach(time => timeSelect.find(`option[value="${time}"]`).prop('disabled', true));
                    
                    const availableTimes = allTimes.filter(time => !unavailableTimes.includes(time));

                    if (availableTimes.length > 0) {
                        availableTimes.forEach(time => {
                            const badge = `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">${time}</span>`;
                            availableTimesContainer.append(badge);
                        });
                    } else {
                        availableTimesContainer.html('<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak ada waktu yang tersedia</span>');
                    }
                }
                availabilityDisplay.show();
            });
        }

        dateInput.on('change', checkAvailability);
        checkAvailability(); // Run on page load
    });
</script>
@endpush
@endsection
