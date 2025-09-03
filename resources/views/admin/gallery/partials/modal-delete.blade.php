{{-- resources/views/admin/gallery/partials/modal-delete.blade.php --}}
<div 
    x-show="showDeleteModal" 
    x-cloak 
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-70"
>
    <div 
        @click.away="showDeleteModal = false"
        x-show="showDeleteModal"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl"
    >
        <div class="p-6 text-center">
            {{-- Ikon Peringatan --}}
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
            </div>
            
            {{-- Judul dan Deskripsi --}}
            <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Apakah Anda yakin?</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{-- Teks sudah disesuaikan untuk folder --}}
                    Folder ini akan dihapus secara permanen. Semua foto di dalamnya juga akan terhapus. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        
        {{-- Tombol Aksi --}}
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 flex rounded-xl justify-center gap-4">
            <button 
                @click="showDeleteModal = false" 
                type="button" 
                class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500"
            >
                Batal
            </button>
            
            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-5 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>