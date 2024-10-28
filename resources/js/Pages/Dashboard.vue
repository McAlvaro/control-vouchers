<script setup>
import DashboardCard from '@/Components/partials/DashboardCard.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({ contracts: Array })
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
        </template>

        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-4 gap-1">
                        <div v-for="contract in contracts">
                            <DashboardCard
                                :id="contract.id"
                                :companyName="contract.station_name"
                                :fuelType="contract.fuel_type"
                                :availableFuel="contract.balance"
                                :totalFuelCapacity="contract.quantity"
                                :expirationDate="contract.end_date"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
