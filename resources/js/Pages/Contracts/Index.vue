<script setup>
import DataTable from '@/Components/partials/DataTable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Pagination from '../Vouchers/partials/Pagination.vue';
import { computed, ref } from 'vue';
import ModalVoucher from '../Vouchers/partials/ModalVoucher.vue';
import ConfirmDeleteModal from '@/Components/partials/ConfirmDeleteModal.vue';
import ModalContractInfo from '../Vouchers/partials/ModalContractInfo.vue';

const columns = [
    { header: '#', key: 'contract_number' },
    { header: 'Surtidor', key: 'station_name' },
    { header: 'Ciudad', key: 'city' },
    { header: 'Desde', key: 'start_date' },
    { header: 'Hasta', key: 'end_date' },
    { header: 'Cantidad', key: 'quantity' },
    { header: 'Saldo', key: 'balance' },
    { header: 'Total', key: 'total_amount' }
];

let props = defineProps({ contracts: Array, filters: Object, data_session: Object });
const currentContract = ref(null)
const showModal = ref(false);
const showDeleteModal = ref(false);
const contractToDelete = ref(null);
const contractToShow = ref(null);
const showInfoModal = ref(false);
const isEditing = ref(false);

const form = useForm({
    station_name: '',
    station_nit: '',
    contract_number: '',
    city: '',
    fuel_type: '',
    start_date: '',
    end_date: '',
    quantity: 0,
    unit_price: 0,
    total_amount: 0,
    balance: 0,
});

const totalAmount = computed(() => {
    return roundTo(Number(form.quantity * form.unit_price), 2);
});

const titleModal = computed(() => {
    return isEditing.value ? 'Editar Contrato' : 'Nuevo Contracto';
});

const actionButtonText = computed(() => {
    return isEditing.value ? 'Actualizar' : 'Guardar';
});

const saveVoucher = () => {
    const totalAmountValue = totalAmount.value;

    if (isEditing.value) {

        form.total_amount = totalAmountValue;

        form.put(route('contracts.update', form.id), {
            onSuccess: () => {
                showModal.value = false;
                resetData();
            },
            onError: (errors) => {
                console.log('Errores: ', errors)
            }
        });
    } else {

        form.total_amount = totalAmountValue;
        form.balance = form.quantity;
        form.post(route('contracts.store'), {
            onSuccess: () => {
                showModal.value = false;
                const contractSaved = props.data_session.contract;
                resetData();
            },
            onError: (errors) => {
                console.error('Errores: ', errors);
            }
        });

    }
};

const handleEditVoucher = (contract) => {
    currentContract.value = contract;
    openModal();
};

const openModal = () => {
    console.log('currentContract: ', currentContract);
    if (currentContract.value) {
        isEditing.value = true;
        form.id = currentContract.value.id;
        form.station_name = currentContract.value.station_name;
        form.station_nit = currentContract.value.station_nit;
        form.contract_number = currentContract.value.contract_number;
        form.city = currentContract.value.city;
        form.fuel_type = currentContract.value.fuel_type;
        form.start_date = currentContract.value.start_date;
        form.end_date = currentContract.value.end_date;
        form.quantity = currentContract.value.quantity;
        form.unit_price = currentContract.value.unit_price;
        form.total_amount = currentContract.value.total_amount;
    } else {
        isEditing.value = false;
        resetData();
    }
    showModal.value = true;
};

const deleteVoucher = () => {
    if (contractToDelete.value) {
        form.delete(route('contracts.destroy', contractToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
            },
            onError: (errors) => {
                console.error('Errores al eliminar el voucher: ', errors);
            }
        });
    }
};

const openDeleteModal = (contract) => {
    showDeleteModal.value = true;
    contractToDelete.value = contract;
};

const handleShowInfo = (contract) => {
    contractToShow.value = contract;
    openShowInfoModal();
};

const openShowInfoModal = () => {
    showInfoModal.value = true;
};

const resetFilters = () => {

    console.log("Reset Filters.....");
};

const closeModal = () => {
    showModal.value = false;
    resetData();
};

const closeShowInfoModal = () => {
    showInfoModal.value = false;
};

