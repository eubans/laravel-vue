<template>
    <div>
        <!--  BEGIN NAVBAR  -->
        <div class="header-container fixed-top">
            <header class="header navbar navbar-expand-sm">
                <ul class="navbar-item theme-brand flex-row text-center">
                    <li class="nav-item theme-logo">
                        <router-link to="/">
                            <img :src="require('../../assets/images/logo.png').default" class="navbar-logo" alt="logo" />
                        </router-link>
                    </li>
                    <li class="nav-item theme-text">
                        <router-link to="/" class="nav-link"> {{MIX_COMPANY_ACR}} {{MIX_PROJECT_NAME}} </router-link>
                    </li>
                </ul>
                <div class="d-none horizontal-menu">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom" @click="$store.commit('toggleSideBar', !$store.state.is_show_sidebar)">
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
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </div>
                <ul class="navbar-item flex-row ml-md-0 ml-auto" v-show="false">
                    <li class="nav-item align-self-center search-animated" :class="{ 'show-search': $store.state.is_show_search }">
                        <svg
                            @click="$store.commit('toggleSearch', !$store.state.is_show_search)"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-search toggle-search"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <form class="form-inline search-full form-inline search" :class="{ 'input-focused': $store.state.is_show_search }">
                            <div class="search-bar">
                                <input type="text" class="form-control search-form-control ml-lg-auto" placeholder="Search..." />
                            </div>
                        </form>
                    </li>
                </ul>

                <div class="navbar-item flex-row ml-md-auto">
                    <div class="user-verification-badge py-2 text-center">

                        <span v-if="USERTYPE == 'ADM'" class="badge badge-dark me-1">Administrator Account</span>
                    </div>

                    <div class="dark-mode d-flex align-items-center">
                        <a v-if="$store.state.dark_mode == 'light'" href="javascript:;" class="d-flex align-items-center" @click="toggleMode('dark')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-sun"
                            >
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                            <span class="ml-2">Light</span>
                        </a>
                        <a v-if="$store.state.dark_mode == 'dark'" href="javascript:;" class="d-flex align-items-center" @click="toggleMode('system')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-moon"
                            >
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                            <span class="ml-2">Dark</span>
                        </a>
                        <a v-if="$store.state.dark_mode == 'system'" href="javascript:;" class="d-flex align-items-center" @click="toggleMode('light')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-airplay"
                            >
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span class="ml-2">System</span>
                        </a>
                    </div>

                    <b-dropdown v-show="false" toggle-tag="a" variant="icon-only" toggle-class="nav-link" class="nav-item message-dropdown" :right="true">
                        <template #button-content>
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
                                class="feather feather-mail"
                            >
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </template>

                        <b-dropdown-item>
                            <b-media class="media">
                                <template #aside>
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title rounded-circle">KY</span>
                                    </div>
                                </template>
                                <h5 class="usr-name">Kara Young</h5>
                                <p class="msg-title">ACCOUNT UPDATE</p>
                            </b-media>
                        </b-dropdown-item>
                        <b-dropdown-item>
                            <b-media class="media">
                                <template #aside>
                                    <img :src="require('../../assets/images/profile-15.jpeg').default" alt="avatar" />
                                </template>
                                <h5 class="usr-name">Daisy Anderson</h5>
                                <p class="msg-title">ACCOUNT UPDATE</p>
                            </b-media>
                        </b-dropdown-item>
                        <b-dropdown-item>
                            <b-media class="media">
                                <template #aside>
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-title rounded-circle">OG</span>
                                    </div>
                                </template>
                                <h5 class="usr-name">Oscar Garner</h5>
                                <p class="msg-title">ACCOUNT UPDATE</p>
                            </b-media>
                        </b-dropdown-item>
                    </b-dropdown>

                    <b-dropdown v-show="false" toggle-tag="a" variant="icon-only" toggle-class="nav-link" menu-class="notification-scroll" class="nav-item notification-dropdown" :right="true">
                        <template #button-content>
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
                                class="feather feather-bell"
                            >
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span v-if="NOTIFICATION_COUNT" class="badge badge-danger">{{NOTIFICATION_COUNT}}</span>
                        </template>

                        <b-dropdown-text class="notification-title">
                            <h6>Notifications</h6>
                        </b-dropdown-text>

                        <b-dropdown-text v-if="NOTIFICATIONS.length == 0">
                            No notification yet
                        </b-dropdown-text>

                        <b-dropdown-item v-for="(value, index) in NOTIFICATIONS" :key="index" class="notification-item" :class="value.status" @click="setNotificationRead(value.id, value.link, value.status)">
                            <b-media>
                                <template #aside>
                                    <!-- info -->
                                    <svg v-if="value.text_color == 'info'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    <!-- success -->
                                    <svg v-else-if="value.text_color == 'success'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1abc9c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    <!-- warning -->
                                    <svg v-else-if="value.text_color == 'warning'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e2a03f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                    <!-- error -->
                                    <svg v-else-if="value.text_color == 'error'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    <!-- primary -->
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#27529C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                </template>
                                <div class="data-info w-100">
                                    <h6 class="">{{value.title}}</h6>
                                    <p class="">{{value.message}}</p>
                                    <small class="text-right text-default">
                                        {{moment(value.datetime).fromNow()}}
                                    </small>
                                </div>
                            </b-media>
                        </b-dropdown-item>
                        <b-dropdown-item-button v-if="NOTIFICATION_COUNT > NOTIFICATIONS.length" class="text-center" @click.native.capture.stop="loadMoreNotifications()">
                            Load more...
                        </b-dropdown-item-button>
                    </b-dropdown>

                    <b-dropdown toggle-tag="a" variant="icon-only" toggle-class="user nav-link" class="nav-item user-profile-dropdown" :right="true">
                        <template #button-content>
                            <img :src="require('../../assets/images/avatar-place-holder.jpg').default" alt="avatar" />
                        </template>

                        <b-dropdown-item to="/users/profile" v-show="true">
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
                                class="feather feather-user"
                            >
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profile
                        </b-dropdown-item>
                        <b-dropdown-divider v-show="false"></b-dropdown-divider>
                        <b-dropdown-item href="javascript:void(0)" @click="logout">
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
                                class="feather feather-log-out"
                            >
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Sign Out
                        </b-dropdown-item>
                    </b-dropdown>
                </div>
            </header>
        </div>
        <!--  END NAVBAR  -->
        <!--  BEGIN NAVBAR  -->
        <div class="sub-header-container">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom" @click="$store.commit('toggleSideBar', !$store.state.is_show_sidebar)">
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
                        class="feather feather-menu"
                    >
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>

                <!-- Portal vue for Breadcrumb -->
                <portal-target name="breadcrumb"> </portal-target>
            </header>
        </div>
        <!--  END NAVBAR  -->
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    import axios from 'axios';
    import moment from "moment";

    import '../../assets/sass/layout/header.scss';

    export default {
        data() {
            return {
                //env
                MIX_COMPANY_ACR: process.env.MIX_COMPANY_ACR,
                MIX_PROJECT_NAME: process.env.MIX_PROJECT_NAME,
                //fields
                selectedLang: null,
                countryList: this.$store.state.countryList,
                user: this.$store.state.auth.user,
                //notifications
                NOTIF_OFFSET: 0,
                NOTIF_LIMIT: 10,
                NOTIFICATIONS: [],
                NOTIFICATION_COUNT: 0,
                //global setup
                USERTYPE : this.$store.state.auth.user.user_type_code,
            };
        },
        created() {
            Echo.private('notification.created')
                .listen('NotificationCreated', (e) => {
                    if(e.notification['send_to_user_id'] == this.$store.state.auth.user.id){
                        let options = {}

                        options['id']               = e.notification['id']
                        options['title']            = e.notification['title']
                        options['message']          = e.notification['message']
                        options['text_color']       = e.notification['text_color']
                        options['link']             = e.notification['link']
                        options['status']           = e.notification['status']
                        options['datetime']         = e.notification['created_at']

                        this.NOTIFICATIONS = [options, ...this.NOTIFICATIONS];
                        this.NOTIFICATION_COUNT++;
                    }
                });

            this.getNotificationByUser();
        },
        mounted() {
            this.selectedLang = this.$appSetting.toggleLanguage();

            this.toggleMode();
        },
        methods: {
            getNotificationByUser(){
                let self = this
                let formData = new FormData()

                formData.append("offset", self.NOTIF_OFFSET);
                formData.append("limit", self.NOTIF_LIMIT);

                this.axios.post('/api/notification/get-by-user', formData)
                .then(function (response) {
                    self.NOTIFICATION_COUNT = response.data.count;

                    response.data.result.forEach((value, index) => {
                        let options = {}

                        options['id']               = value['id']
                        options['title']            = value['title']
                        options['message']          = value['message']
                        options['text_color']       = value['text_color']
                        options['link']             = value['link']
                        options['status']           = value['status']
                        options['datetime']         = value['created_at']
                        self.NOTIFICATIONS.push(options)
                    })

                })
                .catch(function (error) {
                    console.error(error.response);
                })
            },

            setNotificationRead(notificationId, link, status){
                if(status == 'read'){
                    this.$router.push(link);
                }else{
                    this.NOTIFICATION_COUNT--;
                }

                let self = this
                let formData = new FormData()

                formData.append("id", notificationId);

                this.axios.post('/api/notification/set-as-read', formData)
                .then(function (response) {

                    self.$router.push(link)
                })
                .catch(function (error) {
                    console.error(error.response);
                })
            },

            loadMoreNotifications(){
                this.NOTIF_OFFSET += 10;
                this.getNotificationByUser();
            },

            toggleMode(mode) {
                this.$appSetting.toggleMode(mode);
            },

            changeLanguage(item) {
                this.selectedLang = item;
                this.$appSetting.toggleLanguage(item);
            },

            ...mapActions({
                signOut:"auth/logout"
            }),

            async logout(){
                await axios.post('/api/logout').then(({data})=>{
                    this.signOut()
                    this.$router.push({name:"login"})
                })
            }
        }
    };
</script>
