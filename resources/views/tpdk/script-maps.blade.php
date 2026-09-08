<script>
    // Fungsi untuk mendapatkan alamat dari koordinat (Reverse Geocoding)
    async function getAddressFromCoords(lat, lng, addressInputId) {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await response.json();
            if (data && data.display_name) {
                document.getElementById(addressInputId).value = data.display_name;
            }
        } catch (error) {
            console.error("Error fetching address:", error);
        }
    }

    // --- MAP CREATE ---
    let mapCreate, markerCreate, circleCreate;
    document.getElementById('createTpdkModal').addEventListener('shown.bs.modal', function () {
        if (mapCreate != undefined) {
            setTimeout(() => mapCreate.invalidateSize(), 100);
            return;
        }

        const defaultLat = -6.983906;
        const defaultLng = 110.418465;

        mapCreate = L.map('map_create').setView([defaultLat, defaultLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapCreate);

        markerCreate = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(mapCreate);

        circleCreate = L.circle([defaultLat, defaultLng], {
            color: 'blue',
            fillColor: '#30f',
            fillOpacity: 0.2,
            radius: 50
        }).addTo(mapCreate);

        L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari alamat/gedung..."
        })
            .on('markgeocode', function (e) {
                const center = e.geocode.center;
                mapCreate.fitBounds(e.geocode.bbox);
                markerCreate.setLatLng(center);
                circleCreate.setLatLng(center);

                document.getElementById('lat_create').value = center.lat;
                document.getElementById('long_create').value = center.lng;
                document.getElementById('alamat_create').value = e.geocode.name; // Set alamat dari hasil pencarian
            })
            .addTo(mapCreate);

        markerCreate.on('dragend', function (event) {
            const position = markerCreate.getLatLng();
            document.getElementById('lat_create').value = position.lat;
            document.getElementById('long_create').value = position.lng;
            circleCreate.setLatLng(position);

            // Ambil alamat berdasarkan titik marker yang baru
            getAddressFromCoords(position.lat, position.lng, 'alamat_create');
        });

        const radCreateInput = document.getElementById('rad_create');
        if (radCreateInput) {
            radCreateInput.addEventListener('input', function () {
                let val = parseInt(this.value);
                if (val > 0) circleCreate.setRadius(val);
            });
        }
    });

    // --- MAP EDIT ---
    let editMaps = {};
    const editModals = document.querySelectorAll('[id^="editTpdkModal-"]');
    editModals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const modalId = this.id;
            const tpdkId = modalId.replace('editTpdkModal-', '');
            const mapContainerId = 'map_edit_' + tpdkId;

            const mapContainer = document.getElementById(mapContainerId);
            if (!mapContainer) return;

            if (editMaps[tpdkId] != undefined) {
                setTimeout(() => editMaps[tpdkId].map.invalidateSize(), 100);
                return;
            }

            const lat = parseFloat(mapContainer.getAttribute('data-lat'));
            const lng = parseFloat(mapContainer.getAttribute('data-lng'));
            const rad = parseInt(mapContainer.getAttribute('data-rad'));

            const mapEdit = L.map(mapContainerId).setView([lat, lng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapEdit);

            const markerEdit = L.marker([lat, lng], { draggable: true }).addTo(mapEdit);

            const circleEdit = L.circle([lat, lng], {
                color: 'blue',
                fillColor: '#30f',
                fillOpacity: 0.2,
                radius: rad
            }).addTo(mapEdit);

            L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: "Cari alamat/gedung..."
            })
                .on('markgeocode', function (e) {
                    const center = e.geocode.center;
                    mapEdit.fitBounds(e.geocode.bbox);
                    markerEdit.setLatLng(center);
                    circleEdit.setLatLng(center);

                    document.getElementById('lat_edit_' + tpdkId).value = center.lat;
                    document.getElementById('long_edit_' + tpdkId).value = center.lng;
                    document.getElementById('alamat_edit_' + tpdkId).value = e.geocode.name;
                })
                .addTo(mapEdit);

            markerEdit.on('dragend', function (event) {
                const position = markerEdit.getLatLng();
                document.getElementById('lat_edit_' + tpdkId).value = position.lat;
                document.getElementById('long_edit_' + tpdkId).value = position.lng;
                circleEdit.setLatLng(position);

                // Ambil alamat berdasarkan titik marker yang baru
                getAddressFromCoords(position.lat, position.lng, 'alamat_edit_' + tpdkId);
            });

            const radEditInput = document.getElementById('rad_edit_' + tpdkId);
            if (radEditInput) {
                radEditInput.addEventListener('input', function () {
                    let val = parseInt(this.value);
                    if (val > 0) circleEdit.setRadius(val);
                });
            }

            editMaps[tpdkId] = {
                map: mapEdit,
                marker: markerEdit,
                circle: circleEdit
            };
        });
    });

    // --- MAP SHOW ---
    let showMaps = {};
    const showModals = document.querySelectorAll('[id^="showTpdkModal-"]');
    showModals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const modalId = this.id;
            const tpdkId = modalId.replace('showTpdkModal-', '');
            const mapContainerId = 'map_show_' + tpdkId;

            const mapContainer = document.getElementById(mapContainerId);
            if (!mapContainer) return;

            if (showMaps[tpdkId] != undefined) {
                setTimeout(() => showMaps[tpdkId].map.invalidateSize(), 100);
                return;
            }

            const lat = parseFloat(mapContainer.getAttribute('data-lat'));
            const lng = parseFloat(mapContainer.getAttribute('data-lng'));
            const rad = parseInt(mapContainer.getAttribute('data-rad'));

            const mapShow = L.map(mapContainerId).setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapShow);

            const markerShow = L.marker([lat, lng], { draggable: false }).addTo(mapShow);

            const circleShow = L.circle([lat, lng], {
                color: 'green',
                fillColor: '#30f',
                fillOpacity: 0.2,
                radius: rad
            }).addTo(mapShow);

            showMaps[tpdkId] = {
                map: mapShow,
                marker: markerShow,
                circle: circleShow
            };
        });
    });
</script>