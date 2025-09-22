{{-- resources/views/admin/agenda/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Edit Agenda</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.agenda._form')
                
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Cari elemen input file berdasarkan ID-nya
    document.getElementById('foto').addEventListener('change', function(event) {
        
        // Ambil file yang dipilih oleh pengguna
        const file = event.target.files[0];

        // Jika ada file yang dipilih
        if (file) {
            // Tentukan batas maksimal ukuran file dalam bytes (2MB)
            const maxSize = 2 * 1024 * 1024; 

            // Periksa apakah ukuran file melebihi batas maksimal
            if (file.size > maxSize) {
                
                // Tampilkan alert menggunakan SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ukuran file tidak boleh lebih dari 2MB!',
                });

                // Kosongkan kembali nilai input file
                event.target.value = '';
            }
        }
    });
</script>
@endpush