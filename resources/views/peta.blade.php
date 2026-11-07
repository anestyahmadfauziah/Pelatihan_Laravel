
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Peta Cabang Toko Suku Cadang</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        #map {
            height: 100vh;
        }
    </style>
</head>

<body>

    <!-- Tampilan Peta -->
    <div id="map"></div>

    <!-- Tombol Cabang Terdekat -->
    <button id="btn-near"
        style="position:absolute; z-index:1000; top:10px; right:10px;
               padding:8px 12px; cursor:pointer;">
        Cabang Terdekat
    </button>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>

        // Mengambil data cabang dari Laravel
        const branches = @json($branches);

        // Membuat peta dan menentukan titik tengah
        const map = L.map('map').setView([-6.2, 106.82], 12);

        // Menampilkan peta dasar OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        // =====================================
        // LANGKAH 6: MENAMPILKAN MARKER DAN POPUP
        // =====================================

        const markers = [];

        branches.forEach(b => {
            const m = L.marker([b.latitude, b.longitude]).addTo(map);

            m.bindPopup('<b>' + b.nama + '</b><br>' + b.alamat);

            markers.push(m);
        });

        // Mengatur zoom agar semua marker terlihat
        if (markers.length) {
            map.fitBounds(
                L.featureGroup(markers).getBounds().pad(0.2)
            );
        }


        // =====================================
        // LANGKAH 7: FITUR CABANG TERDEKAT
        // =====================================

        // Fungsi menghitung jarak menggunakan rumus Haversine
        function jarakKm(lat1, lon1, lat2, lon2) {

            const R = 6371;

            const rad = d => d * Math.PI / 180;

            const dLat = rad(lat2 - lat1);
            const dLon = rad(lon2 - lon1);

            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(rad(lat1)) *
                Math.cos(rad(lat2)) *
                Math.sin(dLon / 2) ** 2;

            return 2 * R * Math.asin(Math.sqrt(a));
        }

        // Event ketika tombol Cabang Terdekat diklik
        document.getElementById('btn-near').addEventListener('click', () => {

            if (branches.length === 0) {
                alert('Belum ada data cabang.');
                return;
            }

            navigator.geolocation.getCurrentPosition(pos => {

                const { latitude, longitude } = pos.coords;

                let best = null;

                // Menghitung jarak pengguna ke setiap cabang
                branches.forEach((b, i) => {

                    const d = jarakKm(
                        latitude,
                        longitude,
                        b.latitude,
                        b.longitude
                    );

                    if (!best || d < best.d) {
                        best = { d, i };
                    }
                });

                // Menampilkan lokasi pengguna
                L.circleMarker([latitude, longitude], { radius: 8 }).addTo(map)
                    .bindPopup('Lokasi Anda');

                // Mengambil data cabang terdekat
                const b = branches[best.i];

                // Menampilkan popup nama cabang dan jarak
                markers[best.i]
                    .bindPopup(
                        '<b>' + b.nama + '</b><br>Jarak: ' +
                        best.d.toFixed(2) + ' km'
                    )
                    .openPopup();

                // Mengatur tampilan lokasi pengguna dan cabang terdekat
                map.fitBounds(
                    L.latLngBounds(
                        [[latitude, longitude], [b.latitude, b.longitude]]
                    ).pad(0.3)
                );

            }, () => alert('Lokasi tidak dapat diakses. Periksa izin browser.'));

        });

    </script>

</body>
</html>
