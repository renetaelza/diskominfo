@extends('layouts.admin')

@section('title', 'Manajemen Agenda')

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }">

        {{-- Header Bar --}}
        <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Agenda</h3>
            <a href="{{ route('admin.agenda.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                <i class="fas fa-plus mr-2"></i> Tambah Agenda
            </a>
        </div>

        <div class="px-10">

            {{-- Toast Notification --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter & Search Bar --}}
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.agenda.index') }}" class="flex gap-4 items-start w-full">

                    {{-- Filter Dropdown --}}
                    <div class="relative" x-data="{ openFilter: false }">
                        @php
                            // Count active filters
                            $filterCount =
                                (request()->filled('kategori_id') ? 1 : 0) +
                                (request()->filled('start_date') ? 1 : 0) +
                                (request()->filled('end_date') ? 1 : 0);
                        @endphp
                        <button type="button" @click="openFilter = !openFilter"
                            class="relative h-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 text-sm text-gray-800 flex items-center gap-2 dark:bg-gray-700">
                            <i class="fas fa-filter"></i> Filter
                            @if ($filterCount > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $filterCount }}</span>
                            @endif
                        </button>

                        <div x-show="openFilter"
                             @click.outside="if (!$event.target.closest('.flatpickr-calendar')) openFilter = false"
                             x-transition
                             class="absolute z-40 mt-2 w-72 bg-white border border-gray-200 rounded shadow-lg p-4 space-y-4"
                             style="display: none;">

                            {{-- Kategori Filter --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Kategori</label>
                                <select name="kategori_id"
                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 text-sm bg-white">
                                    <option value="">Semua</option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b->id }}" {{ request('kategori_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Date Range Filter --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Agenda</label>
                                <div class="flex items-center gap-2">
                                    <input x-data x-init="flatpickr($el, { dateFormat: 'Y-m-d' })"
                                           type="text" name="start_date" value="{{ request('start_date') }}"
                                           placeholder="Dari tanggal"
                                           class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md bg-white text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                    <input x-data x-init="flatpickr($el, { dateFormat: 'Y-m-d' })"
                                           type="text" name="end_date" value="{{ request('end_date') }}"
                                           placeholder="Sampai tanggal"
                                           class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md bg-white text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.agenda.index') }}"
                                   class="text-sm text-blue-600 hover:underline">Reset Filter</a>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Terapkan</button>
                            </div>
                        </div>
                    </div>

                    {{-- Search Bar --}}
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari agenda berdasarkan nama..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                    </div>
                </form>
            </div>

            {{-- Table Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-auto shadow">
                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Nama Agenda</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($agendas as $agenda)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $agenda->nama_agenda }}</td>
                                <td class="px-4 py-3">{{ $agenda->bidang->nama }}</td>
                                <td class="px-4 py-3">{{ $agenda->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.agenda.edit', $agenda) }}" title="Edit"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" title="Hapus"
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('admin.agenda.destroy', $agenda) }}'"
                                        class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                    Tidak ada agenda yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $agendas->links() }}
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-sm shadow-lg text-center">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Yakin ingin menghapus agenda ini?</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-center gap-4">
                    <button @click="showDeleteModal = false"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium">Batal</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm font-medium">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
