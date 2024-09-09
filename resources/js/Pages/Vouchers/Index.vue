<script setup>
import DataTable from '@/Components/partials/DataTable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const columns = [
    { header: '#', key: 'voucher_number' },
    { header: 'Fecha', key: 'date', render: (value) => new Date(value).toLocaleDateString() },
    { header: 'Chofer', key: 'delivery_to' },
    { header: 'Vehiculo', key: 'vehicle' },
    { header: 'Placa', key: 'plate' },
    { header: 'ES', key: 'station_name' },
    { header: 'Status', key: 'status', render: (value) => value === 'active' ? 'Active' : 'Cancelled' },
    { header: 'Total', key: 'total_amount', render: (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'Bs' }).format(value) }
]
</script>

<template>

    <Head title="Vouchers" />

    <AppLayout>
        <template #header>
        </template>

        <!-- Aquí el contenido irá al slot por defecto -->
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center mt-3 mx-8">
                        <h1 class="text-3xl font-semibold text-gray-800">Voucher Management</h1>
                        <button @click="openModal()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Voucher
                        </button>
                    </div>
                    <DataTable title="Vouchers" :columns="columns" :data="vouchers">
                        <!-- Acciones personalizadas dentro del slot -->
                        <template #actions="{ row }">
                            <button @click="$emit('edit-voucher', row)" class="text-blue-600 hover:text-blue-900 mr-2">
                                <EditIcon class="h-5 w-5" />
                            </button>
                            <button @click="$emit('delete-voucher', row)" class="text-red-600 hover:text-red-900">
                                <TrashIcon class="h-5 w-5" />
                            </button>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
