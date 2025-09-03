@extends('layouts.admin')

@section('title', 'Galeri Foto - Folder')

@section('content')
<div 
    x-data="galleryManager()" 
    x-init="init('{{ $folders->nextPageUrl() }}')" 
    x-cloak 
    x-ref="gallery"
    class="h-full flex flex-col"
>
    <div class="bg-white dark:bg-gray-800 shadow-md px-6 md:px-10 py-2 my-1 flex justify-between items-center">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Manajemen Folder Galeri</h3>
        <div class="flex space-x-2 items-center">
            <button @click="setView('table')" :class="view === 'table' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent'" class="px-3 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition"><i class="fas fa-table"></i></button>
            <button @click="setView('grid')" :class="view === 'grid' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-transparent'" class="px-3 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition"><i class="fas fa-th"></i></button>
            <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2 transition"><i class="fas fa-plus"></i> Folder Baru</button>
        </div>
    </div>

    <div id="content-container" class="flex-1 px-6 md:px-10 py-5 overflow-y-auto">
        <div class="mb-5">
            <form action="{{ route('admin.galeri.folders') }}" method="GET">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari folder..." class="w-full pl-10 pr-4 py-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $q ?? '' }}">
                    <div class="absolute top-0 left-0 inline-flex items-center p-2 h-full text-gray-400"><i class="fas fa-search"></i></div>
                </div>
            </form>
        </div>

        <div x-show="view === 'grid'">
             @if ($folders->isNotEmpty())
                <div id="folder-grid-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-x-6 gap-y-8">
                    @include('admin.gallery.partials._folder_grid_items', ['folders' => $folders])
                </div>

                <div class="text-center py-6">
                    <div id="scroll-trigger" x-show="!isComplete">
                        <span x-show="loading"><i class="fas fa-spinner fa-spin"></i> Memuat...</span>
                    </div>
                    <div x-show="isComplete" class="text-gray-400">-- Anda telah mencapai akhir --</div>
                </div>

            @else
                <div class="text-center py-10">
                    <p class="text-sm text-gray-500">
                        @if(request('q'))
                            Folder dengan kata kunci "{{ request('q') }}" tidak ditemukan.
                        @else
                            Belum ada folder yang dibuat.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <div x-show="view === 'table'">
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg mt-12">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Folder</th>
                                <th class="px-4 py-3 text-left">Deskripsi</th>
                                <th class="px-4 py-3 text-center">Jumlah Foto</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($folders as $folder)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.galeri.folders.show', $folder->id) }}" class="hover:underline">{{ $folder->title }}</a>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="truncate max-w-sm" title="{{ $folder->description }}">{{ $folder->description }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                            {{ $folder->photos_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-4">
                                        <button @click="editFolder({{ $folder }})" title="Edit" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-pen"></i></button>
                                        <button @click="confirmDelete('{{ route('admin.galeri.folders.destroy', $folder->id) }}')" title="Hapus" class="text-red-500 hover:text-red-700"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Sesuaikan colspan menjadi 4 --}}
                                    <td colspan="4" class="text-center py-10">
                                        <p class="text-sm text-gray-500">
                                            @if(request('q'))
                                                Folder dengan kata kunci "{{ request('q') }}" tidak ditemukan.
                                            @else
                                                Belum ada folder yang dibuat.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $folders->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('admin.gallery.partials.modal-tambah')
    @include('admin.gallery.partials.modal-edit')
    @include('admin.gallery.partials.modal-delete')

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
<script>
    function galleryManager() {
        return {
            // STATE
            view: localStorage.getItem('galleryView') || 'grid',
            showModal: false, showEditModal: false, showDeleteModal: false, deleteUrl: '', editData: null,
            nextPageUrl: '', loading: false, isComplete: false,

            // FUNGSI INISIALISASI
            init(nextUrl) {
                this.nextPageUrl = nextUrl;
                if (!this.nextPageUrl) {
                    this.isComplete = true;
                    return;
                }
                this.isComplete = false; // Reset status jika kita dapat URL
                
                const trigger = document.getElementById('scroll-trigger');
                const contentContainer = document.getElementById('content-container');
                if (trigger && contentContainer) {
                    const options = { root: contentContainer, rootMargin: '0px 0px 300px 0px' };
                    const observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting && !this.loading && !this.isComplete) {
                            this.loadMore();
                        }
                    }, options);
                    observer.observe(trigger);
                    setTimeout(() => this.checkAndLoadIfNeeded(), 200);
                }
            },

            // FUNGSI GANTI VIEW
            setView(newView) {
                const url = new URL(window.location.href);
                const currentPage = url.searchParams.get('page') || 1;

                // Simpan page terakhir kalau kita lagi di table
                if (this.view === 'table') {
                    localStorage.setItem('galleryTablePage', currentPage);
                }

                this.view = newView;
                localStorage.setItem('galleryView', newView);

                if (newView === 'grid') {
                    // Hapus page param untuk grid (selalu mulai awal)
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                } else if (newView === 'table') {
                    // Baca page terakhir dari localStorage (kalau ada)
                    const savedPage = localStorage.getItem('galleryTablePage') || 1;
                    url.searchParams.set('page', savedPage);
                    window.location.href = url.toString();
                }
            },

            // FUNGSI CEK OTOMATIS
            async checkAndLoadIfNeeded() {
                if (this.loading || this.isComplete) return;
                const trigger = document.getElementById('scroll-trigger');
                if (!trigger) return;
                const contentContainer = document.getElementById('content-container');
                const isVisible = () => {
                    if (!contentContainer) return false;
                    const containerRect = contentContainer.getBoundingClientRect();
                    const triggerRect = trigger.getBoundingClientRect();
                    return triggerRect.top <= containerRect.bottom;
                };
                while (isVisible() && !this.isComplete) {
                    await this.loadMore();
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
            },
            
            // FUNGSI MEMUAT DATA BARU
            async loadMore() {
                if (!this.nextPageUrl || this.loading) {
                    if (!this.nextPageUrl) this.isComplete = true;
                    return;
                }
                this.loading = true;
                try {
                    const response = await fetch(this.nextPageUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const data = await response.json();
                    const container = document.getElementById('folder-grid-container');

                    if (container && data.items) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.items;
                        Array.from(tempDiv.children).forEach(newNode => {
                            container.appendChild(newNode);
                            Alpine.initTree(newNode);
                        });
                    }
                    this.nextPageUrl = data.next_page_url;
                    if (!this.nextPageUrl) { this.isComplete = true; }
                } catch (error) {
                    console.error('Gagal memuat data:', error);
                    this.isComplete = true;
                } finally {
                    this.loading = false;
                }
            },

            // FUNGSI UNTUK MODALS
            editFolder(folder) {
                this.editData = folder;
                this.showEditModal = true;
            },
            confirmDelete(url) {
                this.deleteUrl = url;
                this.showDeleteModal = true;
            }
        }
    }
</script>
@endpush