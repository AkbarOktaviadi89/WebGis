<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Content Row - Statistics Cards -->
<div class="row">

    <!-- Total Districts Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Kecamatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">31</div>
                        <div class="text-xs text-muted">Kabupaten Bandung</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Police Stations Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Polsek</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        <div class="text-xs text-muted">Kabupaten Bandung</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Reports Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Laporan Diterima</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_incidents']) ?></div>
                        <div class="text-xs text-muted">Total laporan</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Handled Cases Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Kasus Ditangani</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['resolved_cases']) ?></div>
                        <div class="text-xs text-muted">Kasus selesai</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-gavel fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Highlight News Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-newspaper mr-2"></i>Highlight Berita & Informasi Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="bg-light p-3 rounded">
                            <h6 class="text-primary"><i class="fas fa-bullhorn mr-1"></i>Operasi Keamanan</h6>
                            <p class="mb-2 small">Polres Bandung melakukan operasi keamanan terpadu di wilayah rawan kriminalitas.</p>
                            <small class="text-muted">2 hari yang lalu</small>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="bg-light p-3 rounded">
                            <h6 class="text-success"><i class="fas fa-chart-line mr-1"></i>Penurunan Kriminalitas</h6>
                            <p class="mb-2 small">Tingkat kriminalitas di Kabupaten Bandung mengalami penurunan 15% dibanding bulan lalu.</p>
                            <small class="text-muted">5 hari yang lalu</small>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="bg-light p-3 rounded">
                            <h6 class="text-info"><i class="fas fa-balance-scale mr-1"></i>Kebijakan Baru</h6>
                            <p class="mb-2 small">Penerapan sistem pengawasan digital untuk meningkatkan keamanan wilayah.</p>
                            <small class="text-muted">1 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye mr-1"></i>Lihat Semua Berita
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Information Section -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
            </div>
            <div class="card-body">
                <p><strong>Tujuan WebGIS:</strong> Memantau sebaran kriminalitas, mendukung pengambilan keputusan pembangunan daerah, dan meningkatkan kesadaran spasial masyarakat.</p>
                <p><strong>Cakupan Wilayah:</strong> Kabupaten Bandung dengan 31 Kecamatan</p>
                <p><strong>Sumber Data:</strong> Polres Kabupaten Bandung, BPS, dan survei lapangan</p>
                <small class="text-muted"><strong>Update Terakhir:</strong> <?= date('d F Y') ?></small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Fitur Utama</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-map text-primary mr-2"></i>Pemetaan Kriminalitas Real-time</li>
                    <li><i class="fas fa-chart-bar text-success mr-2"></i>Analisis Statistik Komprehensif</li>
                    <li><i class="fas fa-layer-group text-info mr-2"></i>Clustering Area Rawan</li>
                    <li><i class="fas fa-fire text-warning mr-2"></i>Heatmap Intensitas Kejadian</li>
                    <li><i class="fas fa-download text-secondary mr-2"></i>Export Data & Laporan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Section -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Statistik Kriminalitas
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">• Tabel hasil clustering area rawan</p>
                <p class="mb-2">• Grafik tren kriminalitas bulanan</p>
                <p class="mb-3">• Analisis pola kejadian</p>
                <div class="mt-3">
                    <a href="<?= base_url('statistik') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-table mr-1"></i>Lihat Tabel
                    </a>
                    <a href="<?= base_url('statistik/chart') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chart-line mr-1"></i>Lihat Grafik
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-map-marked-alt mr-2"></i>Peta Kriminalitas
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">• Visualisasi spasial kejadian kriminalitas</p>
                <p class="mb-2">• Peta interaktif Kabupaten Bandung</p>
                <p class="mb-3">• Layer analisis clustering</p>
                <div class="mt-3">
                    <a href="<?= base_url('peta') ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-map mr-1"></i>Buka Peta
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-question-circle mr-2"></i>Panduan Sistem
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">• Cara penggunaan WebGIS</p>
                <p class="mb-2">• Interpretasi hasil analisis</p>
                <p class="mb-3">• FAQ dan troubleshooting</p>
                <div class="mt-3">
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#helpModal">
                        <i class="fas fa-book mr-1"></i>Baca Panduan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row - Charts -->
