<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <!-- <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                    aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form> -->

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <Link :href="route('logout')" class="btn btn-danger" method="post" as="button">
            Logout
            </Link>

        </ul>
    </nav>
    <!-- /.navbar -->
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<style>
.logo {
    height: 45px;
    width: 250px;
}

.logo-mobile {
    height: 60px;
    width: 200px;
}

#form {
    background: white;
    padding: 25px;
    border-radius: 14px;
    border: 2px solid #14756a23;
}
</style>
