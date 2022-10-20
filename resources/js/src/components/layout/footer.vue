<template>
    <!-- BEGIN FOOTER -->
    <div class="footer-wrapper">
        <div class="footer-section f-section-1">
            <!--  -->
        </div>
        <div class="footer-section f-section-2">
            <p class="">© 2022 All Rights Reserved Powered by <a href="javascript:void(0);" class="text-primary">{{MIX_COMPANY_ACR}} - Development Team</a></p>
        </div>
    </div>
    <!-- END FOOTER -->
</template>
<script>
    export default {
        data() {
            return {
                //env
                MIX_COMPANY_ACR: process.env.MIX_COMPANY_ACR,
            };
        },
        mounted() {},
        methods: {}
    };
</script>
