<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    },
    voucher: {
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
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Chofer:
                                        </span>{{ voucher.delivery_to }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Estación:
                                        </span>{{ voucher.station_name }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Vehículo:
                                        </span>{{ voucher.vehicle }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Placa:
                                        </span>{{ voucher.plate }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Kilometraje:
                                        </span>{{ voucher.kilometer }}</h3>
                                </div>
                            </div>
                            <div class="w-full p-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-extralight text-gray-600"><span class="font-bold mr-2">Fecha:
                                        </span>{{ voucher.date }}</h3>
                                </div>
                            </div>
                            <div class="w-full col-span-2 p-1">
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-300 uppercase bg-gray-50 dark:bg-gray-300 dark:text-gray-800">
                                            <tr>
                                                <th scope="col" class="px-3 py-2">
                                                    Descripción
                                                </th>
                                                <th scope="col" class="px-3 py-2">
                                                    Cantidad
                                                </th>
                                                <th scope="col" class="px-3 py-2">
                                                    Precio
                                                </th>
                                                <th scope="col" class="px-3 py-2">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in voucher.items" :key="item.id"
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-300">
                                                <th scope="row"
                                                    class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                    {{ item.description }}
                                                </th>
                                                <td class="px-3 py-2">
                                                    {{ item.quantity }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    {{ item.unit_price }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    {{ item.total_price }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="w-full col-span-2 p-1">
                                <div class="flex items-center justify-center">
                                    <h3 class="font-extralight text-lg text-gray-600"><span
                                            class="font-bold mr-2">Total:</span> {{ voucher.total_amount }}</h3>
                                </div>
                            </div>
                            <div v-if="voucher.refund" class="w-full col-span-2 p-1">
                                <h3 class="text-lg text-gray-600 font-bold">Devoluciones</h3>
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-300 uppercase bg-gray-50 dark:bg-gray-300 dark:text-gray-800">
                                            <tr>
                                                <th scope="col" class="px-3 py-2">
                                                    Fecha
                                                </th>
                                                <th scope="col" class="px-3 py-2">
                                                    Nro Factura
                                                </th>
                                                <th scope="col" class="px-3 py-2">
                                                    Cantidad
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-300">
                                                <th scope="row"
                                                    class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                    {{ voucher.refund.date }}
                                                </th>
                                                <td class="px-3 py-2">
                                                    {{ voucher.refund.invoice_number }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    {{ voucher.refund.quantity }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-2 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <a @click="closeModal" :href="route('vouchers.print', voucher.id)" target="_blank"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500  text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                                Imprimir
                            </a>
                            <button type="button" @click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
