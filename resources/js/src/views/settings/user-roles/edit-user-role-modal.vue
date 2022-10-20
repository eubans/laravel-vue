<template>
    <div class="create-admin-modal-container">
        <b-modal id="edit-user-modal" modal-class="modal-notification" footer-class="justify-content-between" :title="pageTitle + ' User'" size="xl">
            <b-form class="needs-validation" novalidate @submit.stop.prevent="submit_form" ref="editUserModalForm">
                <b-form-row>

                    <div class="col-md-12 mb-2"><h6 class="text-primary">User Account Details</h6></div>

                    <div class="col-md-6 mb-2">
                        <label for="usernameField">Username</label>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"/></svg>
                                </b-input-group-text>
                            </b-input-group-prepend>
                            <b-input id="usernameField" v-model="form.username" type="email" :class="[isFormSubmit ? (form.username ? 'is-valid' : 'is-invalid') : '']" placeholder="Username" :readonly="readonly.username"></b-input>
                        </b-input-group>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.username}">Please fill the username</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="usernameField">Password</label>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                </b-input-group-text>
                            </b-input-group-prepend>
                            
                            <b-input 
                                id="password" 
                                v-model="form.password" 
                                placeholder="Password" 
                                :type="passwordFieldType"  
                                :readonly="readonly.password"
                                :class="[isFormSubmit ? (form.password ? 'is-valid' : 'is-invalid') : '']"
                            ></b-input>
                            <b-input-group-append>
                                <b-button variant="dark" @click="showPassword()">
                                    <svg v-if="passwordFieldType == 'password'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg v-if="passwordFieldType == 'text'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                </b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.password}">Please fill the password</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="userTypeField">User Type</label>
                        <multiselect 
                            v-model="form.user_type" 
                            :options="userTypeOptions" 
                            :searchable="true" 
                            placeholder="Choose..." 
                            selected-label="" 
                            select-label="" 
                            deselect-label=""
                            id="userTypeField"
                            :class="[isFormSubmit ? form.user_type ? 'is-valid' : 'is-invalid' : '']"
                            track-by="id"
                            label="name"
                        ></multiselect>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.user_type}">Please Select user type</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="userTypeField">User Role</label>
                        <multiselect 
                            v-model="form.user_role" 
                            :multiple="true"
                            :options="userRoleOptions" 
                            :searchable="true" 
                            placeholder="Choose..." 
                            selected-label="" 
                            select-label="" 
                            deselect-label=""
                            id="userTypeField"
                            :class="[isFormSubmit ? form.user_role ? 'is-valid' : 'is-invalid' : '']"
                            track-by="id"
                            label="name"
                        ></multiselect>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.user_role}">Please Select user roles</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="userTypeField">Status</label>
                        <multiselect 
                            v-model="form.status" 
                            :options="userStatusOptions" 
                            :searchable="true" 
                            placeholder="Choose..." 
                            selected-label="" 
                            select-label="" 
                            deselect-label=""
                            id="userTypeField"
                            :class="[isFormSubmit ? form.status ? 'is-valid' : 'is-invalid' : '']"
                            track-by="name"
                            label="name"
                        ></multiselect>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.status}">Please Select status</b-form-invalid-feedback>
                    </div>

                    <div class="col-md-12 mt-3 mb-2"><h6 class="text-primary">Personal Details</h6></div>

                    <div class="col-md-4 mb-2">
                        <label for="firstnameField">First name</label>
                        <b-input id="firstnameField" v-model="form.firstname" :class="[isFormSubmit ? (form.firstname ? 'is-valid' : 'is-invalid') : '']" placeholder="First name"></b-input>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.firstname}">Please fill the first name</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="midddlenameField">Middle name</label>
                        <b-input id="midddlenameField" v-model="form.middlename" placeholder="Middle name"></b-input>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="lastnameField">Last name</label>
                        <b-input id="lastnameField" v-model="form.lastname" :class="[isFormSubmit ? (form.lastname ? 'is-valid' : 'is-invalid') : '']" placeholder="Last name"></b-input>
                        <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.lastname}">Please fill the last name</b-form-invalid-feedback>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="emailField">Email</label>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"/></svg>
                                </b-input-group-text>
                            </b-input-group-prepend>
                            <b-input id="emailField" v-model="form.email" type="email" :class="[isFormSubmit ? (form.email ? 'is-valid' : 'is-invalid') : '']" placeholder="Email Address"></b-input>
                            <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.email}">Please fill the email</b-form-invalid-feedback>
                        </b-input-group>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="mobileField">Mobile</label>
                        <b-input-group>
                            <b-input-group-prepend>
                                <b-input-group-text>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hash"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg>
                                </b-input-group-text>
                            </b-input-group-prepend>
                            <b-input id="mobileField" v-model="form.mobile" :class="[isFormSubmit ? (form.mobile ? 'is-valid' : 'is-invalid') : '']" placeholder="Mobile Number"></b-input>
                            <b-form-invalid-feedback :class="{'d-block' : isFormSubmit && !form.mobile}">Please fill the mobile</b-form-invalid-feedback>
                        </b-input-group>
                    </div>
                </b-form-row>
            </b-form>
            
            <template #modal-footer>
                <b-button variant="default" data-dismiss="modal" @click="$bvModal.hide('edit-user-modal')"><i class="flaticon-cancel-12"></i> Discard</b-button>
                <b-button variant="primary" @click="submitForm()">Save</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import feather from 'feather-icons';
    import highlight from '../../../components/plugins/highlight.vue';
    import Multiselect from 'vue-multiselect'
    
    import '../../../assets/sass/settings/users.scss';
    import 'vue-multiselect/dist/vue-multiselect.min.css';

    export default {
        components: {
            highlight,
            Multiselect
        },
        props: ['userId'],
        data() {
            return {
                pageTitle: 'Edit',
                editUserId: 0,
                form: {
                    user_type: {},
                    user_role: [],
                    username: '',
                    password: '',
                    firstname: '',
                    middlename: null,
                    lastname: '',
                    email: '',
                    mobile: '',
                    status: {},
                },
                readonly: {
                    username: false,
                    password: false,
                },
                isFormSubmit: false,
                passwordFieldType: 'password',
                // Options
                userTypeOptions: [],
                userRoleOptions: [],
                userStatusOptions: [],
            };
        },
        watch: {
            userId: {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    if(newValue && newValue != oldValue){
                        this.pageTitle = 'Edit';

                        this.editUserId = newValue;
                        this.getUserDetails(newValue);
                    }else if(!newValue){
                        this.pageTitle = 'Create';

                        this.onReset();
                    }
                }
            },
        },
        mounted() {
            // initial functions
            this.getUserType();
            this.getUserRole();
            this.getUserStatus();
            this.onReset();
        },
        methods: {
            getUserDetails(id){
                let loader = this.$loading.show({container: this.$refs.editUserModalForm})

                let self = this
                this.axios.get('/api/settings/users/'+id).then(function(response){
                    let f = self.form;
                    let data = response.data;

                    if(data){
                        f.user_type     = {
                            id:     data.user_type_id,
                            name:   data.user_type,
                        };
                        f.user_role     = data.user_roles;
                        f.username      = data.username;
                        f.password      = "************";
                        f.firstname     = data.firstname;
                        f.middlename    = data.middlename;
                        f.lastname      = data.lastname;
                        f.email         = data.email;
                        f.mobile        = data.mobile;
                        f.status        = {
                            id:     data.status,
                            name:   self.$helpers.capFirstLetter(data.status),
                        };
                    }

                    self.readonly.username = true;
                    self.readonly.password = true;

                    loader.hide();
                }).catch(error=>{
                    console.log("Get All: "+error);
                    loader.hide();
                })
            },
            getUserType(){
                let self = this
                this.axios.get('/api/settings/user-types').then(function(response){
                    self.userTypeOptions = []
                    response.data.forEach((value, index) => {
                        let options = {}

                        options['id']       = value['id']
                        options['name']     = value['name']
                        self.userTypeOptions.push(options)
                    })
                }).catch(error=>{
                    console.log("Get All: "+error);
                })
            },
            getUserRole(){
                let self = this
                this.axios.get('/api/settings/user-roles').then(function(response){
                    self.userRoleOptions = []
                    response.data.forEach((value, index) => {
                        let options = {}

                        options['id']       = value['id']
                        options['name']     = value['name']
                        self.userRoleOptions.push(options)
                    })
                }).catch(error=>{
                    console.log("Get All: "+error);
                })
            },
            getUserStatus(){
                let self = this
                this.axios.get('/api/settings/user-active-status').then(function(response){
                    self.userStatusOptions = []
                    response.data.forEach((value, index) => {
                        let options = {}

                        options['id']       = value['name']
                        options['name']     = self.$helpers.capFirstLetter(value['name'])
                        self.userStatusOptions.push(options)
                    })
                }).catch(error=>{
                    console.log("Get All: "+error);
                })
            },
            submitForm(){
                if(this.editUserId){
                    this.submitEditForm();
                }else{
                    this.submitCreateForm();
                }
            },
            submitEditForm() {
                //validation
                this.isFormSubmit = true
                if (!this.form.user_type || !this.form.user_role || !this.form.firstname || !this.form.lastname || !this.form.email || !this.form.mobile || !this.form.status.id)
                    return false;
                
                // declaration
                const toast = this.$swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, padding: '2em'});
                let loader = this.$loading.show({container: this.$refs.editUserModalForm})
                let self = this
                let formData = new FormData()

                formData.append("user_id", self.editUserId)
                formData.append("user_type", self.form.user_type.id)
                formData.append("user_role", JSON.stringify(self.form.user_role))
                formData.append("firstname", self.form.firstname)
                formData.append("middlename", self.form.middlename)
                formData.append("lastname", self.form.lastname)
                formData.append("email", self.form.email)
                formData.append("mobile", self.form.mobile)
                formData.append("status", self.form.status.id)

                //post call
                this.axios.post('/api/settings/users/update', formData)
                .then(function (response) {
                    loader.hide();
                    
                    if(response.data.status == "Success"){
                        self.$bvModal.hide('edit-user-modal')
                        self.onReset()
                        self.$emit('submit-success', true)

                        toast.fire({icon: 'success',title: response.data.message ,padding: '2em'});
                    }else{
                        toast.fire({icon: 'error',title: response.data.message ,padding: '2em'});
                    }
                    
                    self.isFormSubmit = false
                })
                .catch(function (error) {
                    loader.hide()
                    if(error.response.data.message === undefined){
                        toast.fire({icon: 'error',title: "An error occured, please contact the administrator." ,padding: '2em'});
                    }else{
                        toast.fire({icon: 'error',title: error.response.data.message ,padding: '2em'});
                    }
                })
            },
            submitCreateForm() {
                //validation
                this.isFormSubmit = true
                if (!this.form.username || !this.form.password || !this.form.user_type || !this.form.user_role || !this.form.firstname || !this.form.lastname || !this.form.email || !this.form.mobile || !this.form.status.id)
                    return false;
                
                // declaration
                const toast = this.$swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, padding: '2em'});
                let loader = this.$loading.show({container: this.$refs.editUserModalForm})
                let self = this
                let formData = new FormData()

                formData.append("username", self.form.username)
                formData.append("password", self.form.password)
                formData.append("user_type", self.form.user_type.id)
                formData.append("user_role", JSON.stringify(self.form.user_role))
                formData.append("firstname", self.form.firstname)
                formData.append("middlename", self.form.middlename)
                formData.append("lastname", self.form.lastname)
                formData.append("email", self.form.email)
                formData.append("mobile", self.form.mobile)
                formData.append("status", self.form.status.id)

                //post call
                this.axios.post('/api/settings/users/save', formData)
                .then(function (response) {
                    loader.hide();
                    
                    if(response.data.status == "Success"){
                        self.$bvModal.hide('edit-user-modal')
                        self.onReset()
                        self.$emit('submit-success', true)

                        toast.fire({icon: 'success',title: response.data.message ,padding: '2em'});
                    }else{
                        toast.fire({icon: 'error',title: response.data.message ,padding: '2em'});
                    }
                    
                    self.isFormSubmit = false
                })
                .catch(function (error) {
                    loader.hide()
                    if(error.response.data.message === undefined){
                        toast.fire({icon: 'error',title: "An error occured, please contact the administrator." ,padding: '2em'});
                    }else{
                        toast.fire({icon: 'error',title: error.response.data.message ,padding: '2em'});
                    }
                })
            },
            onReset() {
                // Reset form values
                this.form.username      = ''
                this.form.password      = ''
                this.form.user_type     = {}
                this.form.user_role     = []
                this.form.firstname     = ''
                this.form.middlename    = ''
                this.form.lastname      = ''
                this.form.email         = ''
                this.form.mobile        = ''
                this.form.status        = {}
                
                this.readonly.username = false;
                this.readonly.password = false;
            },
            showPassword() {
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            }
        }
    };
</script>
