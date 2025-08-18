<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Peta Rawan Kriminalitas</h6>
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
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="dateFilter">
                            <option value="">Semua Periode</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="year">Tahun Ini</option>
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
                        <div class="col-12">
                            <h6>Legenda:</h6>
                            <div class="d-flex flex-wrap">
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-danger">●</span> Tingkat Tinggi (>50 insiden)
                                </div>
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-warning">●</span> Tingkat Sedang (20-50 insiden)
                                </div>
                                <div class="mr-3 mb-2">
                                    <span class="badge badge-success">●</span> Tingkat Rendah (<20 insiden)
                                </div>
                            </div>
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
                <h5 class="modal-title" id="addIncidentModalLabel">Tambah Insiden Baru</h5>
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
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="incidentLocation">Lokasi</label>
                        <input type="text" class="form-control" id="incidentLocation" placeholder="Alamat lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="incidentDate">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="incidentDate" required>
                    </div>
                    <div class="form-group">
                        <label for="incidentDescription">Deskripsi</label>
                        <textarea class="form-control" id="incidentDescription" rows="3" placeholder="Deskripsi kejadian"></textarea>
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
    // Initialize map
    crimeMap = L.map('crimeMap').setView([-6.2088, 106.8456], 11);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(crimeMap);
    
    // Initialize marker layer
    markersLayer = L.layerGroup().addTo(crimeMap);
}

function loadMapData() {
    // Simulate crime data
    const crimeData = [
        {lat: -6.2088, lng: 106.8456, type: 'pencurian', count: 45, severity: 'tinggi'},
        {lat: -6.1751, lng: 106.8650, type: 'perampokan', count: 32, severity: 'sedang'},
        {lat: -6.2614, lng: 106.7812, type: 'penipuan', count: 28, severity: 'sedang'},
        {lat: -6.3026, lng: 106.8456, type: 'narkoba', count: 15, severity: 'rendah'},
        {lat: -6.1574, lng: 106.9180, type: 'pencurian', count: 67, severity: 'tinggi'},
        {lat: -6.2297, lng: 106.9239, type: 'perampokan', count: 23, severity: 'sedang'}
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
                    <p>Jumlah Insiden: <strong>${crime.count}</strong></p>
                    <p>Tingkat Bahaya: <span class="badge badge-${getSeverityBadge(crime.severity)}">${crime.severity.toUpperCase()}</span></p>
                    <button class="btn btn-sm btn-primary" onclick="viewDetails(${crime.lat}, ${crime.lng})">Detail</button>
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
    const dateFilter = document.getElementById('dateFilter').value;
    
    // Implement filtering logic here
    console.log('Filtering by type:', typeFilter, 'and date:', dateFilter);
    
    // Reload map data with filters
    loadMapData();
    
    // Show success message
    showAlert('Peta berhasil diperbarui!', 'success');
}

function toggleHeatmap() {
    // Implement heatmap toggle
    console.log('Toggle heatmap');
    showAlert('Fitur heatmap akan segera tersedia!', 'info');
}

function filterByType() {
    // Implement type filtering
    console.log('Filter by type');
}

function exportMap() {
    // Implement map export
    showAlert('Export peta akan segera tersedia!', 'info');
}

function addIncident() {
    $('#addIncidentModal').modal('show');
}

function saveIncident() {
    const form = document.getElementById('incidentForm');
    if (form.checkValidity()) {
        // Simulate saving incident
        console.log('Saving incident...');
        
        // Close modal
        $('#addIncidentModal').modal('hide');
        
        // Reset form
        form.reset();
        
        // Show success message
        showAlert('Insiden berhasil ditambahkan!', 'success');
        
        // Reload map
        loadMapData();
    } else {
        showAlert('Mohon lengkapi semua field!', 'warning');
    }
}

function viewDetails(lat, lng) {
    showAlert(`Menampilkan detail untuk lokasi: ${lat}, ${lng}`, 'info');
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
                <p><strong>Koordinat:</strong><br>${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}</p>
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
    
    // Optionally set location field with coordinates
    document.getElementById('incidentLocation').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
}
</script>
<?= $this->endSection() ?>