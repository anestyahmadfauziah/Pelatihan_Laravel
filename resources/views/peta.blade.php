
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Cabang Toko Suku Cadang</title>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        * { box-sizing: border-box; }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }
        .container-peta {
            display: flex;
            width: 100%;
            height: 100vh;
            min-height: 420px;
            overflow: hidden;
        }
        .sidebar {
            width: 290px;
            flex: 0 0 290px;
            padding: 18px;
            overflow-y: auto;
            background: #f8fafc;
            border-right: 1px solid #e5e7eb;
            z-index: 500;
        }
        .sidebar h3 {
            margin: 0 0 14px;
            font-size: 18px;
        }
        .petunjuk-sidebar {
            margin: 0 0 14px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }
        .item-cabang {
            padding: 12px;
            margin-bottom: 9px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            cursor: pointer;
            transition: .15s ease;
        }
        .item-cabang:hover {
            background: #eff6ff;
            border-color: #93c5fd;
        }
        .item-cabang.active {
            background: #eff6ff;
            border: 2px solid #2563eb;
            padding: 11px;
        }
        .item-cabang b {
            display: block;
            font-size: 14px;
        }
        .item-cabang small {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.4;
        }
        .jenis-toko { color: #2563eb !important; }
        .jenis-bengkel { color: #dc2626 !important; }

        .area-peta {
            position: relative;
            flex: 1;
            min-width: 0;
            height: 100%;
        }
        #map {
            width: 100%;
            height: 100%;
            background: #eaf0f4;
            cursor: crosshair;
        }
        .petunjuk-peta {
            position: absolute;
            z-index: 1000;
            top: 14px;
            left: 14px;
            max-width: min(430px, calc(100% - 28px));
            padding: 11px 14px;
            background: rgba(255,255,255,.97);
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            box-shadow: 0 2px 12px rgba(15,23,42,.12);
            font-size: 12px;
            line-height: 1.5;
            pointer-events: none;
        }
        .petunjuk-peta strong {
            display: block;
            margin-bottom: 2px;
            color: #1e293b;
        }
        #btn-near {
            position: absolute;
            z-index: 1000;
            top: 14px;
            right: 14px;
            padding: 10px 14px;
            cursor: pointer;
            color: #1e40af;
            background: white;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(15,23,42,.12);
            font-weight: 600;
        }
        #btn-near:hover {
            background: #eff6ff;
        }
        .popup-cabang {
            min-width: 210px;
            max-width: 280px;
            line-height: 1.6;
        }
        .popup-cabang h3 {
            margin: 0 0 8px;
            color: #1d4ed8;
            font-size: 15px;
        }
        .popup-koordinat {
            margin-top: 8px;
            padding: 8px;
            background: #f1f5f9;
            border-radius: 6px;
            font-size: 12px;
        }
        .popup-lokasi {
            margin-top: 9px;
            padding: 9px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 7px;
            font-size: 12px;
        }
        .popup-lokasi strong {
            display: block;
            margin-bottom: 4px;
            color: #1d4ed8;
        }
        .popup-lokasi span {
            color: #334155;
        }
        .popup-loading {
            color: #64748b;
            font-style: italic;
        }
        .pin-cabang {
            width: 26px;
            height: 26px;
            border: 3px solid white;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 2px 7px rgba(0,0,0,.35);
            position: relative;
        }
        .pin-cabang::after {
            content: "";
            position: absolute;
            width: 7px;
            height: 7px;
            top: 6px;
            left: 6px;
            border-radius: 50%;
            background: white;
        }
        .pin-toko { background: #2563eb; }
        .pin-bengkel { background: #dc2626; }
        .pin-unknown { background: #64748b; }
        .pin-cabang.terpilih {
            width: 32px;
            height: 32px;
            border-width: 3px;
            box-shadow:
                0 0 0 5px rgba(37,99,235,.20),
                0 3px 9px rgba(0,0,0,.35);
        }
        .pin-cabang.terpilih::after {
            top: 8px;
            left: 8px;
        }
        .leaflet-div-icon {
            background: transparent;
            border: 0;
        }
        .kosong {
            padding: 12px;
            color: #64748b;
            background: white;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
        }
        @media (max-width: 600px) {
            .sidebar {
                width: 125px;
                flex-basis: 125px;
                padding: 9px;
            }
            .sidebar h3 { font-size: 14px; }
            .petunjuk-sidebar { font-size: 10px; }
            .item-cabang { padding: 8px; }
            .item-cabang.active { padding: 7px; }
            .item-cabang b { font-size: 11px; }
            .item-cabang small { font-size: 10px; }

            .petunjuk-peta {
                top: 8px;
                left: 8px;
                max-width: calc(100% - 16px);
                padding: 8px 10px;
                font-size: 10px;
            }
            #btn-near {
                top: auto;
                right: 8px;
                bottom: 15px;
                padding: 9px 10px;
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

<div class="container-peta">
    <aside class="sidebar">
        <h3>Daftar Cabang</h3>
        <p class="petunjuk-sidebar">
            Pilih salah satu cabang terlebih dahulu, lalu klik
            lokasi baru pada peta atau geser pin secara langsung.
        </p>

        <div id="daftar-cabang"></div>
    </aside>

    <main class="area-peta">
        <div id="map"></div>
        <div class="petunjuk-peta">
            <strong id="status-peta">
                Pilih pin cabang yang ingin dipindahkan
            </strong>
            Klik pin atau nama cabang, kemudian klik titik baru
            pada peta. Nama lokasi akan dicari secara otomatis.
        </div>

        <button type="button" id="btn-near">
            📍 Cabang Terdekat
        </button>
    </main>

</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

    const branches = @json($branches);
    const validBranches = branches.filter(branch => {
        const lat = Number(branch.latitude);
        const lng = Number(branch.longitude);

        return Number.isFinite(lat) &&
            Number.isFinite(lng) &&
            Math.abs(lat) <= 90 &&
            Math.abs(lng) <= 180;
    });
    const lokasiCabang = {};
    const requestGeocode = {};
    const map = L.map('map', {
        zoomControl: true
    }).setView([-6.732, 108.552], 12);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }
    ).addTo(map);

    const markers = [];
    let cabangDipilihIndex = null;
    let markerPengguna = null;

    const daftar = document.getElementById('daftar-cabang');
    const statusPeta = document.getElementById('status-peta');

    function formatKoordinat(nilai) {
        const angka = Number(nilai);

        return Number.isFinite(angka)
            ? angka.toFixed(6)
            : '-';
    }

    function escapeHTML(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);
    }

    function jenisCabang(branch) {
        const jenis = String(
            branch.jenis ??
            branch.jenis_lokasi ??
            ''
        ).trim().toLowerCase();

        if (jenis.includes('bengkel')) return 'bengkel';
        if (jenis.includes('toko')) return 'toko';

        return 'lainnya';
    }

    function labelJenis(branch) {
        const jenis = jenisCabang(branch);

        if (jenis === 'bengkel') return 'Bengkel';
        if (jenis === 'toko') return 'Toko';

        return 'Belum ditentukan';
    }

    function namaLokasi(index) {
        return lokasiCabang[index] || 'Belum ditemukan';
    }
    async function cariNamaLokasi(lat, lng, index) {

        const nomorRequest = (requestGeocode[index] || 0) + 1;

        requestGeocode[index] = nomorRequest;

        statusPeta.textContent = 'Sedang mencari nama lokasi...';

        try {

            const url = new URL(
                'https://nominatim.openstreetmap.org/reverse'
            );

            url.searchParams.set('format', 'jsonv2');
            url.searchParams.set('lat', lat);
            url.searchParams.set('lon', lng);
            url.searchParams.set('zoom', '18');
            url.searchParams.set('addressdetails', '1');
            url.searchParams.set('accept-language', 'id');

            const response = await fetch(url.toString(), {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data lokasi');
            }

            const data = await response.json();

            if (requestGeocode[index] !== nomorRequest) {
                return null;
            }

            if (!data || !data.display_name) {
                lokasiCabang[index] = 'Nama lokasi tidak ditemukan';

                return null;
            }

            const alamat = data.address || {};
            const bagianLokasi = [
                alamat.road,
                alamat.neighbourhood,
                alamat.suburb || alamat.village,
                alamat.city_district || alamat.town,
                alamat.city || alamat.county,
                alamat.state
            ];
            const hasilUnik = [
                ...new Set(bagianLokasi.filter(Boolean))
            ];
            lokasiCabang[index] = hasilUnik.length
                ? hasilUnik.join(', ')
                : data.display_name;

            return lokasiCabang[index];

        } catch (error) {
            console.error('Geocoding error:', error);
            lokasiCabang[index] = 'Nama lokasi tidak dapat ditemukan';
            return null;
        }
    }
    function popupCabang(branch, index) {

        const jenis = jenisCabang(branch);

        const kelasJenis =
            jenis === 'bengkel'
                ? 'jenis-bengkel'
                : jenis === 'toko'
                    ? 'jenis-toko'
                    : '';

        const lokasi = namaLokasi(index);

        return `
            <div class="popup-cabang">

                <h3>${escapeHTML(branch.nama || 'Cabang')}</h3>

                <div>
                    <b>Jenis:</b>
                    <span class="${kelasJenis}">
                        ${escapeHTML(labelJenis(branch))}
                    </span>
                </div>

                <div>
                    <b>Alamat:</b>
                    ${escapeHTML(branch.alamat || '-')}
                </div>

                <div class="popup-lokasi">
                    <strong>📍 Nama Lokasi:</strong>
                    <span>${escapeHTML(lokasi)}</span>
                </div>

                <div class="popup-koordinat">

                    <div>
                        <b>Latitude:</b><br>
                        ${formatKoordinat(branch.latitude)}
                    </div>

                    <div>
                        <b>Longitude:</b><br>
                        ${formatKoordinat(branch.longitude)}
                    </div>

                </div>

            </div>
        `;
    }

    function ikonCabang(branch, selected = false) {
        const jenis = jenisCabang(branch);
        let warna = 'pin-unknown';
        if (jenis === 'toko') warna = 'pin-toko';
        if (jenis === 'bengkel') warna = 'pin-bengkel';
        const terpilih = selected ? 'terpilih' : '';

        return L.divIcon({
            className: 'ikon-marker-cabang',
            html: `
                <div class="pin-cabang ${warna} ${terpilih}"></div>
            `,
            iconSize: selected ? [32, 32] : [26, 26],
            iconAnchor: selected ? [16, 30] : [13, 25],
            popupAnchor: [0, -25]
        });
    }

    function perbaruiIkon(index) {
        markers[index].setIcon(
            ikonCabang(
                validBranches[index],
                index === cabangDipilihIndex
            )
        );
    }
    function pilihCabang(index, bukaPopup = true) {

        if (!validBranches[index] || !markers[index]) return;
        const pilihanLama = cabangDipilihIndex;
        cabangDipilihIndex = index;
        if (pilihanLama !== null && markers[pilihanLama]) {
            perbaruiIkon(pilihanLama);
        }
        perbaruiIkon(index);
        document.querySelectorAll('.item-cabang').forEach(item => {
            item.classList.remove('active');
        });

        const item = document.getElementById('cabang-' + index);

        if (item) {
            item.classList.add('active');
            item.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        statusPeta.textContent =
            'Cabang dipilih: ' +
            (validBranches[index].nama || 'Cabang');

        map.panTo(markers[index].getLatLng());

        if (bukaPopup) {
            markers[index].openPopup();
        }
    }

    function perbaruiDaftar(index) {
        const branch = validBranches[index];
        const item = document.getElementById('cabang-' + index);
        if (!item) return;
        const koordinat = item.querySelector('.koordinat-cabang');
        if (koordinat) {
            koordinat.textContent =
                `${formatKoordinat(branch.latitude)}, ${formatKoordinat(branch.longitude)}`;
        }

        const lokasi = item.querySelector('.nama-lokasi-cabang');

        if (lokasi) {
            lokasi.textContent = namaLokasi(index);
        }
    }

    async function pindahkanCabang(index, latlng) {
        const branch = validBranches[index];
        const marker = markers[index];
        if (!branch || !marker) return;
        branch.latitude = Number(latlng.lat);
        branch.longitude = Number(latlng.lng);
        marker.setLatLng(latlng);

        lokasiCabang[index] = 'Sedang mencari nama lokasi...';

        marker.setPopupContent(popupCabang(branch, index));

        perbaruiDaftar(index);

        statusPeta.textContent =
            'Pin dipindahkan. Sedang mencari nama lokasi...';

        marker.openPopup();

        // Cari nama lokasi berdasarkan koordinat baru.
        await cariNamaLokasi(
            branch.latitude,
            branch.longitude,
            index
        );
        // Perbarui popup setelah pencarian selesai.
        if (requestGeocode[index]) {

            marker.setPopupContent(
                popupCabang(branch, index)
            );

            perbaruiDaftar(index);

            marker.openPopup();

            statusPeta.textContent =
                'Lokasi ' +
                (branch.nama || 'cabang') +
                ' berhasil diperbarui: ' +
                namaLokasi(index);
        }
    }

    validBranches.forEach((branch, index) => {

        const position = [
            Number(branch.latitude),
            Number(branch.longitude)
        ];

        const marker = L.marker(position, {

            icon: ikonCabang(branch),

            draggable: true,

            autoPan: true,

            title: branch.nama || 'Cabang'

        }).addTo(map);

        marker.bindPopup(popupCabang(branch, index));

        // Klik marker untuk memilih cabang.
        marker.on('click', () => {

            pilihCabang(index, false);

            marker.openPopup();
        });

        // Saat pin mulai digeser.
        marker.on('dragstart', () => {

            pilihCabang(index, false);

            statusPeta.textContent =
                'Sedang memindahkan pin...';
        });

        // Saat pin selesai digeser.
        marker.on('dragend', event => {

            const posisiBaru = event.target.getLatLng();

            pilihCabang(index, false);

            pindahkanCabang(index, posisiBaru);
        });

        markers.push(marker);

        // Membuat item sidebar.
        const item = document.createElement('div');

        item.className = 'item-cabang';

        item.id = 'cabang-' + index;

        const nama = document.createElement('b');

        nama.textContent = branch.nama || 'Tanpa nama';

        const alamat = document.createElement('small');

        alamat.textContent = branch.alamat || '-';

        const jenis = document.createElement('small');

        jenis.textContent =
            jenisCabang(branch) === 'bengkel'
                ? '🔴 Bengkel'
                : jenisCabang(branch) === 'toko'
                    ? '🔵 Toko'
                    : '⚪ Belum ditentukan';

        jenis.className =
            jenisCabang(branch) === 'bengkel'
                ? 'jenis-bengkel'
                : jenisCabang(branch) === 'toko'
                    ? 'jenis-toko'
                    : '';

        const koordinat = document.createElement('small');

        koordinat.className = 'koordinat-cabang';

        koordinat.textContent =
            `${formatKoordinat(branch.latitude)}, ${formatKoordinat(branch.longitude)}`;

        const lokasi = document.createElement('small');

        lokasi.className = 'nama-lokasi-cabang';

        lokasi.textContent = 'Klik untuk melihat nama lokasi';

        item.append(
            nama,
            alamat,
            jenis,
            koordinat,
            lokasi
        );

        item.addEventListener('click', () => {

            pilihCabang(index);

            map.setView(
                markers[index].getLatLng(),
                16
            );
        });

        daftar.appendChild(item);
    });

    if (markers.length > 0) {

        map.fitBounds(
            L.featureGroup(markers).getBounds().pad(0.2)
        );

    } else {

        daftar.innerHTML = `
            <div class="kosong">
                Belum ada cabang dengan koordinat valid.
            </div>
        `;
    }

    map.on('click', event => {

        if (cabangDipilihIndex === null) {

            statusPeta.textContent =
                'Pilih pin atau nama cabang terlebih dahulu';

            return;
        }

        pindahkanCabang(
            cabangDipilihIndex,
            event.latlng
        );
    });

    const areaLayanan = L.polygon([

        [-6.20, 106.80],
        [-6.20, 106.85],
        [-6.15, 106.85],
        [-6.15, 106.80]

    ], {

        color: '#16a34a',

        fillColor: '#86efac',

        fillOpacity: 0.12,

        weight: 2

    }).addTo(map);

    areaLayanan.bindPopup('Area Layanan Cabang');

    const geojsonData = {
        type: 'FeatureCollection',
        features: [{
            type: 'Feature',
            properties: {
                nama: 'Wilayah Layanan Utama'
            },

            geometry: {
                type: 'Polygon',
                coordinates: [[

                    [106.80, -6.20],
                    [106.85, -6.20],
                    [106.85, -6.15],
                    [106.80, -6.15],
                    [106.80, -6.20]

                ]]
            }
        }]
    };

    L.geoJSON(geojsonData, {

        style: {
            color: '#9333ea',
            fillColor: '#c4b5fd',
            fillOpacity: 0.08,
            weight: 2
        },

        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                feature.properties.nama || 'Wilayah layanan'
            );
        }

    }).addTo(map);

    function jarakKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const rad = derajat =>
            derajat * Math.PI / 180;
        const dLat = rad(lat2 - lat1);
        const dLon = rad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) ** 2 +
            Math.cos(rad(lat1)) *
            Math.cos(rad(lat2)) *
            Math.sin(dLon / 2) ** 2;

        return 2 * R * Math.asin(Math.sqrt(a));
    }

  document.getElementById('btn-near')
        .addEventListener('click', () => {

            if (validBranches.length === 0) {

                alert(
                    'Belum ada data cabang dengan koordinat valid.'
                );

                return;
            }

            if (!navigator.geolocation) {

                alert(
                    'Browser tidak mendukung fitur lokasi.'
                );

                return;
            }

            statusPeta.textContent =
                'Sedang mencari lokasi Anda...';

            navigator.geolocation.getCurrentPosition(

                position => {

                    const latitude =
                        position.coords.latitude;

                    const longitude =
                        position.coords.longitude;

                    let terbaik = null;

                    validBranches.forEach((branch, index) => {

                        const jarak = jarakKm(

                            latitude,
                            longitude,

                            Number(branch.latitude),
                            Number(branch.longitude)
                        );

                        if (!terbaik || jarak < terbaik.jarak) {

                            terbaik = {
                                index,
                                jarak
                            };
                        }
                    });

                    if (markerPengguna) {

                        map.removeLayer(markerPengguna);
                    }

                    markerPengguna = L.circleMarker(

                        [latitude, longitude],

                        {

                            radius: 8,

                            color: '#15803d',

                            fillColor: '#4ade80',

                            fillOpacity: 1,

                            weight: 2
                        }

                    ).addTo(map);

                    markerPengguna.bindPopup(`

                        <b>Lokasi Anda</b><br>

                        Latitude:
                        ${formatKoordinat(latitude)}<br>

                        Longitude:
                        ${formatKoordinat(longitude)}

                    `);

                    const index = terbaik.index;

                    const branch = validBranches[index];

                    pilihCabang(index, false);

                    // Tampilkan jarak terlebih dahulu.
                    markers[index].setPopupContent(`

                        ${popupCabang(branch, index)}

                        <div style="margin-top:8px">
                            <b>Jarak dari lokasi Anda:</b>
                            ${terbaik.jarak.toFixed(2)} km
                        </div>

                    `).openPopup();

                    map.fitBounds(

                        L.latLngBounds(

                            [latitude, longitude],

                            markers[index].getLatLng()

                        ).pad(0.3)
                    );
                    statusPeta.textContent =
                        'Cabang terdekat: ' + branch.nama;

                },
                error => {

                    console.error(error);

                    alert(
                        'Lokasi tidak dapat diakses. Periksa izin lokasi browser.'
                    );
                    statusPeta.textContent =
                        'Gagal mendapatkan lokasi Anda.';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
            );
        });

    window.addEventListener('load', () => {
        setTimeout(() => {
            map.invalidateSize();

        }, 150);
    });
    window.addEventListener('resize', () => {
        map.invalidateSize();
    });

</script>

</body>
</html>
