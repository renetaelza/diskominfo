@extends('layouts.admin')

@section('title', 'Manajemen Kunjungan')

@section('content')
<div x-data="{}">

    {{-- Header Bar --}}
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Pengajuan Kunjungan</h3>
    </div>

    <div class="px-10">
        {{-- Toast Notification --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter & Search Form -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.kunjungan.index') }}" class="flex gap-4 items-start w-full">
                <!-- Filter Button & Dropdown -->
                <div class="relative" x-data="{ openFilter: false }">
                    <button type="button" @click="openFilter = !openFilter"
                        class="h-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-sm text-gray-800 flex items-center gap-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="openFilter" @click.away="openFilter = false" x-transition
                        class="absolute z-40 mt-2 w-64 bg-white border border-gray-200 rounded shadow-lg p-4 space-y-4 dark:bg-gray-800 dark:border-gray-700" style="display: none;">
                        
                        <div>
                            <div class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Status</div>
                            <div class="space-y-1">
                                @foreach(['pending', 'approved', 'rejected'] as $status)
                                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                    <input type="checkbox" name="status[]" value="{{ $status }}"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ in_array($status, request()->get('status', [])) ? 'checked' : '' }}>
                                    {{ ucfirst($status) }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-3 w-full px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                            Terapkan
                        </button>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="flex-1">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nama atau instansi..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white text-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
            </form>
        </div>
        
        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-auto shadow">
            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Nama Pemohon</th>
                        <th class="px-4 py-3">Instansi</th>
                        <th class="px-4 py-3">Tanggal Kunjungan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($kunjungans as $kunjungan)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $kunjungan->nama }}</td>
                        <td class="px-4 py-3">{{ $kunjungan->nama_instansi }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if($kunjungan->status == 'pending')
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">Pending</span>
                            @elseif($kunjungan->status == 'approved')
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Approved</span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" title="Lihat Detail" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">
                            Tidak ada pengajuan kunjungan yang cocok dengan filter Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{-- This ensures pagination links include the search/filter query --}}
            {{ $kunjungans->links() }}
        </div>
    </div>
</div>
@endsection