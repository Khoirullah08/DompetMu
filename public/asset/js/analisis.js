document.addEventListener('DOMContentLoaded', function() {

    const COLORS = ['#10b981', '#3b82f6', '#f59e0b', '#ff0000', '#8b5cf6', '#06b6d4', '#f97316'];
    let barChart = null;
    let pieChart = null;

    function formatRp(val) {
        return 'Rp' + val.toLocaleString('id-ID');
    }

    function initBarChart(labels, pemasukan, pengeluaran) {
        const ctx = document.getElementById('barChart');
        if (!ctx) return;
        if (barChart) barChart.destroy();
        barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    { label: 'Pemasukan', data: pemasukan, backgroundColor: '#10b981', borderRadius: 6 },
                    { label: 'Pengeluaran', data: pengeluaran, backgroundColor: '#ff0000', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ' ' + formatRp(ctx.parsed.y) } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { callback: val => 'Rp' + (val / 1000) + 'K' } }
                }
            }
        });
    }

    function initPieChart(labels, values) {
        const ctx = document.getElementById('pieChart');
        const noDataEl = document.getElementById('pieNoData');
        if (!ctx) return;

        if (pieChart) pieChart.destroy();

        if (values.length === 0) {
            ctx.classList.add('hidden');
            if (noDataEl) noDataEl.classList.remove('hidden');
            return;
        }

        // Ada data — tampilkan canvas, sembunyikan pesan
        ctx.classList.remove('hidden');
        if (noDataEl) noDataEl.classList.add('hidden');

        pieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{ data: values, backgroundColor: COLORS, borderWidth: 3, borderColor: '#fff' }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11, weight: 'bold' }, padding: 12, boxWidth: 10 } },
                    tooltip: { callbacks: { label: ctx => ' ' + formatRp(ctx.parsed) } }
                },
                cutout: '65%'
            }
        });
    }

    function updateSummary(data) {
        // Update summary cards
        document.getElementById('totalPemasukan').textContent = formatRp(data.totalPemasukan);
        document.getElementById('totalPengeluaran').textContent = formatRp(data.totalPengeluaran);
        const saldoEl = document.getElementById('saldoBersih');
        saldoEl.textContent = (data.saldoBersih >= 0 ? '+' : '-') + formatRp(Math.abs(data.saldoBersih));
        saldoEl.className = saldoEl.className.replace(/text-(blue|orange)-\d+/g, '') +
            (data.saldoBersih >= 0 ? ' text-blue-600' : ' text-orange-500');

        // Update strip
        const bulan = document.querySelector('select[name="bulan"]');
        const tahun = document.querySelector('select[name="tahun"]');
        const namaBulan = bulan.options[bulan.selectedIndex].text;
        const namaTahun = tahun.value;

        document.getElementById('stripPeriode').textContent = namaBulan + ' ' + namaTahun;
        document.getElementById('stripPemasukan').textContent = formatRp(data.totalPemasukan);
        document.getElementById('stripPengeluaran').textContent = formatRp(data.totalPengeluaran);

        const stripSaldo = document.getElementById('stripSaldo');
        stripSaldo.textContent = (data.saldoBersih >= 0 ? '+' : '-') + formatRp(Math.abs(data.saldoBersih));
        stripSaldo.className = 'font-black ' + (data.saldoBersih >= 0 ? 'text-blue-600' : 'text-orange-500');

        document.getElementById('filterInfoStrip').classList.remove('hidden');
    }

    function updateTopKategori(topKategori) {
        const container = document.getElementById('topKategoriContainer');
        if (!container) return;

        if (Object.keys(topKategori).length === 0) {
            container.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <i class="fas fa-chart-pie text-3xl mb-2"></i>
                    <p class="text-sm font-medium">Belum ada data pengeluaran.</p>
                </div>`;
            return;
        }

        const maxVal = Math.max(...Object.values(topKategori));
        let html = '<div class="space-y-4">';
        for (const [nama, jumlah] of Object.entries(topKategori)) {
            const persen = maxVal > 0 ? Math.round((jumlah / maxVal) * 100) : 0;
            html += `
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700">${nama}</span>
                        <span class="text-sm font-black text-gray-800">${formatRp(jumlah)}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width:${persen}%"></div>
                    </div>
                </div>`;
        }
        html += '</div>';
        container.innerHTML = html;
    }

    function fetchData() {
        const bulan = document.querySelector('select[name="bulan"]').value;
        const tahun = document.querySelector('select[name="tahun"]').value;

        fetch(`${window.ANALISIS_URL}?bulan=${bulan}&tahun=${tahun}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                updateSummary(data);
                initBarChart(data.bulanLabels, data.dataPemasukan, data.dataPengeluaran);
                initPieChart(data.kategoriLabels, data.kategoriValues);
                updateTopKategori(data.topKategori);
            });
    }

    // Init pertama kali pakai data dari blade
    const barCtx = document.getElementById('barChart');
    const pieCtx = document.getElementById('pieChart');
    if (barCtx) initBarChart(JSON.parse(barCtx.dataset.labels), JSON.parse(barCtx.dataset.pemasukan), JSON.parse(barCtx.dataset.pengeluaran));
    if (pieCtx) initPieChart(JSON.parse(pieCtx.dataset.labels), JSON.parse(pieCtx.dataset.values));

    // Filter realtime saat select berubah 
    document.querySelectorAll('select[name="bulan"], select[name="tahun"]').forEach(el => {
        el.addEventListener('change', fetchData);
    });

    document.querySelector('form[method="GET"]').addEventListener('submit', function(e) {
        e.preventDefault();
        fetchData();
    });

});