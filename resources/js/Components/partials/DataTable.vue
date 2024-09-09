<script setup>
defineProps({
  columns: {
    type: Array,
    required: true,
    // Cada columna debería tener un `header` (texto del encabezado) y un `key` (nombre de la propiedad de los datos)
    default: () => []
  },
  data: {
    type: Array,
    required: true
  }
})
</script>
<template>
  <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
    <table class="min-w-full leading-normal">
      <thead>
        <tr>
          <!-- Renderiza dinámicamente los encabezados de las columnas -->
          <th v-for="column in columns" :key="column.key" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            {{ column.header }}
          </th>
          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <!-- Renderiza dinámicamente las filas y los datos -->
        <tr v-for="row in data" :key="row.id">
          <td v-for="column in columns" :key="column.key" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
            {{ column.render ? column.render(row[column.key]) : row[column.key] }}
          </td>
          <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
            <slot name="actions" :row="row"></slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
