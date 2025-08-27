<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Peta Rawan Kriminalitas Kota Bandung</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Opsi Peta:</div>
                        <a class="dropdown-item" href="#" onclick="toggleHeatmap()">Toggle Heatmap</a>
                        <a class="dropdown-item" href="#" onclick="filterByType()">Filter Jenis</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="exportMap()">Export Peta</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Map Controls -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-control" id="crimeTypeFilter">
                            <option value="">Semua Jenis</option>
                            <option value="pencurian">Pencurian</option>
                            <option value="perampokan">Perampokan</option>
                            <option value="penipuan">Penipuan</option>
                            <option value="narkoba">Narkoba</option>
                            <option value="penganiayaan">Penganiayaan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="locationFilter">
                            <option value="">Semua Wilayah</option>
                            <option value="bandung-utara">Bandung Utara</option>
                            <option value="bandung-selatan">Bandung Selatan</option>
                            <option value="bandung-timur">Bandung Timur</option>
                            <option value="bandung-barat">Bandung Barat</option>
                            <option value="cimahi">Cimahi</option>
                            <option value="coblong">Coblong</option>
                            <option value="sukasari">Sukasari</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" onclick="updateMap()">
                            <i class="fas fa-sync-alt"></i> Update Peta
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success" onclick="addIncident()">
                            <i class="fas fa-plus"></i> Tambah Insiden
                        </button>
                    </div>
                </div>
                
                <!-- Map Container -->
                <div id="crimeMap" class="map-container" style="height: 600px;"></div>
                
                <!-- Legend -->
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Legenda Tingkat Bahaya:</h6>
                            <div class="d-flex flex-wrap">
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-danger">●</span> Tingkat Tinggi (>30 insiden)
                                </div>
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-warning">●</span> Tingkat Sedang (10-30 insiden)
                                </div>
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-success">●</span> Tingkat Rendah (<10 insiden)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Wilayah Fokus:</h6>
                            <small class="text-muted">Peta mencakup wilayah Kota Bandung dan sekitarnya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Incident Modal -->
<div class="modal fade" id="addIncidentModal" tabindex="-1" role="dialog" aria-labelledby="addIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIncidentModalLabel">Tambah Insiden Baru - Kota Bandung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="incidentForm">
                    <div class="form-group">
                        <label for="incidentType">Jenis Kriminalitas</label>
                        <select class="form-control" id="incidentType" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pencurian">Pencurian</option>
                            <option value="perampokan">Perampokan</option>
                            <option value="penipuan">Penipuan</option>
                            <option value="narkoba">Narkoba</option>
                            <option value="penganiayaan">Penganiayaan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="incidentLocation">Lokasi</label>
                        <select class="form-control" id="incidentLocation" required>
                            <option value="">Pilih Wilayah</option>
                            <option value="Bandung Utara">Bandung Utara</option>
                            <option value="Bandung Selatan">Bandung Selatan</option>
                            <option value="Bandung Timur">Bandung Timur</option>
                            <option value="Bandung Barat">Bandung Barat</option>
                            <option value="Cimahi">Cimahi</option>
                            <option value="Coblong">Coblong</option>
                            <option value="Sukasari">Sukasari</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="incidentAddress">Alamat Lengkap</label>
                        <input type="text" class="form-control" id="incidentAddress" placeholder="Jl. Contoh No. 123, Bandung" required>
                    </div>
                    <div class="form-group">
                        <label for="incidentDate">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="incidentDate" required>
                    </div>
                    <div class="form-group">
                        <label for="incidentTime">Waktu Kejadian</label>
                        <input type="time" class="form-control" id="incidentTime">
                    </div>
                    <div class="form-group">
                        <label for="incidentDescription">Deskripsi</label>
                        <textarea class="form-control" id="incidentDescription" rows="3" placeholder="Deskripsi kejadian secara detail"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="incidentSeverity">Tingkat Bahaya</label>
                        <select class="form-control" id="incidentSeverity" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveIncident()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let crimeMap;
let markersLayer;
let heatmapLayer;

document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    loadMapData();
});

function initializeMap() {
    // Initialize map centered on Bandung
    crimeMap = L.map('crimeMap').setView([-6.9175, 107.6191], 12);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(crimeMap);
    
    // Initialize marker layer
    markersLayer = L.layerGroup().addTo(crimeMap);
}

function loadMapData() {
    // Crime data for Bandung
    const crimeData = [
        {lat: -6.9175, lng: 107.6191, type: 'pencurian', count: 38, severity: 'sedang', location: 'Bandung Utara'},
        {lat: -6.8915, lng: 107.6098, type: 'perampokan', count: 20, severity: 'tinggi', location: 'Cimahi'},
        {lat: -6.9575, lng: 107.6191, type: 'penipuan', count: 17, severity: 'rendah', location: 'Bandung Selatan'},
        {lat: -6.9175, lng: 107.6648, type: 'narkoba', count: 8, severity: 'tinggi', location: 'Bandung Timur'},
        {lat: -6.9175, lng: 107.5734, type: 'pencurian', count: 25, severity: 'sedang', location: 'Bandung Barat'},
        {lat: -6.8995, lng: 107.6098, type: 'penganiayaan', count: 12, severity: 'sedang', location: 'Coblong'},
        {lat: -6.8705, lng: 107.5951, type: 'penipuan', count: 9, severity: 'rendah', location: 'Sukasari'}
    ];
    
    // Clear existing markers
    markersLayer.clearLayers();
    
    // Add markers
    crimeData.forEach(function(crime) {
        let color = getSeverityColor(crime.severity);
        let icon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: ${color}; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">${crime.count}</div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });
        
        let marker = L.marker([crime.lat, crime.lng], {icon: icon})
            .bindPopup(`
                <div class="popup-content">
                    <h6><strong>${crime.type.toUpperCase()}</strong></h6>
                    <p><i class="fas fa-map-marker-alt"></i> ${crime.location}</p>
                    <p><i class="fas fa-chart-bar"></i> Jumlah Insiden: <strong>${crime.count}</strong></p>
                    <p><i class="fas fa-exclamation-triangle"></i> Tingkat Bahaya: <span class="badge badge-${getSeverityBadge(crime.severity)}">${crime.severity.toUpperCase()}</span></p>
                    <button class="btn btn-sm btn-primary" onclick="viewDetails('${crime.location}')">Detail</button>
                </div>
            `);
        
        markersLayer.addLayer(marker);
    });
}

