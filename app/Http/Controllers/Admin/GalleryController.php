<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Videos;
use App\Models\Folder;
use App\Models\FolderPhoto; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    //CONTROLLER VIDEO
    public function indexVideo(Request $request)
    {
        // Logika untuk menampilkan semua video dengan pencarian dan paginasi
        $query = Videos::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.gallery.indexVideo', compact('videos'));
    }

    // Menyimpan data video baru ke database.
    public function storeVideo(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'youtube_url' => 'required|url',
            'is_featured' => 'nullable|boolean',
        ]);

        try {
            // 2. Ekstrak YouTube ID dari URL
            $youtubeId = $this->getYouTubeId($request->youtube_url);

            if (!$youtubeId) {
                return back()->with('error', 'Link YouTube tidak valid atau tidak dapat diproses.');
            }
            
            // Cek apakah video sudah ada
            if (Videos::where('youtube_id', $youtubeId)->exists()) {
                return back()->with('error', 'Video ini sudah ada di galeri.');
            }

            // 3. Ambil data dari YouTube Data API
            $apiKey = env('YOUTUBE_API_KEY'); // Simpan API Key Anda di file .env
            $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id={$youtubeId}&key={$apiKey}&part=snippet";
            
            $response = Http::get($apiUrl);
            $videoData = $response->json();

            if (empty($videoData['items'])) {
                return back()->with('error', 'Tidak dapat menemukan detail video dari YouTube. Pastikan link benar.');
            }

            $snippet = $videoData['items'][0]['snippet'];
            $title = $snippet['title'];
            $description = $snippet['description'];

            // 4. Logika untuk 'is_featured'
            $isFeatured = $request->has('is_featured') && $request->is_featured == '1';
            
            if ($isFeatured) {
                // Nonaktifkan semua video 'featured' yang lain terlebih dahulu
                Videos::where('is_featured', true)->update(['is_featured' => false]);
            }

            // 5. Simpan data ke database
            Videos::create([
                'youtube_id' => $youtubeId,
                'title' => $title,
                'description' => $description,
                'is_featured' => $isFeatured,
            ]);

            // 6. Redirect dengan pesan sukses
            return redirect()->route('admin.galeri.video')->with('success', 'Video berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Tangani jika ada error (misal: API key tidak valid, dll)
            Log::error('Gagal menambahkan video: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan video.');
        }
    }

    public function updateVideo(Request $request)
    {
        // 1. Validasi semua input yang masuk dari form edit
        $request->validate([
            'id' => 'required|exists:videos,id',
            'youtube_url' => 'required|url',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        try {
            // Cari video yang akan diupdate berdasarkan ID
            $video = Videos::findOrFail($request->id);

            // Ekstrak ID YouTube dari URL yang baru diinput
            $newYoutubeId = $this->getYouTubeId($request->youtube_url);

            if (!$newYoutubeId) {
                return back()->with('error', 'Link YouTube baru tidak valid.');
            }

            // Siapkan data yang akan diupdate
            $updateData = [];

            // 2. Logika utama: Cek apakah link YouTube diubah
            if ($newYoutubeId !== $video->youtube_id) {
                // Cek duplikat jika ID berubah
                if (Videos::where('youtube_id', $newYoutubeId)->where('id', '!=', $video->id)->exists()) {
                    return back()->with('error', 'Video dengan link baru ini sudah ada di galeri.');
                }

                // Karena link berubah, panggil API untuk data baru
                $apiKey = env('YOUTUBE_API_KEY');
                $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id={$newYoutubeId}&key={$apiKey}&part=snippet";
                
                $response = Http::get($apiUrl);
                $videoData = $response->json();

                if (empty($videoData['items'])) {
                    return back()->with('error', 'Tidak dapat menemukan detail video dari link YouTube yang baru.');
                }

                $snippet = $videoData['items'][0]['snippet'];

                // Bandingkan dengan data lama di DB
                // Jika judul dari form SAMA DENGAN judul lama di DB, berarti admin tidak mengubahnya. Gunakan dari API.
                // Jika berbeda, berarti admin sengaja mengubahnya. Gunakan input manual admin.
                $updateData['title'] = ($request->title === $video->title) ? $snippet['title'] : $request->title;
                $updateData['description'] = ($request->description === $video->description) ? $snippet['description'] : $request->description;
                $updateData['youtube_id'] = $newYoutubeId;

            } else {
                // Jika link tidak berubah, cukup gunakan input manual dari form
                $updateData['title'] = $request->title;
                $updateData['description'] = $request->description;
            }

            // 3. Logika untuk 'is_featured' (selalu dijalankan)
            $isFeatured = $request->has('is_featured') && $request->is_featured == '1';
            
            if ($isFeatured) {
                // Nonaktifkan semua video 'featured' yang lain
                Videos::where('id', '!=', $video->id)->update(['is_featured' => false]);
            }
            $updateData['is_featured'] = $isFeatured;

            // 4. Update data di database
            $video->update($updateData);

            return redirect()->route('admin.galeri.video')->with('success', 'Video berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui video: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui video.');
        }
    }

    // Delete Video
    public function destroy(Videos $video)
    {
        try {
            $video->delete();
            return redirect()->route('admin.galeri.video')->with('success', 'Video berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus video: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus video.');
        }
    }

    
    /**
     * Fungsi helper untuk mengekstrak ID dari berbagai format URL YouTube.
    *
    * @param string $url
    * @return string|null
    */
    private function getYouTubeId($url)
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
    //END CONTROLLER VIDEO


    //CONTROLLER FOLDER & FOTO

    public function indexFolders(Request $request)
    {
        // 1. Ambil input pencarian dari request
        $q = $request->input('q');

        // 2. Bangun query dasar ke database
        $foldersQuery = Folder::query()
            ->when($q, function ($query, $q) {
                // Tambahkan kondisi pencarian hanya jika '$q' ada isinya
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->withCount('photos') // Contoh relasi, bisa disesuaikan
            ->latest(); // Urutkan dari yang terbaru

        // 3. Eksekusi query dengan paginasi
        //    ->paginate() membatasi data per halaman (efisien)
        //    ->withQueryString() memastikan link paginasi (untuk tabel) tetap membawa parameter pencarian
        $folders = $foldersQuery->paginate(15)->withQueryString();

        // 4. Cek jenis permintaan (AJAX atau biasa)
        if ($request->ajax()) {
            return response()->json([
                'items' => view('admin.gallery.partials._folder_grid_items', compact('folders'))->render(),
                'next_page_url' => $folders->nextPageUrl()
            ]);
        }

        // 5. Jika ini permintaan biasa dari browser,
        //    tampilkan view Blade lengkap seperti biasa.
        return view('admin.gallery.indexFolder', compact('folders', 'q'));
    }

    public function storeFolder(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder_date' => 'nullable|date',
        ]);
        
        Folder::create($data);

        return back()->with('success', 'Folder berhasil dibuat.');
    }

    public function updateFolder(Request $request, Folder $folder)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder_date' => 'nullable|date',
        ]);

        try {
            // 2. Perbarui record folder dengan data yang sudah divalidasi
            $folder->update($validatedData);

            // 3. Arahkan kembali ke halaman daftar folder dengan pesan sukses
            return redirect()->route('admin.galeri.folders')
                             ->with('success', "Folder '{$folder->title}' berhasil diperbarui.");

        } catch (\Exception $e) {
            // Jika terjadi error, catat di log
            Log::error('Gagal memperbarui folder: ' . $e->getMessage());

            // Arahkan kembali dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat memperbarui folder.');
        }
    }

    public function destroyFolder(Folder $folder)
    {
        try {
            $folderTitle = $folder->title;

            // 1. Loop semua foto yang ada di dalam folder
            foreach ($folder->photos as $photo) {
                // 2. Hapus setiap file fisik dari storage
                Storage::disk('public')->delete($photo->image_path);
            }
            
            // 3. Hapus record folder (ini akan otomatis menghapus record foto terkait karena relasi database)
            $folder->delete();

            return redirect()->route('admin.galeri.folders')
                             ->with('success', "Folder '{$folderTitle}' dan semua isinya berhasil dihapus.");

        } catch (\Exception $e) {
            Log::error('Gagal menghapus folder: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus folder.');
        }
    }

    public function showFolder(Folder $folder)
    {
        // Tampilkan grid foto dalam folder
        $photos = $folder->photos()->latest()->get();

        return view('admin.gallery.indexPhoto', compact('folder', 'photos'));
    }

    public function storePhoto(Request $request, Folder $folder)
    {

        // 1. Definisikan aturan validasi
        $rules = [
            'photos' => 'required|array',
            // Aturan ini berlaku untuk SETIAP file di dalam array 'photos'
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:20480' //20mb
        ];

        // 2. Definisikan pesan error kustom
        $messages = [
            'photos.*.image' => 'File yang diupload harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'photos.*.max' => 'Ukuran setiap gambar tidak boleh lebih dari 20MB.',
        ];

        // Validasi file yang diupload
        $request->validate($rules, $messages);

        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $file) {
                // =========================================================
                // 1. BUAT NAMA FILE CUSTOM
                // Format: folder_{id folder}_{kode unik}.{ekstensi asli}
                // Contoh: folder_42_65a4c3e1b2d3f.jpg
                // =========================================================
                $extension = $file->getClientOriginalExtension();
                $filename = 'folder_' . $folder->id . '_' . uniqid() . '.' . $extension;

                // =========================================================
                // 2. SIMPAN FILE DENGAN NAMA BARU
                // Menggunakan storeAs() untuk menentukan nama file secara manual.
                // File akan disimpan di: storage/app/public/photos/
                // =========================================================
                $path = $file->storeAs('photos', $filename, 'public');

                // =========================================================
                // 3. BUAT RECORD DI DATABASE
                // Menggunakan model FolderPhoto dan kolom image_path.
                // Saya asumsikan relasi di model Folder Anda bernama 'photos'.
                // =========================================================
                $folder->photos()->create([
                    'image_path' => $path
                ]);
            }
        }

        return back()->with('success', 'Gambar berhasil diupload!');
    }

    public function destroyPhoto(FolderPhoto $photo)
    {
        try {
            // 1. Hapus file fisik dari storage
            Storage::disk('public')->delete($photo->image_path);

            // 2. Hapus record dari database
            $photo->delete();

            return back()->with('success', 'Foto berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto.');
        }
    }
    //END CONTROLLER FOLDER & FOTO
}
