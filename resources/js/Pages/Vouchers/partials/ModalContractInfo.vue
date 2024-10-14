<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    },
    contract: {
        type: Object,
        required: true
    },
})

const emit = defineEmits(['close'])

const closeModal = () => {
    emit('close')
}
</script>
<template>
    <div v-if="show" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl text-center font-bold leading-6 text-gray-900" id="modal-title">
                        Detalle
                    </h3>
                    <div class="mt-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Estación:
                                        </span>{{ contract.station_name }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">NIT:
                                        </span>{{ contract.station_nit }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Nro Contracto:
                                        </span>{{ contract.contract_number }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Ciudad:
                                        </span>{{ contract.city }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Combustible:
                                        </span>{{ contract.fuel_type }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Fecha Inicio:
                                        </span>{{ contract.start_date }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Fecha Fin:
                                        </span>{{ contract.end_date }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Cantidad:
                                        </span>{{ contract.quantity }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Precio:
                                        </span>{{ contract.unit_price }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Saldo:
                                        </span>{{ contract.balance }}</h3>
                                </div>
                            </div>
                            <div class="w-full col-span-2 p-1">
                                <div class="flex items-center justify-center">
                                    <h3 class="font-extralight text-lg text-gray-600"><span class="font-bold mr-2">Total:</span> {{contract.total_amount}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-2 sm:grid sm:grid-cols-1 sm:gap-3 sm:grid-flow-row-dense">
                            <button type="button" @click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
