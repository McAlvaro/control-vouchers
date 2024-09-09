<script setup>
import Footer from '@/Components/global/Footer.vue';
import Navbar from '@/Components/global/Navbar.vue';
import Sidebar from '@/Components/global/Sidebar.vue';
</script>

<template>
    <div>
        <Navbar :user="$page.props.auth.user" />

        <Sidebar :user="$page.props.auth.user" />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <slot name="header"></slot> <!-- Aquí se usa el slot header -->
            </header>

            <!-- Main content -->
            <section class="content">
                <slot></slot> <!-- El slot por defecto se debe dejar vacío -->
            </section>
            <!-- /.content -->
        </div>

        <Footer />
    </div>
</template>
