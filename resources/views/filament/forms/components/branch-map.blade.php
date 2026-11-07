
@once
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endonce

@php
    $parentPath = \Illuminate\Support\Str::beforeLast($getStatePath(), '.');
    $latitudePath = $parentPath . '.latitude';
    $longitudePath = $parentPath . '.longitude';
@endphp

<div
    x-data="{
        latitude: $wire.$entangle('{{ $latitudePath }}').live,
        longitude: $wire.$entangle('{{ $longitudePath }}').live,
        map: null,
        marker: null,

        init() {
            const lat = parseFloat(this.latitude);
            const lng = parseFloat(this.longitude);

            const valid =
                this.latitude !== null && this.latitude !== '' &&
                this.longitude !== null && this.longitude !== '' &&
                Number.isFinite(lat) && Number.isFinite(lng) &&
                Math.abs(lat) <= 90 && Math.abs(lng) <= 180;

            const initialPosition = valid
                ? [lat, lng]
                : [-6.732, 108.552];

            this.map = L.map(this.$refs.map).setView(
                initialPosition,
                valid ? 16 : 12
            );

            L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }
).addTo(this.map);

            if (valid) {
                this.createMarker(initialPosition);
            }

            // Klik peta untuk memindahkan pin.
            this.map.on('click', (event) => {
                this.updateLocation(
                    event.latlng.lat,
                    event.latlng.lng
                );
            });

            // Sinkronisasi jika koordinat diubah manual.
            this.$watch('latitude', () => this.syncMarker());
            this.$watch('longitude', () => this.syncMarker());

            this.$nextTick(() => {
                this.map.invalidateSize();
            });
        },

        createMarker(position) {
            this.marker = L.marker(position, {
                draggable: true
            }).addTo(this.map);

            // Pin bisa digeser.
            this.marker.on('dragend', (event) => {
                const pos = event.target.getLatLng();

                this.updateLocation(pos.lat, pos.lng);
            });
        },

        updateLocation(lat, lng) {
            this.latitude = Number(lat).toFixed(7);
            this.longitude = Number(lng).toFixed(7);

            const position = [lat, lng];

            if (!this.marker) {
                this.createMarker(position);
            } else {
                this.marker.setLatLng(position);
            }

            this.map.panTo(position);
        },

        syncMarker() {
            if (
                this.latitude === null ||
                this.latitude === '' ||
                this.longitude === null ||
                this.longitude === ''
            ) return;

            const lat = Number(this.latitude);
            const lng = Number(this.longitude);

            if (
                !Number.isFinite(lat) ||
                !Number.isFinite(lng) ||
                Math.abs(lat) > 90 ||
                Math.abs(lng) > 180
            ) return;

            const position = [lat, lng];

            if (!this.marker) {
                this.createMarker(position);
            } else {
                this.marker.setLatLng(position);
            }

            this.map.panTo(position);
        }
    }"
    class="w-full space-y-3"
>
    <div>
        <h3 class="text-sm font-semibold text-gray-800">
            Pilih Lokasi Cabang
        </h3>

        <p class="text-xs text-gray-500 mt-1">
            Klik lokasi pada peta atau geser pin untuk menentukan posisi cabang.
        </p>
    </div>

    <div
        x-ref="map"
        wire:ignore
        style="
            height: 400px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            z-index: 1;
        "
    ></div>

    <p class="text-xs text-gray-500">
        Latitude dan Longitude akan diperbarui otomatis mengikuti posisi pin.
    </p>
</div>
