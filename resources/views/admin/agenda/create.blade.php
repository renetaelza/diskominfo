@extends('layouts.admin')

@section('title', 'Tambah Agenda Baru')

@section('content')
    {{-- Header bar for the title --}}
    <div class="bg-white dark:bg-gray-800 shadow-md pl-6 pr-6 py-5 mb-6 flex items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white px-4">Tambah Agenda Baru</h3>
    </div>

    {{-- The form itself with padding --}}
    <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data" class="px-10">
        {{-- The main form card --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            @include('admin.agenda._form')

            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </div>
    </form>
@endsection