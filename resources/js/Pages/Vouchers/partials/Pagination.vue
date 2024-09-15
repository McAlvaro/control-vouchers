<template>
    <nav aria-label="Pagination"
        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ startIndex }}</span>
                to
                <span class="font-medium">{{ endIndex }}</span>
                of
                <span class="font-medium">{{ totalItems }}</span>
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <button @click="onPageChange(currentPage - 1)" :disabled="currentPage === 1"
                class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed">
                Previous
            </button>
            <button @click="onPageChange(currentPage + 1)" :disabled="currentPage === totalPages"
                class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed">
                Next
            </button>
        </div>
    </nav>
</template>

<script setup>
import { computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';  // Importamos Inertia

const props = defineProps({
    currentPage: {
        type: Number,
        required: true
    },
    totalItems: {
        type: Number,
        required: true
    },
    itemsPerPage: {
        type: Number,
        required: true
    }
});

const totalPages = computed(() => Math.ceil(props.totalItems / props.itemsPerPage));

const startIndex = computed(() => ((props.currentPage - 1) * props.itemsPerPage) + 1);

const endIndex = computed(() => Math.min(startIndex.value + props.itemsPerPage - 1, props.totalItems));

const onPageChange = (newPage) => {
    if (newPage >= 1 && newPage <= totalPages.value) {
        // Emitimos un evento para cambiar de página utilizando Inertia
        Inertia.get(route(route().current()), { page: newPage }, { preserveState: true });
    }
};
</script>
