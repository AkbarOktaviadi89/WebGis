<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Tabel Statistik -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Statistik Kriminalitas Kota Bandung</h6>
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
                                <td>Bandung Utara</td>
                                <td>2024-01-15</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td><span class="badge badge-warning">Sedang</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Perampokan</td>
                                <td>Cimahi</td>
                                <td>2024-01-16</td>
                                <td><span class="badge badge-danger">Proses</span></td>
                                <td><span class="badge badge-danger">Tinggi</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Penipuan</td>
                                <td>Bandung Selatan</td>
                                <td>2024-01-17</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td><span class="badge badge-info">Rendah</span></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Narkoba</td>
                                <td>Bandung Timur</td>
                                <td>2024-01-18</td>
                                <td><span class="badge badge-danger">Proses</span></td>
                                <td><span class="badge badge-danger">Tinggi</span></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Pencurian</td>
                                <td>Bandung Barat</td>
                                <td>2024-01-19</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td><span class="badge badge-warning">Sedang</span></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Penganiayaan</td>
                                <td>Coblong</td>
                                <td>2024-01-20</td>
                                <td><span class="badge badge-warning">Proses</span></td>
                                <td><span class="badge badge-warning">Sedang</span></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Penipuan</td>
                                <td>Sukasari</td>
                                <td>2024-01-21</td>
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
                <h6 class="m-0 font-weight-bold text-primary">Grafik Trend Kriminalitas Bandung</h6>
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
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Jenis Kriminalitas Bandung</h6>
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
    // Crime Trend Chart - Data Bandung
    var ctx1 = document.getElementById('crimeChart').getContext('2d');
    var crimeChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
            datasets: [
                {
                    label: 'Pencurian',
                    data: [38, 45, 32, 58, 37, 48],
                    borderColor: 'rgb(78, 115, 223)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Perampokan',
                    data: [10, 15, 12, 19, 16, 23],
                    borderColor: 'rgb(231, 74, 59)',
                    backgroundColor: 'rgba(231, 74, 59, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Penipuan',
                    data: [6, 10, 8, 12, 11, 15],
                    borderColor: 'rgb(28, 200, 138)',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
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

    // Distribution Chart - Data Bandung
    var ctx2 = document.getElementById('distributionChart').getContext('2d');
    var distributionChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Pencurian', 'Perampokan', 'Penipuan', 'Narkoba', 'Penganiayaan'],
            datasets: [{
                label: 'Jumlah Kasus',
                data: [38, 20, 17, 8, 12],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(156, 39, 176, 0.8)'
                ],
                borderColor: [
                    'rgb(78, 115, 223)',
                    'rgb(28, 200, 138)',
                    'rgb(54, 185, 204)',
                    'rgb(246, 194, 62)',
                    'rgb(156, 39, 176)'
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