function getSeverityColor(severity) {
    switch(severity) {
        case 'tinggi': return '#dc3545';
        case 'sedang': return '#ffc107';
        case 'rendah': return '#28a745';
        default: return '#6c757d';
    }
}

function getSeverityBadge(severity) {
    switch(severity) {
        case 'tinggi': return 'danger';
        case 'sedang': return 'warning';
        case 'rendah': return 'success';
        default: return 'secondary';
    }
}

function updateMap() {
    const typeFilter = document.getElementById('crimeTypeFilter').value;
    const locationFilter = document.getElementById('locationFilter').value;
    
    console.log('Filtering by type:', typeFilter, 'and location:', locationFilter);
    
    // Reload map data with filters
    loadMapData();
    
    // Show success message
    showAlert('Peta Bandung berhasil diperbarui!', 'success');
}

function toggleHeatmap() {
    if (!heatmapLayer) {
        // Create heatmap layer for Bandung
        const heatmapData = [
            [-6.9175, 107.6191, 0.8], // Bandung Utara
            [-6.8915, 107.6098, 0.7], // Cimahi
            [-6.9175, 107.6648, 0.6], // Bandung Timur
            [-6.9175, 107.5734, 0.6], // Bandung Barat
            [-6.9575, 107.6191, 0.5], // Bandung Selatan
            [-6.8995, 107.6098, 0.4], // Coblong
            [-6.8705, 107.5951, 0.3]  // Sukasari
        ];
        
        heatmapLayer = L.heatLayer(heatmapData, {
            radius: 30,
            blur: 15,
            maxZoom: 17
        });
    }
    
    if (crimeMap.hasLayer(heatmapLayer)) {
        crimeMap.removeLayer(heatmapLayer);
        showAlert('Heatmap dinonaktifkan', 'info');
    } else {
        crimeMap.addLayer(heatmapLayer);
        showAlert('Heatmap diaktifkan', 'success');
    }
}

function filterByType() {
    const selectedType = document.getElementById('crimeTypeFilter').value;
    updateMap();
}

function exportMap() {
    // Implement map export for Bandung
    showAlert('Export peta Bandung akan segera tersedia!', 'info');
}

function addIncident() {
    // Set default date to today
    document.getElementById('incidentDate').value = new Date().toISOString().split('T')[0];
    $('#addIncidentModal').modal('show');
}

function saveIncident() {
    const form = document.getElementById('incidentForm');
    if (form.checkValidity()) {
        const incidentData = {
            type: document.getElementById('incidentType').value,
            location: document.getElementById('incidentLocation').value,
            address: document.getElementById('incidentAddress').value,
            date: document.getElementById('incidentDate').value,
            time: document.getElementById('incidentTime').value,
            description: document.getElementById('incidentDescription').value,
            severity: document.getElementById('incidentSeverity').value
        };
        
        console.log('Saving incident for Bandung:', incidentData);
        
        // Close modal
        $('#addIncidentModal').modal('hide');
        
        // Reset form
        form.reset();
        
        // Show success message
        showAlert(`Insiden di ${incidentData.location} berhasil ditambahkan!`, 'success');
        
        // Reload map
        loadMapData();
    } else {
        showAlert('Mohon lengkapi semua field yang diperlukan!', 'warning');
    }
}

function viewDetails(location) {
    showAlert(`Menampilkan detail kriminalitas di ${location}, Kota Bandung`, 'info');
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    `;
    
    // Insert at top of content
    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Add click event to map for adding incidents
crimeMap.on('click', function(e) {
    const popup = L.popup()
        .setLatLng(e.latlng)
        .setContent(`
            <div class="text-center">
                <p><strong>Koordinat Bandung:</strong><br>${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}</p>
                <button class="btn btn-sm btn-primary" onclick="addIncidentAtLocation(${e.latlng.lat}, ${e.latlng.lng})">
                    <i class="fas fa-plus"></i> Tambah Insiden Disini
                </button>
            </div>
        `)
        .openOn(crimeMap);
});

function addIncidentAtLocation(lat, lng) {
    crimeMap.closePopup();
    $('#addIncidentModal').modal('show');
    
    // Set coordinates in address field
    document.getElementById('incidentAddress').value = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    document.getElementById('incidentDate').value = new Date().toISOString().split('T')[0];
}
</script>

<!-- Load Leaflet Heatmap Plugin -->
<script src="https://cdn.jsdelivr.net/gh/Leaflet/Leaflet.heat/dist/leaflet-heat.js"></script>

<?= $this->endSection() ?>