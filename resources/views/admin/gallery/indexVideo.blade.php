@extends('layouts.admin')

@section('title', 'Galeri | Video')

@section('content')
{{-- Inisialisasi Alpine.js untuk kontrol modal --}}
<div class="h-screen flex flex-col" x-data="{ showModal: false, showEditModal: false, showDeleteModal: false, deleteUrl: '', editData: null }">

    <!-- 🔘 Header & Tombol Tambah -->
    <div class="sticky top-0 z-40 bg-white dark:bg-gray-800 md:px-10 shadow-md px-10 py-3 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Galeri Video</h3>
        <button 
            @click="showModal = true" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md text-sm font-medium flex items-center gap-2"
        >
            <i class="fas fa-plus mr-2"></i>
            Tambah Video
        </button>
    </div>

    <!-- 🔳 Layout Konten Utama -->
    <div class="flex-1 px-6 md:px-10 py-5 overflow-y-auto bg-gray-100 dark:bg-gray-900">
        
        <!-- Tabel Video -->
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <!-- Pencarian -->
            <div class="p-4">
                <form action="{{ route('main.galeri.video') }}" method="GET">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari video berdasarkan judul atau deskripsi..." 
                            class="w-full pl-10 pr-4 py-2 border rounded-lg bg-gray-100 border-gray-400 text-gray-900"
                            value="{{ request('search') }}"
                        >
                        <div class="absolute top-0 left-0 inline-flex items-center p-2 h-full text-gray-400">
                           <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-400">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">Thumbnail</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Tanggal Upload</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($videos as $video)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3">
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" class="w-24 h-14 object-cover rounded" alt="Thumbnail">
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ Str::limit($video->title, 50) }}</td>
                            <td class="px-4 py-3">{{ $video->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                @if ($video->is_featured)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        Featured
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <!-- Tombol Edit -->
                                <button type="button" 
                                    @click="editData = {{ json_encode($video) }}; showEditModal = true"
                                    title="Edit" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <button type="button" 
                                    @click="showDeleteModal = true; deleteUrl = '{{ route('admin.galeri.video.destroy', $video->id) }}'"
                                    title="Hapus" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">
                                <p class="text-gray-500 dark:text-gray-400">
                                    @if(request('search'))
                                        Video dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                                    @else
                                        Belum ada video yang diunggah.
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <!-- Paginasi -->
            <div class="p-4">
                {{ $videos->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah Video --}}
    <div
        x-show="showModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-lg mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300"
            @click.away="showModal = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Video Baru</h2>
                <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('admin.galeri.video.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-1">
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link YouTube</label>
                        <input
                            id="youtube_url" type="url" name="youtube_url"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://www.youtube.com/watch?v=xxxx"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Judul & deskripsi akan diambil otomatis dari link.</p>
                    </div>

                    <div class="flex items-center space-x-2 pt-2">
                        <input
                            id="is_featured" type="checkbox" name="is_featured" value="1"
                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500"
                        >
                        <label for="is_featured" class="text-sm text-gray-700 dark:text-gray-300">Jadikan video utama (Featured)</label>
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showModal = false" class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex items-center px-5 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Video --}}
    <div
        x-show="showEditModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div
            class="relative w-full max-w-lg mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300"
            @click.away="showEditModal = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Video</h2>
                <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('admin.galeri.video.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" x-model="editData.id">
                    
                    <div class="space-y-1">
                        <label for="edit_youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link YouTube</label>
                        <input
                            id="edit_youtube_url" type="url" name="youtube_url"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://www.youtube.com/watch?v=xxxx"
                            :value="editData ? 'https://www.youtube.com/watch?v=' + editData.youtube_id : ''"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">*Jika hanya mengubah link, maka akan memperbarui judul & deskripsi otomatis.</p>
                    </div>

                    <div class="space-y-1">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input
                            id="edit_title" type="text" name="title"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            x-model="editData.title"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea
                            id="edit_description" name="description" rows="4"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            x-text="editData.description"
                        ></textarea>
                    </div>

                    <div class="flex items-center space-x-2 pt-2">
                        <input
                            id="edit_is_featured" type="checkbox" name="is_featured" value="1"
                            :checked="editData && editData.is_featured"
                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500"
                        >
                        <label for="edit_is_featured" class="text-sm text-gray-700 dark:text-gray-300">Jadikan video utama (Featured)</label>
                    </div>

                    <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex items-center px-5 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="showDeleteModal" x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 transition-opacity duration-300 bg-gray-900 bg-opacity-70"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    >
        <div class="relative w-full max-w-md mx-auto my-6 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300" 
            @click.away="showDeleteModal = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Apakah Anda yakin?</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Data video ini akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-center gap-4">
                <button @click="showDeleteModal = false" type="button" class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">
                    Batal
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Notifikasi Sukses & Error --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({ toast: true, position: 'top', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: @json(session('success')) });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({ toast: true, position: 'top', showConfirmButton: false, timer: 4000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: @json(session('error')) });
            });
        </script>
    @endif
</div>
@endsection

@push('scripts')
{{-- Pastikan Font Awesome sudah terpasang di layout utama Anda --}}
<script>
    // Script tambahan bisa diletakkan di sini jika diperlukan
</script>
@endpush
