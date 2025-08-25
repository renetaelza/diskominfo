<!-- Modal Tambah -->
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
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Folder Baru</h2>
                <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('admin.galeri.folders.store') }}" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="space-y-1">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Folder</label>
                        <input
                            id="title" type="text" name="title"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan judul folder..."
                            required
                        >
                    </div>

                    <!-- Description -->
                    <div class="space-y-1">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea
                            id="description" name="description" rows="3"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Opsional"
                        ></textarea>
                    </div>

                    <!-- Folder Date -->
                    <div class="space-y-1">
                        <label for="folder_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Folder</label>
                        <input
                            id="folder_date" type="date" name="folder_date"
                            class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
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