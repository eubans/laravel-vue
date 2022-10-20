import axios from 'axios'
import router from '../router'

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        modules:{},
        // user_type:{},
        token:null
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        },
        // user_type(state){
        //     return state.user_type
        // },
        modules(state){
            return state.modules
        },
        token(state){
            return state.token
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
        SET_TOKEN (state, token) {
            state.token = token
        },
        // SET_USER_TYPE (state, value) {
        //     state.user_type = value
        // },
        SET_MODULES(state,value){
            state.modules = value
        }
    },
    actions:{
        login({commit}, data){
            commit('SET_USER',data.user)
            commit('SET_TOKEN',data.token)
            commit('SET_AUTHENTICATED',true)
            // commit('SET_USER_TYPE',data.user_type)
            commit('SET_MODULES',data.modules)
            router.push('/')
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_TOKEN',{})
            axios.defaults.headers.common['Authorization'] = null
            commit('SET_AUTHENTICATED',false)
        },
        updateUserDetails({commit}, data){
            commit('SET_USER',data)
        },
    }
}
