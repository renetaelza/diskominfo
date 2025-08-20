<!DOCTYPE html>
<html>
<head>
    <title>Update Status Pengajuan Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Pemberitahuan Status Pengajuan Kunjungan</h2>
    <p>Halo, {{ $kunjungan->nama }}.</p>
    <p>
        Dengan hormat, kami memberitahukan bahwa pengajuan kunjungan Anda ke kantor kami pada tanggal 
        <strong>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d F Y') }}</strong> 
        telah kami proses dengan status sebagai berikut:
    </p>

    @if($kunjungan->status == 'approved')
        <p style="font-size: 1.2em; color: green; font-weight: bold;">DISETUJUI</p>
        <p>Kami menantikan kedatangan Anda dan rombongan. Mohon untuk hadir tepat waktu.</p>
    @elseif($kunjungan->status == 'rejected')
        <p style="font-size: 1.2em; color: red; font-weight: bold;">DITOLAK</p>
        <p>Mohon maaf, pengajuan Anda belum dapat kami setujui saat ini. Terima kasih atas pengertiannya.</p>
    @endif

    <p>Terima kasih atas perhatian Anda.</p>
    <br>
    <p>Hormat kami,</p>
    <p><strong>Admin DISKOMINFO</strong></p>
</body>
</html>
