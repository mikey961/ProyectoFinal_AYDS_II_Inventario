<x-admin-layout 
title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <x-wire-card title="Ventas del mes">
            <span class="text-2xl font-bold text-black">
                ₡ {{ number_format($ventasMes, 2) }}
            </span>
        </x-wire-card>
        <x-wire-card title="Compras del mes">
            <span class="text-2xl font-bold text-black">
                ₡ {{ number_format($comprasMes, 2) }}
            </span>
        </x-wire-card>
        <x-wire-card title="Productos">
            <span class="text-2xl font-bold text-black">
                {{$productosTotales }}
            </span>
        </x-wire-card>
        <x-wire-card title="Stock total">
            <span class="text-2xl font-bold text-black">
                {{ $stockTotal }}
            </span>
        </x-wire-card>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-wire-card title="Top 5 Clientes"
            class="mt-4">
            <div class="h-80">
                <canvas id="customersChart"></canvas>
            </div>
        </x-wire-card>
        <x-wire-card title="Top 5 productos vendidos"
            class="mt-4">
            <div class="h-64">
                <canvas id="productsChart"></canvas>
            </div>
        </x-wire-card>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctxCust = document.getElementById('customersChart').getContext('2d');
                new Chart(ctxCust, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topCustomers->pluck('name')) !!},
                        datasets: [{
                            label: 'Monto Total Comprado (₡)',
                            data: {!! json_encode($topCustomers->pluck('total_spent')) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });

                const ctxProducts = document.getElementById('productsChart').getContext('2d');
                new Chart(ctxProducts, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topProducts->pluck('name')) !!},
                        datasets: [{
                            label: 'Cantidad vendida',
                            data: {!! json_encode($topProducts->pluck('total_qty')) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { beginAtZero: true }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>