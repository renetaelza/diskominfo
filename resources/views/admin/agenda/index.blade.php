@extends('layouts.admin')

@section('title', 'Manajemen Agenda')

@section('content')
{{-- We add x-data here to control the delete confirmation modal --}}
<div x-data="{ showDeleteModal: false, deleteUrl: '' }">
    
    {{-- ✅ CHANGE: New header bar, separated from the content --}}
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Agenda</h3>
        <a href="{{ route('admin.agenda.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
            <i class="fas fa-plus mr-2"></i> Tambah Agenda
        </a>
    </div>

    <div class="px-10">
        {{-- ✅ CHANGE: New toast notification for session messages --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- ✅ CHANGE: Table is now wrapped in its own card --}}
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
                                {{-- ✅ CHANGE: Action buttons now use icons --}}
                                <a href="{{ route('admin.agenda.edit', $agenda) }}" title="Edit" class="text-blue-600 hover:text-blue-800">
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
                            <td colspan="4" class="text-center py-10 text-gray-500">
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

    {{-- ✅ ADDED: Alpine.js-powered Delete Confirmation Modal --}}
    <div
        x-show="showDeleteModal"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
        style="display: none">
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