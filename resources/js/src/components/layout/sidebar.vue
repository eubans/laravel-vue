<template>
    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">
        <nav ref="menu" id="sidebar">
            <div class="shadow-bottom"></div>

            <perfect-scrollbar class="list-unstyled menu-categories" tag="ul" :options="{ wheelSpeed: 0.5, swipeEasing: !0, minScrollbarLength: 40, maxScrollbarLength: 300, suppressScrollX: true }">
                <router-link tag="li" to="/" class="menu" @click.native="toggleMobileMenu">
                    <a class="dropdown-toggle">
                        <div class="">
                            <i data-feather="home"></i> <span>Dashboard</span>
                        </div>
                    </a>
                </router-link>

                <li class="menu" v-if="isModuleAllowed('Settings')">
                    <a href="#elements" v-b-toggle class="dropdown-toggle" @click.prevent>
                        <div class="">
                            <i data-feather="settings"></i> <span>Settings</span>
                        </div>
                        <div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-chevron-right"
                            >
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <b-collapse id="elements" accordion="menu">
                        <ul class="collapse submenu list-unstyled show">
                            <router-link v-if='isSubModuleAllowed("/settings/users")' tag="li" to="/settings/users" @click.native="toggleMobileMenu"><a>Users</a></router-link>
                            <router-link v-if='isSubModuleAllowed("/settings/users/roles")' tag="li" to="/settings/users/roles" @click.native="toggleMobileMenu"><a>User Role</a></router-link>
                            <router-link v-if='isSubModuleAllowed("/settings/users/types")' tag="li" to="/settings/users/types" @click.native="toggleMobileMenu"><a>User Type</a></router-link>
                        </ul>
                    </b-collapse>
                </li>

            </perfect-scrollbar>
        </nav>
    </div>
    <!--  END SIDEBAR  -->
</template>
<script>
    import feather from 'feather-icons';

    export default {
        data() {
            return {
                menu_collapse: 'dashboard',
                USERTYPE : this.$store.state.auth.user.user_type_code,
                USER_ACCESS : this.$store.state.auth.user_access,
                pendingCount: 0,
                batchCount: 0,
            };
        },

        watch: {
            $route(to) {
                const selector = document.querySelector('#sidebar a[href="' + to.path + '"]');
                const ul = selector.closest('ul.collapse');
                if (!ul) {
                    const ele = document.querySelector('.dropdown-toggle.not-collapsed');
                    if (ele) {
                        ele.click();
                    }
                }
            }
        },

        created(){
            this.isRoleAllowed('pending');
        },

        mounted() {
            feather.replace();

            // default menu selection on refresh
            const selector = document.querySelector('#sidebar a[href="' + window.location.pathname + '"]');
            if (selector) {
                const ul = selector.closest('ul.collapse');
                if (ul) {
                    let ele = ul.closest('li.menu').querySelectorAll('.dropdown-toggle');
                    if (ele) {
                        ele = ele[0];
                        setTimeout(() => {
                            ele.click();
                        });
                    }
                } else {
                    selector.click();
                }
            }
        },

        methods: {
            toggleMobileMenu() {
                if (window.innerWidth < 991) {
                    this.$store.commit('toggleSideBar', !this.$store.state.is_show_sidebar);
                }
            },
            isModuleAllowed(role){
                let isAccessAllowed = false;
                let userType = this.USER_ACCESS;

                userType.forEach((value, index) => {
                    if(value.module_name == role){
                        isAccessAllowed = true;
                    }
                });

                return isAccessAllowed;
            },

            isSubModuleAllowed(url){
                let isAccessAllowed = false;
                let userType = this.USER_ACCESS;

                userType.forEach((value, index) => {
                    if(value.url == url){
                        isAccessAllowed = true;
                    }
                });

                return isAccessAllowed;
            }
        }
    };
</script>
