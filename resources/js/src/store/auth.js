import axios from 'axios'
import router from '../router'

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        token:null
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
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
        }
    },
    actions:{
        login({commit}, data){
            commit('SET_USER',data.user)
            commit('SET_TOKEN',data.token)
            commit('SET_AUTHENTICATED',true)
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