const resetData = () => {
    form.reset();
    currentContract.value = null;
    props.data_session.contract = null;
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'BOB' }).format(value);
};

function roundTo(num, precision) {
    return parseFloat(num).toFixed(precision);
}

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    contractToDelete.value = null;
};

</script>
<template>

    <Head title="Contracts" />
    <AppLayout>
        <template #header>
        </template>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl mr-8 font-semibold text-gray-800">Contratos</h1>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center mt-3 mx-8">
                        <div class="flex flex-row">
                            <div class="flex flex-row justify-center items-center">
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Chofer:
                                    </label>
                                    <input placeholder="Buscar Chofer" type="text" id="small-input"
                                        class="inline-block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 ">
                                </div>
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Placa:
                                    </label>
                                    <input placeholder="Buscar Placa" type="text" id="small-input"
                                        class="inline-block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 ">
                                </div>
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Desde:
                                    </label>
                                    <input type="date" id="from_date"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="flex flex-row w-60 justify-center items-center">
                                    <label for="small-input"
                                        class="inline-block text-sm font-medium p-2 text-gray-900 mr-2">Hasta:
                                    </label>
                                    <input type="date" id="to_date"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <button @click="resetFilters"
                                    class="text-blue-500 text-sm underline hover:text-blue-600 ml-2 mb-2">Borrar
                                    Filtros</button>
                            </div>
                        </div>
                        <div class="inline-block">
                            <button @click="openModal"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Contracto
                            </button>
                        </div>
                        <ModalVoucher v-model:show="showModal" :formData="form" :title="titleModal"
                            :actionButtonText="actionButtonText" @submit="saveVoucher" @close="closeModal">
                            <template #default="{ formData }">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label for="station_name"
                                            class="block text-sm font-medium text-gray-700">Estación de Servicio</label>
                                        <input type="text" v-model="form.station_name" id="station_name" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="station_nit"
                                            class="block text-sm font-medium text-gray-700">NIT</label>
                                        <input type="text" v-model="form.station_nit" id="station_nit" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="fuel_type"
                                            class="block text-sm font-medium text-gray-700">Combustible</label>
                                        <select v-model="form.fuel_type" id="fuel_type" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Seleccionar una Combustible</option>
                                            <option value="GASOLINA">GASOLINA</option>
                                            <option value="DIESEL">DIESEL</option>
                                        </select>
                                    </div>
                                    <!-- Campos personalizados -->
                                    <div>
                                        <label for="contract_number" class="block text-sm font-medium text-gray-700">Nro
                                            Contracto</label>
                                        <input type="text" v-model="form.contract_number" id="contract_number" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="ciy" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                        <input type="text" v-model="form.city" id="city" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha
                                            Inicio</label>
                                        <input type="date" v-model="form.start_date" id="start_date" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha
                                            Fin</label>
                                        <input type="date" v-model="form.end_date" id="end_date" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="quantity"
                                            class="block text-sm font-medium text-gray-700">Cantidad</label>
                                        <input type="number" v-model="form.quantity" id="quantity" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="unit_price"
                                            class="block text-sm font-medium text-gray-700">Precio</label>
                                        <input type="number" step="0.01" v-model="form.unit_price" id="unit_price"
                                            required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="col-span-2 flex justify-end items-center">
                                    <p class="text-lg font-bold ">Monto Total: {{ formatCurrency(totalAmount) }}</p>
                                </div>
                            </template>
                        </ModalVoucher>
                    </div>
                    <ConfirmDeleteModal :show="showDeleteModal" :entity="'Contrato'" @close="closeDeleteModal"
                        @confirm="deleteVoucher" />
                    <ModalContractInfo :show="showInfoModal" :contract="contractToShow" @close="closeShowInfoModal" />
                    <DataTable title="Contratos" :columns="columns" :data="contracts.data"
                        @edit-voucher="handleEditVoucher" @delete-voucher="openDeleteModal"
                        @info-voucher="handleShowInfo" />
                    <Pagination :currentPage="contracts.current_page" :totalItems="contracts.total"
                        :itemsPerPage="contracts.per_page" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
