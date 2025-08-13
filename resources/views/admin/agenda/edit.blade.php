{{-- resources/views/admin/agenda/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Edit Agenda</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            {{-- ✅ This action points to 'update' and REQUIRES $agenda --}}
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