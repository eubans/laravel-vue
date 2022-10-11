<template>
    <div :class="[$store.state.layout_style, $store.state.menu_style]">
        <component v-bind:is="layout"></component>
    </div>
</template>
<script>
    // layouts
    import appLayout from './layouts/app-layout.vue';
    import authLayout from './layouts/auth-layout.vue';
    import unverifiedLayout from './layouts/unverified-layout.vue';

    import './assets/sass/app.scss';

    export default {
        metaInfo: {
            title: process.env.MIX_COMPANY_ACR,
            titleTemplate: process.env.MIX_PROJECT_TITLE,
        },
        components: {
            app: appLayout,
            auth: authLayout,
            unverified: unverifiedLayout
        },
        computed: {
            layout() {
                return this.$store.getters.layout;
            }
        },
        data() {
            return {};
        },
        created() {},
        mounted() {},
        methods: {}
    };
</script>
