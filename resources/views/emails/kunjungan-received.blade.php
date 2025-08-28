<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Kunjungan Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://opendata.bandung.go.id/api/static/upload/ace5b1bfee5336794c8cc24eb2c5cdc8b1fe26f11297a22562f3c81a5be55839.png" alt="Logo DISKOMINFO" style="max-width: 150px;">
    </div>
    <h2>Terima Kasih, Pengajuan Kunjungan Anda Telah Kami Terima</h2>
    <p>Halo, {{ $kunjungan->nama }}.</p>
    <p>
        Kami telah menerima pengajuan kunjungan Anda dengan detail sebagai berikut:
    </p>
    <ul>
        <li><strong>Nama Instansi:</strong> {{ $kunjungan->nama_instansi }}</li>
        <li><strong>Tanggal Diajukan:</strong> {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d F Y') }}</li>
        <li><strong>Waktu Diajukan:</strong> {{ \Carbon\Carbon::parse($kunjungan->pukul_kunjungan)->format('H:i') }}</li>
        <li><strong>Topik Diskusi:</strong> {{ $kunjungan->topik_diskusi }}</li>
    </ul>
    <p>
        Tim kami akan segera meninjau ketersediaan jadwal. Anda akan menerima email konfirmasi final (disetujui/ditolak).
    </p>
    <p>
        Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami di nomor telepon: <strong>(022) 123-4567</strong>.
    </p>
    <br>
    <p>Hormat kami,</p>
    <p><strong>Admin DISKOMINFO</strong></p>
</body>
</html>
