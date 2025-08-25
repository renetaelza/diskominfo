<!-- modal edit -->
<div
    x-show="showEditModal"
    x-cloak
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-70"
>
    {{-- Kita tambahkan `if (editData)` agar tidak error saat `editData` masih null --}}
    <div
        x-show="showEditModal"
        @click.away="showEditModal = false"
        x-transition
        class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow-2xl"
        x-if="editData"
    >
        {{-- Header Modal --}}
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit Folder "<span x-text="editData.title"></span>"
            </h2>
            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Body Modal (Form) --}}
        <div class="p-6">
            {{-- Form action dibuat dinamis dengan `:action` --}}
            <form 
                method="POST" 
                :action="`/admin/galeri/folders/${editData.id}`" {{-- Sesuaikan URL jika perlu --}}
                class="space-y-4"
            >
                @csrf
                @method('PUT') {{-- Atau 'PATCH' --}}

                {{-- Judul Folder --}}
                <div>
                    <label for="edit_title" class="block mb-1 text-sm font-medium">Judul Folder</label>
                    {{-- Nilai input diikat ke `editData.title` dengan `x-model` atau `:value` --}}
                    <input
                        id="edit_title"
                        type="text"
                        name="title"
                        :value="editData.title"
                        class="block w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border rounded-lg"
                        required
                    >
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="edit_description" class="block mb-1 text-sm font-medium">Deskripsi</label>
                    <textarea
                        id="edit_description"
                        name="description"
                        rows="3"
                        x-text="editData.description"
                        class="block w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border rounded-lg"
                    ></textarea>
                </div>
                
                {{-- Tanggal Folder --}}
                <div>
                    <label for="edit_folder_date" class="block mb-1 text-sm font-medium">Tanggal Folder</label>
                    <input
                        id="edit_folder_date"
                        type="date"
                        name="folder_date"
                        :value="editData.folder_date"
                        class="block w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border rounded-lg"
                    >
                </div>


                {{-- Footer Modal (Tombol Aksi) --}}
                <div class="flex justify-end pt-4 space-x-2">
                    <button 
                        type="button" 
                        @click="showEditModal = false" 
                        class="px-4 py-2 text-sm font-medium bg-gray-200 rounded-lg hover:bg-gray-300"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>