<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<!-- Chart Controls -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pilih Jenis Grafik</h6>
            </div>
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="Chart Types">
                    <button type="button" class="btn btn-primary" onclick="loadChart('line')">
                        <i class="fas fa-chart-line"></i> Line Chart
                    </button>
                    <button type="button" class="btn btn-success" onclick="loadChart('bar')">
                        <i class="fas fa-chart-bar"></i> Bar Chart
                    </button>
                    <button type="button" class="btn btn-info" onclick="loadChart('pie')">
                        <i class="fas fa-chart-pie"></i> Pie Chart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Main Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle">Trend Kriminalitas</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Aksi:</div>
                        <a class="dropdown-item" href="#" onclick="refreshChart()">Refresh Data</a>
                        <a class="dropdown-item" href="#" onclick="exportChart()">Export Chart</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="loadingChart" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
                <div class="chart-container" style="position: relative; height: 400px;">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan Statistik</h6>
            </div>
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12 mb-3">
                        <div class="small text-gray-500">Total Kasus Bulan Ini</div>
                        <div class="h4 font-weight-bold" id="totalCases">-</div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="small text-gray-500">Kasus Tertinggi</div>
                        <div class="h5 font-weight-bold text-success" id="highestCase">-</div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="small text-gray-500">Trend</div>
                        <div class="h5 font-weight-bold text-info" id="trendInfo">-</div>
                    </div>
                </div>
                
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" id="progressBar"></div>
                </div>
                
                <div class="small text-gray-500">
                    Update terakhir: <span id="lastUpdate">-</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('statistik') ?>" class="btn btn-primary btn-sm btn-block mb-2">
                    <i class="fas fa-table"></i> Lihat Tabel
                </a>
                <a href="<?= base_url('peta') ?>" class="btn btn-info btn-sm btn-block mb-2">
                    <i class="fas fa-map"></i> Lihat Peta
                </a>
                <button class="btn btn-success btn-sm btn-block" onclick="downloadData()">
                    <i class="fas fa-download"></i> Download Data
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let mainChart = null;

document.addEventListener('DOMContentLoaded', function() {
    // Load default chart (line chart)
    loadChart('line');
});

function loadChart(type) {
    // Show loading indicator
    document.getElementById('loadingChart').style.display = 'block';
    
    // Update active button
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('btn-primary', 'btn-success', 'btn-info');
        if (btn.onclick.toString().includes(type)) {
            switch(type) {
                case 'line': btn.classList.add('btn-primary'); break;
                case 'bar': btn.classList.add('btn-success'); break;
                case 'pie': btn.classList.add('btn-info'); break;
            }
        } else {
            btn.classList.add('btn-outline-secondary');
        }
    });
    
    // Fetch chart data
    fetch(`<?= base_url('statistik/getChartData') ?>?type=${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                alert('Gagal memuat data grafik: ' + data.error);
                return;
            }
            
            // Hide loading indicator
            document.getElementById('loadingChart').style.display = 'none';
            
            // Destroy existing chart
            if (mainChart) {
                mainChart.destroy();
            }
            
            // Create new chart
            createChart(type, data);
            
            // Update summary statistics
            updateSummaryStats(data);
            
            // Update chart title
            updateChartTitle(type);
        })
        .catch(error => {
            console.error('Fetch error:', error);
            document.getElementById('loadingChart').style.display = 'none';
            alert('Gagal memuat data grafik. Periksa koneksi internet Anda.');
        });
}

function createChart(type, data) {
    const ctx = document.getElementById('mainChart').getContext('2d');
    
    let chartConfig = {
        type: type,
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            }
        }
    };
    
    // Specific configurations for different chart types
    switch(type) {
        case 'line':
            chartConfig.options.scales = {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e3e6f0',
                    }
                },
                x: {
                    grid: {
                        color: '#e3e6f0',
                    }
                }
            };
            chartConfig.options.elements = {
                point: {
                    radius: 4,
                    hoverRadius: 6
                }
            };
            break;
            
        case 'bar':
            chartConfig.options.scales = {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e3e6f0',
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            };
            break;
            
        case 'pie':
            chartConfig.options.plugins.tooltip = {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.parsed;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value / total) * 100);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            };
            delete chartConfig.options.scales;
            break;
    }
    
    mainChart = new Chart(ctx, chartConfig);
}

function updateSummaryStats(data) {
    if (data.datasets && data.datasets.length > 0) {
        let total = 0;
        let highest = 0;
        let highestLabel = '';
        
        if (data.datasets[0].data) {
            data.datasets[0].data.forEach((value, index) => {
                total += value;
                if (value > highest) {
                    highest = value;
                    highestLabel = data.labels ? data.labels[index] : `Item ${index + 1}`;
                }
            });
        }
        
        document.getElementById('totalCases').textContent = total.toLocaleString();
        document.getElementById('highestCase').textContent = `${highestLabel} (${highest})`;
        document.getElementById('trendInfo').textContent = total > 200 ? 'Meningkat' : 'Stabil';
        
        // Update progress bar
        const maxExpected = 500;
        const percentage = Math.min((total / maxExpected) * 100, 100);
        document.getElementById('progressBar').style.width = `${percentage}%`;
        
        // Update last update time
        document.getElementById('lastUpdate').textContent = new Date().toLocaleString('id-ID');
    }
}

function updateChartTitle(type) {
    const titles = {
        'line': 'Trend Kriminalitas Bulanan',
        'bar': 'Distribusi Kriminalitas per Wilayah', 
        'pie': 'Persentase Jenis Kriminalitas'
    };
    
    document.getElementById('chartTitle').textContent = titles[type] || 'Grafik Kriminalitas';
}

function refreshChart() {
    const activeButton = document.querySelector('.btn-group .btn-primary, .btn-group .btn-success, .btn-group .btn-info');
    if (activeButton) {
        let type = 'line';
        if (activeButton.onclick.toString().includes('bar')) type = 'bar';
        else if (activeButton.onclick.toString().includes('pie')) type = 'pie';
        
        loadChart(type);
    }
}

function exportChart() {
    if (mainChart) {
        const url = mainChart.toBase64Image();
        const link = document.createElement('a');
        link.download = 'chart-kriminalitas.png';
        link.href = url;
        link.click();
    }
}

function downloadData() {
    // Create CSV data
    const csvData = [
        ['Jenis', 'Jumlah'],
        ['Pencurian', '45'],
        ['Perampokan', '25'],
        ['Penipuan', '20'],
        ['Narkoba', '10']
    ];
    
    let csvContent = csvData.map(row => row.join(',')).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'data-kriminalitas.csv';
    link.click();
    window.URL.revokeObjectURL(url);
}
</script>
<?= $this->endSection() ?>