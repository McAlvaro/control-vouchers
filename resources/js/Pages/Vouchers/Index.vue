<script setup>
import DataTable from '@/Components/partials/DataTable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import ModalVoucher from './partials/ModalVoucher.vue';
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/solid'
import Pagination from './partials/Pagination.vue';
import ConfirmDeleteModal from '@/Components/partials/ConfirmDeleteModal.vue';
import ModalVoucherInfo from './partials/ModalVoucherInfo.vue';

const columns = [
    { header: '#', key: 'voucher_number' },
    { header: 'Fecha', key: 'date', render: (value) => new Date(value).toLocaleDateString() },
    { header: 'Chofer', key: 'delivery_to' },
    { header: 'Vehiculo', key: 'vehicle' },
    { header: 'Placa', key: 'plate' },
    { header: 'ES', key: 'station_name' },
    //{ header: 'Status', key: 'state', render: (value) => value === 'ACTIVE' ? 'Active' : 'Cancelled' },
    { header: 'Total', key: 'total_amount', render: (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'BOB' }).format(value) }
];

const showModal = ref(false);
const showDeleteModal = ref(false);
const showInfoModal = ref(false);
const isEditing = ref(false);
const currentVoucher = ref(null);
const voucherToDelete = ref(null);
const voucherToShow = ref(null);
const props = defineProps({ vouchers: Array, data_session: Object });
const delivery_to = ref('')
const plate = ref('')

const form = useForm({
    date: '',
    delivery_to: '',
    vehicle: '',
    plate: '',
    station_name: '',
    kilometer: '',
    status: 'active',
    total_amount: 0,
    items: []
});

const totalAmount = computed(() => {
    return form.items.reduce((total, item) => {
        return roundTo((Number(total) + Number(item.quantity * item.unit_price)), 2);
    }, 0);
});

watch(
    () => form.items,
    (newItems) => {
        newItems.forEach(item => {
            item.total_price = roundTo(item.quantity * item.unit_price, 2);
        });
    },
    { deep: true }  // Observar cambios dentro de los objetos de la lista
);

const fetchVouchers = () => {
    const filters = {};

    if(delivery_to.value.length > 0){
        filters['delivery_to'] = delivery_to.value;
    }
    if(plate.value.length > 0){
        filters['plate'] = plate.value;
    }
    router.get(route('vouchers.index', filters), {}, { preserveState: true });
};

watch(delivery_to, fetchVouchers);

watch(plate, fetchVouchers);

const openModal = () => {
    console.log('currentVoucher: ', currentVoucher);
    if (currentVoucher.value) {
        isEditing.value = true;
        form.id = currentVoucher.value.id;
        form.date = currentVoucher.value.date;
        form.delivery_to = currentVoucher.value.delivery_to;
        form.vehicle = currentVoucher.value.vehicle;
        form.plate = currentVoucher.value.plate;
        form.station_name = currentVoucher.value.station_name;
        form.kilometer = currentVoucher.value.kilometer;
        form.status = currentVoucher.value.status;
        form.total_amount = currentVoucher.value.total_amount;
        form.items = currentVoucher.value.items;
    } else {
        // Agregar un nuevo voucher
        isEditing.value = false;
        resetData();
    }
    showModal.value = true;
};

const openShowInfoModal = () => {
    showInfoModal.value = true;
};

const closeShowInfoModal = () => {
    showInfoModal.value = false;
};

const openDeleteModal = (voucher) => {
    showDeleteModal.value = true;
    voucherToDelete.value = voucher;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    voucherToDelete.value = null;
};

const closeModal = () => {
    showModal.value = false;
    resetData();
};

const deleteVoucher = () => {
    if (voucherToDelete.value) {
        form.delete(route('vouchers.destroy', voucherToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
            },
            onError: (errors) => {
                console.error('Errores al eliminar el voucher: ', errors);
            }
        });
    }
};

const saveVoucher = () => {
    // Actualizar total_amount directamente desde totalAmount
    const totalAmountValue = totalAmount.value;

    if (isEditing.value) {
        // Actualizar voucher existente
        form.total_amount = totalAmountValue;
        form.put(route('vouchers.update', form.id), {
            onSuccess: () => {
                showModal.value = false;
                resetData();
            },
            onError: (errors) => {
                console.error('Errores: ', errors);
            }
        });
    } else {
        // Crear nuevo voucher
        form.total_amount = totalAmountValue;
        form.post(route('vouchers.store'), {
            onSuccess: () => {
                showModal.value = false;
                const voucherSaved = props.data_session.voucher;
                resetData();
                handleShowInfo(voucherSaved)
            },
            onError: (errors) => {
                console.error('Errores: ', errors);
            }
        });
    }
};

const handleEditVoucher = (voucher) => {
    currentVoucher.value = voucher;
    openModal();
};

const handleShowInfo = (voucher) => {
    voucherToShow.value = voucher;
    openShowInfoModal();
};

const addItem = () => {
    form.items.push({
        quantity: 0,
        description: '',
        unit_price: 0,
        total_price: 0
    });
};

