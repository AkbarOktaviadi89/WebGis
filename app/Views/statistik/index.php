<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Tabel Statistik -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Statistik Kriminalitas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Kriminalitas</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Tingkat Bahaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pencurian</td>
                                <td>Jakarta Pusat</td>
                                <td>2024-01-15</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td><span class="badge badge-warning">Sedang</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Perampokan</td>
                                <td>Jakarta Utara</td>
                                <td>2024-01-16</td>
                                <td><span class="badge badge-danger">Proses</span></td>
                                <td><span class="badge badge-danger">Tinggi</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Penipuan</td>
                                <td>Jakarta Selatan</td>
                                <td>2024-01-17</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td><span class="badge badge-info">Rendah</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart Statistik -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Trend Kriminalitas</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="crimeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Jenis Kriminalitas</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Crime Trend Chart
    var ctx1 = document.getElementById('crimeChart').getContext('2d');
    var crimeChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
            datasets: [
                {
                    label: 'Pencurian',
                    data: [45, 52, 38, 67, 43, 55],
                    borderColor: 'rgb(78, 115, 223)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Perampokan',
                    data: [12, 18, 15, 23, 19, 28],
                    borderColor: 'rgb(231, 74, 59)',
                    backgroundColor: 'rgba(231, 74, 59, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Distribution Chart
    var ctx2 = document.getElementById('distributionChart').getContext('2d');
    var distributionChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Pencurian', 'Perampokan', 'Penipuan', 'Narkoba'],
            datasets: [{
                label: 'Jumlah Kasus',
                data: [45, 25, 20, 10],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)'
                ],
                borderColor: [
                    'rgb(78, 115, 223)',
                    'rgb(28, 200, 138)',
                    'rgb(54, 185, 204)',
                    'rgb(246, 194, 62)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>