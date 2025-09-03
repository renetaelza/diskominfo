<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pemberitahuan Penjadwalan Ulang Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://opendata.bandung.go.id/api/static/upload/ace5b1bfee5336794c8cc24eb2c5cdc8b1fe26f11297a22562f3c81a5be55839.png" alt="Logo DISKOMINFO" style="max-width: 150px;">
    </div>
    <h2>Pemberitahuan Penjadwalan Ulang Kunjungan</h2>
    <p>Halo, {{ $kunjungan->nama }}.</p>
    <p>
        Dengan hormat, kami memberitahukan bahwa ada perubahan jadwal untuk pengajuan kunjungan Anda.
    </p>
    <p>
        Jadwal sebelumnya: <strong>{{ \Carbon\Carbon::parse($oldDate)->format('d F Y') }} pukul {{ \Carbon\Carbon::parse($oldTime)->format('H:i') }}</strong>
    </p>
    <p style="font-size: 1.1em;">
        Jadwal baru Anda adalah: <strong style="color: #2196f3;">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d F Y') }} pukul {{ \Carbon\Carbon::parse($kunjungan->pukul_kunjungan)->format('H:i') }}</strong>
    </p>
    <p>
        Status kunjungan Anda kini telah <strong>DISETUJUI</strong> dengan jadwal baru tersebut. Mohon untuk hadir tepat waktu.
    </p>
    <p>
        Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami di nomor telepon: <strong>(022) 123-4567</strong>.
    </p>
    <p>Terima kasih atas perhatian dan pengertian Anda.</p>
    <br>
    <p>Hormat kami,</p>
    <p><strong>Admin DISKOMINFO</strong></p>
</body>
</html>
