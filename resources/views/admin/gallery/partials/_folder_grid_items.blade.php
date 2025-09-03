@forelse($folders as $folder)
    <div 
        x-data="{ open: false }" 
        @click.away="open = false" 
        class="relative flex flex-col items-center group"
    >
        <div class="relative">
            <a href="{{ route('admin.galeri.folders.show', $folder->id) }}" class="cursor-pointer">
                <i class="fas fa-folder text-[160px] text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors"></i>
            </a>
            <button 
                @click="open = !open" 
                class="absolute -top-1 -right-1 z-10 w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all opacity-0 group-hover:opacity-100"
            >
                <i class="fas fa-ellipsis-v text-xs"></i>
            </button>
            <div 
                x-show="open" 
                x-cloak
                x-transition
                class="absolute top-8 right-0 z-20 w-32 bg-white dark:bg-gray-800 rounded-md shadow-lg border dark:border-gray-700 py-1"
            >
                <button @click="editFolder({{ $folder }}); open = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2">
                    <i class="fas fa-pencil-alt fa-fw"></i> Edit
                </button>
                <button  @click="confirmDelete('{{ route('admin.galeri.folders.destroy', $folder->id) }}')" open = false" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2">
                    <i class="fas fa-trash-alt fa-fw"></i> Hapus
                </button>
            </div>
        </div>
        <h4 class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-200 text-center truncate w-full px-1">
            {{ $folder->title }}
        </h4>
    </div>
@empty
    {{-- Biarkan kosong --}}
@endforelse