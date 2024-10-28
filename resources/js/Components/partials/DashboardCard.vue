<template>
    <div class="p-6 bg-gray-100 w-96">
        <div :class="`rounded-lg shadow-md p-6 transition-all duration-300 ease-in-out ${cardColor}`">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold text-white">{{ companyName }}</h3>
                <TruckIcon class="w-8 h-8 text-white opacity-80" />
            </div>
            <div class="text-center my-2">
                <p class="text-2xl font-bold text-white">
                    {{ formatNumber(availableFuel) }}
                    <span class="text-2xl font-normal">litros</span>
                </p>
                <p class="text-white text-opacity-90 text-sm mt-1">Disponible</p>
            </div>
            <div class="space-y-2">
                <p class="text-white text-opacity-90">
                    {{ fuelType }}
                </p>
            </div>
            <div class="space-y-2">
                <p class="text-white text-opacity-90">
                    <span class="font-medium">Contrato Finaliza en:</span>
                    {{ expirationDate }}
                </p>
            </div>
            <div class="mt-4">
                <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div :style="{ width: `${fuelPercentage}%` }"
                        class="bg-cyan-500 h-full rounded-full transition-all duration-300 ease-in-out"></div>
                </div>
                <p class="text-white text-opacity-90 text-sm mt-1">
                    {{ fuelPercentage }}% Restante
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { TruckIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    companyName: {
        type: String,
        required: true
    },
    fuelType: {
        type: String,
        required: true
    },
    availableFuel: {
        type: Number,
        required: true
    },
    totalFuelCapacity: {
        type: Number,
        required: true
    },
    expirationDate: {
        type: String,
        required: true
    }
});

const cardColors = [
    'bg-blue-400 hover:bg-blue-600',
    'bg-green-400 hover:bg-green-600',
    'bg-purple-400 hover:bg-purple-600',
    'bg-red-400 hover:bg-red-600',
    'bg-yellow-400 hover:bg-yellow-600',
    'bg-indigo-400 hover:bg-indigo-600',
    'bg-pink-400 hover:bg-pink-600',
    'bg-teal-400 hover:bg-teal-600'
];

const cardColor = ref('');

onMounted(() => {
    const randomIndex = Math.floor(Math.random() * cardColors.length);
    cardColor.value = cardColors[randomIndex].trim();
});

const fuelPercentage = computed(() => {
    return Math.round((props.availableFuel / props.totalFuelCapacity) * 100);
});

const formatNumber = (number) => {
    return new Intl.NumberFormat('en-US').format(number);
};
</script>
