<template>
    <div class="layout-px-spacing">
        <portal to="breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one d-flex" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><span>Dashboard</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </portal>

        <div class="maintanence text-center">
            <div class="container-fluid maintanence-content">
                <div class="">
                    <div class="maintanence-hero-img d-none">
                        <img class="dashboard" alt="logo" :src="require('../assets/images/under-construction.gif').default" />
                    </div>
                    <h1 class="error-title">Welcome to PrimeTech</h1>
                    <p class="error-text">Thank you for visiting. You may now use the platform.</p>
                    <!-- <p class="text">We are currently working on making some improvements <br /> to give you better user experience.</p> -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import '../assets/sass/pages/error/style-maintanence.scss';
    import '../assets/sass/elements/infobox.scss';
    import feather from 'feather-icons';

    export default {
        metaInfo: { title: 'Dashboard' },
        mounted() {
            feather.replace();
        },
        methods: {
        }
    };
</script>
