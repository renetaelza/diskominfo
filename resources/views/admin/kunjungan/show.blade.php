@extends('layouts.admin')

@section('title', 'Detail Kunjungan')

@section('content')
<div x-data="{}"> {{-- Alpine.js scope --}}

    {{-- Header Bar --}}
    <div class="bg-white dark:bg-gray-800 shadow-md px-10 py-3 mb-6 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-white">Detail Pengajuan Kunjungan</h3>
        <a href="{{ route('admin.kunjungan.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-sm font-medium rounded-lg shadow transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="px-10">
        {{-- Toast Notifications --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Main content card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-auto shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Data Pemohon</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Nama</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $kunjungan->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Instansi</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $kunjungan->nama_instansi }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Nomor HP</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $kunjungan->nomor_hp }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Email</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $kunjungan->email }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Data Kunjungan</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Tanggal & Waktu</dt>
                            <dd class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d F Y') }} pukul {{ \Carbon\Carbon::parse($kunjungan->pukul_kunjungan)->format('H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Topik Diskusi</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $kunjungan->topik_diskusi }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Tujuan OPD</dt>
                            <dd class="text-gray-900 dark:text-white">
                                <ul class="list-disc list-inside">
                                    @foreach($kunjungan->bidangs as $bidang)
                                    <li>{{ $bidang->nama }}</li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 text-sm">Surat Permohonan</dt>
                            <dd><a href="{{ asset('storage/' . $kunjungan->surat_permohonan) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Surat <i class="fas fa-external-link-alt text-xs ml-1"></i></a></dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($kunjungan->status == 'pending')
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold mb-4">Tindakan</h3>
                <div class="flex space-x-4">
                    <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition">
                            <i class="fas fa-check mr-2"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow transition">
                            <i class="fas fa-times mr-2"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection