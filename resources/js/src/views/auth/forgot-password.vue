<template>
    <div class="form no-image-content auth-boxed">
        <div class="form-container outer">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content">
                            <img :src="require('../../assets/images/logo-main-no-bg.png').default" class="navbar-logo" alt="logo" />

                            <h1 class="">Password Recovery</h1>
                            <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
                            <b-form class="text-left">
                                <div class="form">

                                    <div id="email-field" class="field-wrapper input">
                                        <div class="d-flex justify-content-between">
                                            <label for="email">EMAIL</label>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                        <b-input 
                                            type="email" 
                                            name="email" 
                                            v-model="auth.email" 
                                            id="email" 
                                            placeholder="Enter your email"
                                            :class="[credentialsSubmitted ? (validCredentials ? 'is-valid' : 'is-invalid') : '']"
                                        ></b-input>

                                        <b-form-invalid-feedback :class="{'d-block' : error.email}">{{error.email}}</b-form-invalid-feedback>
                                    </div>

                                    <div class="d-sm-flex justify-content-between">
                                        <div class="field-wrapper">
                                            <b-button type="submit" :disabled="processing" @click="forgotPassword" variant="primary">{{ processing ? "Please wait" : "Reset" }}</b-button>
                                        </div>
                                    </div>

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
    export default {
        metaInfo: { title: 'Forgot Password' },
        data() {
            return { 
                //env
                MIX_COMPANY_ACR: process.env.MIX_COMPANY_ACR,
                MIX_PROJECT_NAME: process.env.MIX_PROJECT_NAME,
                MIX_PROJECT_NAME_LONG: process.env.MIX_PROJECT_NAME_LONG,
                //fields
                auth:{
                    email:"",
                },
                error:{
                    email: "",
                },
                processing:false,
                credentialsSubmitted: false,
                validCredentials: true,
            }
        },
        mounted() {
        },
        methods: {
            async forgotPassword(){
                this.processing = true
                this.credentialsSubmitted = true
                
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/forgot-password',this.auth).then(({data})=>{

                    return false;

                    const toast = this.$swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, padding: '2em'});
                    toast.fire({icon: 'success',title: "Signed up successfully",padding: '2em'});
                    this.validCredentials = true
                }).catch(({response:{data}})=>{
                    this.resetErrors();

                    const errors = data.errors;

                    for (var err in errors) {
                        if(errors[err][0] !== undefined){
                            this.error[err] = errors[err][0];
                        }
                    }

                    this.validCredentials = false
                }).finally(()=>{
                    this.processing = false
                })
            },
            resetErrors(){
                this.error = {
                    email: "",
                };
            }
        }
    };
</script>
