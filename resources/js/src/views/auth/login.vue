<template>
    <div class="form auth-boxed">
        <div class="form-container outer">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content">
                            <img :src="require('../../assets/images/logo-main-no-bg.png').default" class="navbar-logo" alt="logo" />

                            <h1 class="">Sign In</h1>
                            <p class="">Log in to your <span class="text-dark text-bold">{{MIX_COMPANY_ACR}} {{MIX_PROJECT_NAME}}</span> account to continue.</p>

                            <b-form class="text-left" @submit.stop.prevent>
                                <div class="form">

                                    <div id="username-field" class="field-wrapper input">
                                        <label for="username">USERNAME</label>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <b-input v-model="auth.email"
                                            name="email"
                                            id="email"
                                            placeholder="Email"
                                            :class="[credentialsSubmitted ? (validCredentials ? 'is-valid' : 'is-invalid') : '']"
                                        ></b-input>
                                    </div>

                                    <div id="password-field" class="field-wrapper input mb-2">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">PASSWORD</label>
                                            <router-link to="/forgot-password" class="forgot-pass-link">Forgot Password?</router-link>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        <b-input :type="passwordFieldType"
                                            v-model="auth.password"
                                            name="password"
                                            id="password"
                                            placeholder="Password"
                                            :class="[credentialsSubmitted ? (validCredentials ? 'is-valid' : 'is-invalid') : '']"
                                        ></b-input>
                                        <svg @click="showPassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>

                                        <b-form-invalid-feedback :class="{'d-block' : credentialsSubmitted && !validCredentials}">Invalid Email or Password</b-form-invalid-feedback>
                                    </div>
                                    <div class="d-sm-flex justify-content-between">
                                        <div class="field-wrapper">
                                            <b-button type="submit" :disabled="processing" @click="login" variant="primary">{{ processing ? "Please wait" : "Log In" }}</b-button>
                                        </div>
                                    </div>

                                    <div class="division">
                                        <span>OR</span>
                                    </div>

                                    <div class="social">
                                        <a href="javascript:void(0);" @click="extLogin('facebook')" class="btn social-fb">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                            <span class="brand-name">Facebook</span>
                                        </a>
                                        <a href="javascript:void(0);" @click="extLogin('google')" class="btn social-github">
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#EA4335 " d="M5.26620003,9.76452941 C6.19878754,6.93863203 8.85444915,4.90909091 12,4.90909091 C13.6909091,4.90909091 15.2181818,5.50909091 16.4181818,6.49090909 L19.9090909,3 C17.7818182,1.14545455 15.0545455,0 12,0 C7.27006974,0 3.1977497,2.69829785 1.23999023,6.65002441 L5.26620003,9.76452941 Z"/><path fill="#34A853" d="M16.0407269,18.0125889 C14.9509167,18.7163016 13.5660892,19.0909091 12,19.0909091 C8.86648613,19.0909091 6.21911939,17.076871 5.27698177,14.2678769 L1.23746264,17.3349879 C3.19279051,21.2936293 7.26500293,24 12,24 C14.9328362,24 17.7353462,22.9573905 19.834192,20.9995801 L16.0407269,18.0125889 Z"/><path fill="#4A90E2" d="M19.834192,20.9995801 C22.0291676,18.9520994 23.4545455,15.903663 23.4545455,12 C23.4545455,11.2909091 23.3454545,10.5272727 23.1818182,9.81818182 L12,9.81818182 L12,14.4545455 L18.4363636,14.4545455 C18.1187732,16.013626 17.2662994,17.2212117 16.0407269,18.0125889 L19.834192,20.9995801 Z"/><path fill="#FBBC05" d="M5.27698177,14.2678769 C5.03832634,13.556323 4.90909091,12.7937589 4.90909091,12 C4.90909091,11.2182781 5.03443647,10.4668121 5.26620003,9.76452941 L1.23999023,6.65002441 C0.43658717,8.26043162 0,10.0753848 0,12 C0,13.9195484 0.444780743,15.7301709 1.23746264,17.3349879 L5.27698177,14.2678769 Z"/></svg>
                                            <span class="brand-name">Google</span>
                                        </a>
                                    </div>

                                    <p class="signup-link">Not registered ? <router-link to="/register">Create an account</router-link></p>

                                </div>
                            </b-form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
    import axios from 'axios'

    import '../../assets/sass/authentication/auth-boxed.scss';
    import '../../assets/sass/components/custom-sweetalert.scss';
    export default {
        metaInfo: { title: 'Login' },
        name:"login",
        data() {
            return {
                //env
                MIX_COMPANY_ACR: process.env.MIX_COMPANY_ACR,
                MIX_PROJECT_NAME: process.env.MIX_PROJECT_NAME,
                MIX_PROJECT_NAME_LONG: process.env.MIX_PROJECT_NAME_LONG,
                //fields
                auth:{
                    email:"",
                    password:""
                },
                processing:false,
                passwordFieldType: "password",
                credentialsSubmitted: false,
                validCredentials: true,
            }
        },
        mounted() {
        },
        methods: {
            ...mapActions({
                signIn:'auth/login'
            }),
            async login(){
                this.processing = true
                this.credentialsSubmitted = true

                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/login',this.auth).then(({data})=>{
                    this.signIn(data)

                    const toast = this.$swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, padding: '2em'});
                    toast.fire({icon: 'success',title: "Signed in successfully",padding: '2em'});
                    this.validCredentials = true
                }).catch(({response:{data}})=>{
                    this.validCredentials = false
                }).finally(()=>{
                    this.processing = false
                })
            },
            showPassword() {
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            async extLogin(ref){
                await axios.get('/api/' + ref + '/redirect').then(({data})=>{
                     window.location.href = data;
                })
            }
        }
    };
</script>
