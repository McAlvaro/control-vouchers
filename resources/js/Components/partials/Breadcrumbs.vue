<template>
    <div v-if="breadcrumbs && breadcrumbs.length" class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li v-for="(breadcrumb, key) in breadcrumbs" :key="key" class="breadcrumb-item active">
                            <a :href="breadcrumb.url">{{ key }}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

// Define props
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    breadcrumbs: {
        type: Object,
        default: () => ({})
    }
});
</script>
