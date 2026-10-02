@extends('layouts.admin')

@section('title', 'Dashboard Superadmin')

@section('content')
    <div class="flex items-start justify-between gap-4">
        <div>
            <span class="eyebrow">Overview</span>
            <h1 class="mt-2 text-3xl font-bold">Panel superadmin</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pantau ekosistem marketplace Business Development
                HMPS MI.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="soft-card p-5">
            <span class="text-xs font-bold text-slate-400">Total produk</span>
            <strong class="mt-3 block text-3xl">{{ $totalProducts }}</strong>
            <span class="mt-2 block text-xs text-slate-400">UMKM & preloved</span>
        </div>
        <div class="soft-card p-5">
            <span class="text-xs font-bold text-slate-400">Produk aktif</span>
            <strong class="mt-3 block text-3xl text-violet-600">{{ $activeProducts }}</strong>
            <span class="mt-2 block text-xs text-slate-400">Tampil di marketplace</span>
        </div>
        <div class="soft-card p-5">
            <span class="text-xs font-bold text-slate-400">Toko mahasiswa</span>
            <strong class="mt-3 block text-3xl">{{ $totalStores }}</strong>
            <span class="mt-2 block text-xs text-slate-400">Seller terdaftar</span>
        </div>
        <div class="soft-card p-5">
            <span class="text-xs font-bold text-slate-400">Disetujui 30 hari</span>
            <strong class="mt-3 block text-3xl">{{ $approvedProducts30DaysLabel }}</strong>
            <span class="mt-2 block text-xs text-slate-400">UMKM & preloved</span>
        </div>
    </div>

    <div class="mt-8 grid gap-5 lg:grid-cols-[1.35fr_.65fr]">
        <div class="soft-card min-w-0 overflow-hidden p-4 sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold">Trafik unik</h2>
                    <p class="mt-1 text-sm text-slate-500">Pengunjung unik platform dalam 30 hari terakhir.</p>
                </div>
                <span class="chip chip-purple">30 hari</span>
            </div>
            <div class="relative mt-5 h-56 min-w-0 sm:mt-6 sm:h-72">
                <canvas id="visitor-chart" aria-label="Grafik pengunjung unik 30 hari terakhir"></canvas>
            </div>
        </div>

        <div class="soft-card p-5 sm:p-6">
            <span class="eyebrow">Perlu perhatian</span>
            <h2 class="mt-2 text-xl font-bold">{{ $totalDrafts }} draft produk</h2>
            <p class="mt-3 text-sm leading-6 text-slate-500">Produk menunggu proses kurasi dan publikasi.</p>
            <a href="{{ route('admin.products') }}" class="btn-soft mt-6 w-full text-sm">
                Tinjau draft <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

    <div class="mt-8 grid gap-5 lg:grid-cols-2">
        <section class="soft-card p-5 sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div><span class="eyebrow">Produk mahasiswa</span>
                    <h2 class="mt-2 text-xl font-bold">Produk terbaru</h2>
                </div>
                <a href="{{ route('admin.products') }}" class="btn-soft !rounded-xl !px-3 !py-2 text-xs">Kelola produk <i
                        data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i></a>
            </div>
            <div class="mt-5 divide-y divide-slate-200/70">
                @forelse ($latestProducts as $product)
                    <div class="flex items-center gap-3 py-3 first:pt-0">
                        <img class="h-11 w-11 rounded-xl object-cover"
                            src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}"
                            alt="{{ $product->name }}">
                        <div class="min-w-0 flex-1">
                            <strong class="block truncate text-sm">{{ $product->name }}</strong>
                            <span
                                class="mt-1 block text-xs text-slate-400">{{ $product->owner?->name ?? 'Pemilik belum diatur' }}
                                · Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <span
                            class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span>
                    </div>
                @empty
                    <p class="py-5 text-sm text-slate-500">Belum ada produk mahasiswa.</p>
                @endforelse
            </div>
        </section>

        <section class="soft-card p-5 sm:p-6">
            <div class="flex items-start justify-between gap-3">
                <div><span class="eyebrow">Produk secondhand</span>
                    <h2 class="mt-2 text-xl font-bold">Preloved terbaru</h2>
                </div>
                <a href="{{ route('admin.preloved') }}" class="btn-soft !rounded-xl !px-3 !py-2 text-xs">Kelola preloved <i
                        data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i></a>
            </div>
            <div class="mt-5 divide-y divide-slate-200/70">
                @forelse ($latestPrelovedProducts as $product)
                    <div class="flex items-center gap-3 py-3 first:pt-0">
                        <img class="h-11 w-11 rounded-xl object-cover"
                            src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}"
                            alt="{{ $product->name }}">
                        <div class="min-w-0 flex-1">
                            <strong class="block truncate text-sm">{{ $product->name }}</strong>
                            <span
                                class="mt-1 block text-xs text-slate-400">{{ $product->owner?->name ?? 'Pemilik belum diatur' }}
                                · Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <span
                            class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span>
                    </div>
                @empty
                    <p class="py-5 text-sm text-slate-500">Belum ada barang preloved.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('visitor-chart');

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const labels = @json($chartLabels);
            const visitors = @json($chartVisitors);
            const isMobile = window.matchMedia('(max-width: 639px)').matches;
            const styles = getComputedStyle(document.documentElement);
            const muted = styles.getPropertyValue('--muted').trim() || '#737981';
            const purple = styles.getPropertyValue('--purple').trim() || '#655bd6';
            const context = canvas.getContext('2d');
            const xLabelStep = isMobile ? 8 : 4;

            const chart = new Chart(context, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Pengunjung unik',
                        data: visitors,
                        borderColor: purple,
                        borderWidth: 3,
                        pointRadius: isMobile ? 1.5 : 3,
                        pointHoverRadius: isMobile ? 5 : 6,
                        pointBackgroundColor: purple,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        backgroundColor: (chartContext) => {
                            const chartArea = chartContext.chart.chartArea;

                            if (!chartArea) {
                                return 'rgba(101, 91, 214, .14)';
                            }

                            const gradient = chartContext.chart.ctx.createLinearGradient(0,
                                chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(101, 91, 214, .28)');
                            gradient.addColorStop(1, 'rgba(101, 91, 214, 0)');

                            return gradient;
                        },
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 8,
                            right: isMobile ? 0 : 4,
                            bottom: 0,
                            left: 0,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            displayColors: false,
                            padding: 12,
                            callbacks: {
                                label: (tooltipItem) =>
                                    `${new Intl.NumberFormat('id-ID').format(tooltipItem.parsed.y)} pengunjung unik`,
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: muted,
                                autoSkip: false,
                                maxRotation: 0,
                                font: {
                                    size: isMobile ? 9 : 11,
                                },
                                callback: (value, index) => {
                                    if (index === 0 || index === labels.length - 1 || index %
                                        xLabelStep === 0) {
                                        return labels[index];
                                    }

                                    return '';
                                },
                            },
                            border: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            grid: {
                                color: 'rgba(115, 121, 129, .14)',
                            },
                            ticks: {
                                color: muted,
                                maxTicksLimit: isMobile ? 4 : 6,
                                precision: 0,
                                font: {
                                    size: isMobile ? 9 : 11,
                                },
                                callback: (value) => new Intl.NumberFormat('id-ID').format(value),
                            },
                            border: {
                                display: false,
                            },
                        },
                    },
                },
            });

            window.visitorChart = chart;
        });
    </script>
@endpush
