<template>
    <v-snackbar v-model="toast" timeout="3000" :color="color">
        {{ message }}
        <template v-slot:action="{ attrs }">
            <v-btn color="white" text v-bind="attrs" @click="toast = false">
                <v-icon>mdi-close-box</v-icon>
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import { computed } from 'vue';
import { defineProps, defineEmits } from 'vue';

// Define props
const props = defineProps({
    toast: Boolean,
    message: String,
    toastColor: String
});

// Emit event for v-model
const emit = defineEmits(['update:toast']);

// Computed property for color
const color = computed(() => {
    return props.toastColor != null ? props.toastColor : 'green darken-3';
});

// Method to close the toast
const closeToast = () => {
    emit('update:toast', false);
};
</script>
