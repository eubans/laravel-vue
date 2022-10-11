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

                <li class="menu" v-if="isRoleAllowed('verification')">
                    <a href="#verifications" v-b-toggle class="dropdown-toggle" @click.prevent>
                        <div class="">
                            <i data-feather="thumbs-up"></i> <span>Verification List</span>
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
                    <b-collapse id="verifications" accordion="menu">
                        <ul class="collapse submenu list-unstyled show">
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/verification/pending/" @click.native="toggleMobileMenu"><a>Pending</a></router-link>
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/verification/approved/" @click.native="toggleMobileMenu"><a>Approved</a></router-link>
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/verification/declined/" @click.native="toggleMobileMenu"><a>Declined</a></router-link>
                        </ul>
                    </b-collapse>
                </li>

                <router-link v-if="isRoleAllowed('portfolio')" tag="li" to="/portfolio" class="menu" @click.native="toggleMobileMenu">
                    <a class="dropdown-toggle">
                        <div class="">
                            <i data-feather="user"></i> <span>Portfolio</span>
                        </div>
                    </a>
                </router-link>

                <router-link v-if="isRoleAllowed('claims')" tag="li" to="/pages/coming-soon" class="menu" @click.native="toggleMobileMenu">
                    <a class="dropdown-toggle">
                        <div class="">
                            <i data-feather="edit"></i> <span>Claims</span>
                        </div>
                    </a>
                </router-link>

                <router-link v-if="isRoleAllowed('payment')" tag="li" to="/pages/coming-soon" class="menu" @click.native="toggleMobileMenu">
                    <a class="dropdown-toggle">
                        <div class="">
                            <i data-feather="dollar-sign"></i> <span>Payment</span>
                        </div>
                    </a>
                </router-link>

                <router-link v-if="isRoleAllowed('help')" tag="li" to="/pages/coming-soon" class="menu" @click.native="toggleMobileMenu">
                    <a class="dropdown-toggle">
                        <div class="">
                            <i data-feather="help-circle"></i> <span>Help</span>
                        </div>
                    </a>
                </router-link>

                <li class="menu" v-if="isRoleAllowed('settings')">
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
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/settings/users/" @click.native="toggleMobileMenu"><a>Users</a></router-link>
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/settings/users/roles/" @click.native="toggleMobileMenu"><a>User Role</a></router-link>
                            <router-link v-if='["ADM"].includes(USERTYPE)' tag="li" to="/settings/users/types/" @click.native="toggleMobileMenu"><a>User Type</a></router-link>
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
                modules: [
                    {
                        'user_type': 'ADM',
                        'modules': ['settings']
                    },
                ],
                USERTYPE : this.$store.state.auth.user.user_type_code,
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
            isRoleAllowed(role){
                let isAccessAllowed = false;
                let userType = this.$store.state.auth.user.user_type_code;

                this.modules.forEach((value, index) => {
                    if(value.user_type == userType){
                        if(value.modules.includes(role)){
                            isAccessAllowed = true;
                        }
                    }
                });

                return isAccessAllowed;
            }
        }
    };
</script>
