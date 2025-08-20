<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Videos; // Pastikan nama model Anda adalah Videos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk memanggil API YouTube
use Illuminate\Support\Facades\Log; // Untuk logging error

class GalleryController extends Controller
{
    /**
     * Menampilkan halaman daftar video.
     */
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

                // LOGIKA DIPERBAIKI: Bandingkan dengan data lama di DB
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
}