const removeItem = (index) => {
    form.items.splice(index, 1);
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'BOB' }).format(value);
};

const resetData = () => {
    form.reset();
    totalAmount.value = 0;
    currentVoucher.value = null;
    props.data_session.voucher = null;
};

function roundTo(num, precision) {
    return parseFloat(num).toFixed(precision);
}
const actionButtonText = computed(() => {
    return isEditing.value ? 'Actualizar' : 'Guardar';
});

const titleModal = computed(() => {
    return isEditing.value ? 'Editar Vale' : 'Nuevo Vale';
});
</script>

<template>

    <Head title="Vouchers" />

    <AppLayout>
        <template #header>
        </template>

        <!-- Contenido del slot por defecto -->
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl mr-8 font-semibold text-gray-800">Vales</h1>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center mt-3 mx-8">
                        <div class="flex flex-row">
                            <div class="flex flex-row justify-center items-center">
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Chofer:
                                    </label>
                                    <input v-model="delivery_to" placeholder="Buscar Chofer" type="text" id="small-input"
                                        class="inline-block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 ">
                                </div>
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Placa:
                                    </label>
                                    <input v-model="plate" placeholder="Buscar Placa" type="text" id="small-input"
                                        class="inline-block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 ">
                                </div>
                            </div>
                        </div>
                        <button @click="openModal"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Agregar Nuevo Vale
                        </button>
                        <ModalVoucher v-model:show="showModal" :formData="form" :title="titleModal"
                            :actionButtonText="actionButtonText" @submit="saveVoucher" @close="closeModal">
                            <template #default="{ formData }">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label for="delivery_to"
                                            class="block text-sm font-medium text-gray-700">Chofer</label>
                                        <input type="text" v-model="form.delivery_to" id="delivery_to" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="station_name"
                                            class="block text-sm font-medium text-gray-700">Estación de Servicio</label>
                                        <input type="text" v-model="form.station_name" id="delivery_to" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <!-- Campos personalizados -->
                                    <div>
                                        <label for="vehicle"
                                            class="block text-sm font-medium text-gray-700">Vehículo</label>
                                        <input type="text" v-model="form.vehicle" id="vehicle" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="plate" class="block text-sm font-medium text-gray-700">Placa</label>
                                        <input type="text" v-model="form.plate" id="plate" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="kilometer"
                                            class="block text-sm font-medium text-gray-700">Kilometraje</label>
                                        <input type="text" v-model="form.kilometer" id="plate" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                                        <input type="date" v-model="form.date" id="date" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <!-- Puedes añadir más campos personalizados aquí -->
                                    <!-- Items section -->
                                    <div class="mt-6 col-span-2">
                                        <h4 class="text-lg font-medium text-gray-900 mb-2">Items</h4>
                                        <div v-for="(item, index) in form.items" :key="index"
                                            class="border-t border-gray-200 pt-2 mb-2">
                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label :for="'description-' + index"
                                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                                    <input type="text" v-model="item.description"
                                                        :id="'description-' + index" rows="2" required
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></input>
                                                </div>
                                                <div>
                                                    <label :for="'quantity-' + index"
                                                        class="block text-sm font-medium text-gray-700">Cantidad</label>
                                                    <input type="number" v-model="item.quantity"
                                                        :id="'quantity-' + index" step="0.01" required
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label :for="'unit_price-' + index"
                                                        class="block text-sm font-medium text-gray-700">Precio
                                                        Unitario</label>
                                                    <input type="number" v-model="item.unit_price"
                                                        :id="'unit_price-' + index" step="0.01" required
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                            <div class="mt-2 flex justify-end items-center">
                                                <p class="text-sm mr-4 text-gray-500">Total: {{
                                                    formatCurrency(item.quantity
                                                        * item.unit_price) }}</p>
                                                <button type="button" @click="removeItem(index)"
                                                    class="text-red-600 hover:text-red-900">
                                                    <TrashIcon class=" h-5 w-5" />
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" @click="addItem"
                                            class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <PlusIcon class="h-5 w-5 mr-2" />
                                            Agregar Item
                                        </button>
                                    </div>
                                </div>
                                <div class="col-span-2 flex justify-end items-center">
                                    <p class="text-lg font-bold ">Monto Total: {{ formatCurrency(totalAmount) }}</p>
                                </div>
                            </template>
                        </ModalVoucher>
                    </div>
                    <ConfirmDeleteModal :show="showDeleteModal" :entity="'Vale'" @close="closeDeleteModal"
                        @confirm="deleteVoucher" />
                    <ModalVoucherInfo :show="showInfoModal" :voucher="voucherToShow" @close="closeShowInfoModal" />

                    <DataTable title="Vouchers" :columns="columns" :data="vouchers.data"
                        @edit-voucher="handleEditVoucher" @delete-voucher="openDeleteModal"
                        @info-voucher="handleShowInfo" />
                    <Pagination :currentPage="vouchers.current_page" :totalItems="vouchers.total"
                        :itemsPerPage="vouchers.per_page" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
