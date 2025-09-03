@extends('layouts.admin')

@section('title', 'Manajemen Visi & Misi')

@section('content')
    <div x-data="{
        showModal: false,
        isEdit: false,
        mission: {},
        formUrl: '',
        initEdit(missionData, url) {
            this.isEdit = true;
            this.mission = missionData;
            this.formUrl = url;
            this.showModal = true;
        },
        initCreate(url) {
            this.isEdit = false;
            this.mission = { content: '', icon_class: '' };
            this.formUrl = url;
            this.showModal = true;
        },
        confirmDelete(event) {
            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data misi ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    }">

        {{-- Header Bar --}}
        <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800 dark:text-white">Manajemen Visi & Misi</h3>
        </div>

        <div class="px-10 space-y-8">
            {{-- Toast Notification --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 1. Form Visi --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h4 class="text-lg font-semibold mb-4">Kelola Visi</h4>
                <form action="{{ route('admin.vision.update') }}" method="POST">
                    @csrf
                    <textarea name="content" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Tuliskan visi di sini...">{{ $vision->content ?? '' }}</textarea>
                    <div class="text-right mt-4">
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Simpan Visi
                        </button>
                    </div>
                </form>
            </div>

            {{-- 2. Tabel Misi --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 flex justify-between items-center">
                    <h4 class="text-lg font-semibold">Kelola Misi</h4>
                    <button @click="initCreate('{{ route('admin.mission.store') }}')"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Misi
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-600 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3 w-16 text-center">No</th>
                                <th class="px-4 py-3 w-24 text-center">Ikon</th>
                                <th class="px-4 py-3">Isi Misi</th>
                                <th class="px-4 py-3 w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($missions as $mission)
                                <tr>
                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-center text-2xl text-blue-500">
                                        <i class="{{ $mission->icon_class }}"></i>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $mission->content }}
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-4">
                                        <button
                                            @click.prevent="initEdit({{ json_encode($mission) }}, '{{ route('admin.mission.update', $mission) }}')"
                                            title="Edit" class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('admin.mission.destroy', $mission) }}" method="POST"
                                            class="inline-block" @submit.prevent="confirmDelete($event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                        Belum ada data misi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Modal untuk Tambah/Edit Misi --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background Overlay --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="formUrl" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                                x-text="isEdit ? 'Edit Misi' : 'Tambah Misi Baru'"></h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="content"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Misi</label>
                                    <textarea name="content" x-model="mission.content" id="content" rows="3" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>
                                <div>
                                    <label for="icon_class"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas Ikon
                                        (Bootstrap Icons)</label>
                                    <input type="text" name="icon_class" x-model="mission.icon_class" id="icon_class"
                                        required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Contoh: bi bi-people-fill">
                                    <p class="text-xs text-gray-500 mt-1">
                                        Cari nama kelas di <a href="https://icons.getbootstrap.com/" target="_blank"
                                            class="text-blue-500 hover:underline">Bootstrap Icons</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm"
                                x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Misi'"></button>
                            <button type="button" @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
