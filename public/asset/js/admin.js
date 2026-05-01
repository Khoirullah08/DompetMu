document.addEventListener('DOMContentLoaded', function() {

    const USERS_DATA = window.USERS_DATA || [];

    /* ─── 1. Animated counter ─── */
    document.querySelectorAll('.card-val[data-count]').forEach(function(el) {
        const target = parseInt(el.dataset.count, 10);
        const steps = 60;
        const step = Math.ceil(target / steps);
        let current = 0;

        const timer = setInterval(function() {
            current += step;
            if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = current;
            }
        }, Math.round(800 / steps));
    });

    /* ─── 2. Growth line chart ─── */
    const growthCanvas = document.getElementById('growthChart');
    const monthlyData = JSON.parse(growthCanvas.dataset.monthly || '[]');
    const cumulativeData = JSON.parse(growthCanvas.dataset.cumulative || '[]');
    const growthLabels = JSON.parse(growthCanvas.dataset.labels || '[]');

    new Chart(growthCanvas, {
        type: 'line',
        data: {
            labels: growthLabels,
            datasets: [{
                    label: 'Pendaftar baru',
                    data: monthlyData,
                    borderColor: '#0b8a6e',
                    backgroundColor: 'rgba(11,138,110,.10)',
                    fill: true,
                    tension: .4,
                    pointRadius: 3,
                    pointBackgroundColor: '#0b8a6e',
                    borderWidth: 2,
                },
                {
                    label: 'Kumulatif',
                    data: cumulativeData,
                    borderColor: '#9fe1cb',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: .4,
                    pointRadius: 2,
                    pointBackgroundColor: '#9fe1cb',
                    borderWidth: 1.5,
                    borderDash: [4, 3],
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 10 }, color: '#9ca3af' }, border: { display: false } },
                y: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 10 }, color: '#9ca3af' }, border: { display: false }, beginAtZero: true }
            }
        }
    });

    /* ─── 3. Role donut chart ─── */
    const roleCanvas = document.getElementById('roleChart');

    new Chart(roleCanvas, {
        type: 'doughnut',
        data: {
            labels: ['User', 'Admin'],
            datasets: [{
                data: [
                    parseInt(roleCanvas.dataset.user, 10),
                    parseInt(roleCanvas.dataset.admin, 10),
                ],
                backgroundColor: ['#0b8a6e', '#fac775'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });

    /* ─── 4. User table ─── */
    const PER_PAGE = 10;
    let currentFilter = 'all';
    let currentPage = 1;

    function initials(name) {
        return name.split(' ').slice(0, 2).map(function(w) { return w[0]; }).join('').toUpperCase();
    }

    window.setFilter = function(f, btn) {
        currentFilter = f;
        currentPage = 1;
        document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        renderTable();
    };

    function getFiltered() {
        const q = (document.getElementById('searchInput').value || '').toLowerCase().trim();

        return USERS_DATA.filter(function(u) {
            const role = (u.role || 'user').toLowerCase().trim();
            const matchRole = currentFilter === 'all' || role === currentFilter;
            const matchQ = !q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q);
            return matchRole && matchQ;
        });
    }

    window.buildPager = function buildPager(totalPages) {
        const pagerBtns = document.getElementById('pagerBtns');
        pagerBtns.innerHTML = '';

        const prev = document.createElement('button');
        prev.className = 'pager-btn';
        prev.textContent = '‹';
        prev.disabled = currentPage === 1;
        prev.onclick = function() {
            currentPage--;
            renderTable();
        };
        pagerBtns.appendChild(prev);

        for (let p = 1; p <= totalPages; p++) {
            const isEdge = p === 1 || p === totalPages;
            const isNear = Math.abs(p - currentPage) <= 1;
            if (totalPages > 6 && !isEdge && !isNear) continue;

            const btn = document.createElement('button');
            btn.className = 'pager-btn' + (p === currentPage ? ' active' : '');
            btn.textContent = p;
            btn.onclick = (function(pg) {
                return function() {
                    currentPage = pg;
                    renderTable();
                };
            })(p);
            pagerBtns.appendChild(btn);
        }

        const next = document.createElement('button');
        next.className = 'pager-btn';
        next.textContent = '›';
        next.disabled = currentPage === totalPages;
        next.onclick = function() {
            currentPage++;
            renderTable();
        };
        pagerBtns.appendChild(next);
    }

    window.renderTable = function renderTable() {
        const filtered = getFiltered();
        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * PER_PAGE;
        const slice = filtered.slice(start, start + PER_PAGE);
        const tbody = document.getElementById('userTbody');
        const emptyState = document.getElementById('emptyState');

        if (!slice.length) {
            tbody.innerHTML = '';
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
            tbody.innerHTML = slice.map(function(u, i) {
                const role = (u.role || 'user').toLowerCase().trim();
                return '<tr>' +
                    '<td style="color:#9ca3af">' + (start + i + 1) + '</td>' +
                    '<td><div class="user-cell"><div class="avatar">' + initials(u.name) + '</div>' +
                    '<span style="font-weight:500;color:#111827">' + u.name + '</span></div></td>' +
                    '<td style="color:#6b7280;font-size:12px">' + u.email + '</td>' +
                    '<td style="color:#9ca3af;font-size:12px">' + u.joined + '</td>' +
                    '<td>' + (role === 'admin' ?
                        '<span class="pill-admin">Admin</span>' :
                        '<span class="pill-user">User</span>') +
                    '</td></tr>';
            }).join('');
        }

        document.getElementById('pagerInfo').textContent = total ?
            (start + 1) + '–' + Math.min(start + PER_PAGE, total) + ' dari ' + total + ' pengguna' :
            'Tidak ada hasil';

        buildPager(totalPages);
    }

    renderTable();

}); // DOMContentLoaded