<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-area mr-2"></i>Tren Kriminalitas Kabupaten Bandung
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Kategori Kriminalitas
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Map Overview -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-globe-asia mr-2"></i>Peta Overview - Kabupaten Bandung
                </h6>
            </div>
            <div class="card-body">
                <div id="dashboard-map" class="map-container" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Dashboard Charts
document.addEventListener('DOMContentLoaded', function() {
    // Area Chart
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Insiden Kriminalitas",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [65, 72, 58, 87, 63, 75, 69, 82, 76, 91, 68, 73],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Insiden'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });

    // Pie Chart
    var ctx2 = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Pencurian", "Perampokan", "Penipuan", "Narkoba", "Lainnya"],
            datasets: [{
                data: [35, 20, 15, 18, 12],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#e0b934', '#c0392b'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            cutout: 60,
        },
    });

    // Initialize Dashboard Map for Bandung area
    var dashboardMap = L.map('dashboard-map').setView([-6.9147, 107.6098], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(dashboardMap);

    // Sample markers for Bandung Regency districts
    var districts = [
        {lat: -6.9147, lng: 107.6098, title: 'Bandung', incidents: 45, type: 'high'},
        {lat: -6.8650, lng: 107.5872, title: 'Lembang', incidents: 32, type: 'medium'},
        {lat: -6.9706, lng: 107.6337, title: 'Banjaran', incidents: 28, type: 'medium'},
        {lat: -6.8447, lng: 107.4944, title: 'Padalarang', incidents: 15, type: 'low'},
        {lat: -7.0167, lng: 107.5469, title: 'Soreang', incidents: 38, type: 'high'},
        {lat: -6.8206, lng: 107.6581, title: 'Cimenyan', incidents: 6, type: 'low'},
        {lat: -7.1025, lng: 107.6561, title: 'Majalaya', incidents: 25, type: 'medium'},
        {lat: -6.7747, lng: 107.6319, title: 'Cikalong Wetan', incidents: 9, type: 'low'},
        {lat: -7.0333, lng: 107.4833, title: 'Katapang', incidents: 18, type: 'medium'},
        {lat: -6.7833, lng: 107.5500, title: 'Cisarua', incidents: 12, type: 'low'},
        {lat: -6.9167, lng: 107.4333, title: 'Cipeundeuy', incidents: 14, type: 'low'},
        {lat: -7.0500, lng: 107.7000, title: 'Rancaekek', incidents: 22, type: 'medium'}
    ];

    districts.forEach(function(district) {
        var color = '#28a745'; // default green (low risk)
        if (district.type === 'high') color = '#dc3545'; // red
        else if (district.type === 'medium') color = '#ffc107'; // yellow
        
        var icon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: ${color}; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); font-size: 11px;">${district.incidents}</div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
        
        L.marker([district.lat, district.lng], {icon: icon})
            .addTo(dashboardMap)
            .bindPopup(`<b>Kecamatan ${district.title}</b><br>${district.incidents} kasus kriminalitas<br><small>Tingkat risiko: ${district.type}</small>`);
    });
    
    // Add map legend
    var legend = L.control({position: 'bottomright'});
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = `
            <div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <h6 style="margin: 0 0 8px 0; font-weight: bold; font-size: 12px;">Tingkat Risiko Kecamatan</h6>
                <div style="font-size: 11px;"><span style="color: #dc3545; font-size: 14px;">●</span> Tinggi (>30 kasus)</div>
                <div style="font-size: 11px;"><span style="color: #ffc107; font-size: 14px;">●</span> Sedang (15-30 kasus)</div>
                <div style="font-size: 11px;"><span style="color: #28a745; font-size: 14px;">●</span> Rendah (<15 kasus)</div>
            </div>
        `;
        return div;
    };
    legend.addTo(dashboardMap);
});
</script>
<?= $this->endSection() ?>