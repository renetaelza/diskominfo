<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OrgChart</title>
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        #tree-wrapper { width: 100%; height: 100vh; overflow: auto; }

        #tree{
            width:100%;
            height:100%;
        }
    </style>
</head>
<body>
    <div id="tree-wrapper">
        <div id="tree"></div>
    </div>

    <script>
        const pegawaiData = @json($pegawai);

        const nodes = pegawaiData.map(p => {
            const tags = p.is_assistant == 1 ? ["assistant"] : [];
            
            return {
                id: p.id,
                pid: p.atasan_id,
                name: p.nama,
                title: p.jabatan,
                img: p.foto_base64,
                tupoksi: p.tupoksi,
                tags: tags,
                nip: p.nip,
                bidang: p.bidang ? p.bidang.nama : 'Tidak Ada',
                atasan: p.atasan ? p.atasan.nama : 'Tidak Ada',
                is_assistant: p.is_assistant,
                alamat: p.alamat,
                foto_url: p.foto_base64,
                bawahan: p.bawahan
            };
        });

        // 🔹 Duplikat template olivia agar foto lebih kecil
        OrgChart.templates.anaSmall = Object.assign({}, OrgChart.templates.ana);

        // Ubah bagian image → perkecil ukurannya
        // OrgChart.templates.anaSmall.img_0 =
        //     '<image preserveAspectRatio="xMidYMid slice" width="50" height="50" x="10" y="30" xlink:href="{val}" />';

        // Kalau mau bulatkan gambarnya, bisa pakai clipPath:
        OrgChart.templates.anaSmall.img_0 =
          '<clipPath id="anaSmallClip"><circle cx="35" cy="35" r="25"/></clipPath>' +
          '<image preserveAspectRatio="xMidYMid slice" width="50" height="50" x="10" y="10" clip-path="url(#anaSmallClip)" xlink:href="{val}" />';

        const chart = new OrgChart(document.getElementById("tree"), {
            template: "anaSmall",  // 🔹 ganti pakai template baru
            enableSearch: false,
            nodeMouseClick: OrgChart.action.none,
            mouseScrool: OrgChart.action.none,
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
            },
            tags: {
                "assistant": { template: "anaSmall" } // 🔹 supaya asisten ikut kecil
            },
            menu: {
                png_export: { text: "Export PNG" }
            },
            nodes: nodes
        });

        chart.on('export', function(sender, args){
            args.styles[".node"] = "overflow: visible;";
            args.padding = 50; // tambah ruang agar gambar atas tidak terpotong
        });
    </script>

</body>
</html>
