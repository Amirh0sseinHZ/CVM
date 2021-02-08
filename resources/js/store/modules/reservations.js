import axios from "@/services/axios";

export default {
    state: {
        activeReservation: localStorage.getItem('activeReservation') || ''
    },
    mutations: {
        set_reservation(state, reservation) {
            localStorage.setItem('activeReservation', reservation)
            state.activeReservation = reservation
        },
        unset_reservation(state, reservation) {
            localStorage.removeItem('activeReservation')
            state.activeReservation = ''
        }
    },
    actions: {
        async checkForActiveReservation({dispatch, commit}) {
            await axios.get("/api/v1/reservation").then(r => {
                window.setInterval(() => {
                    dispatch('retrieveReservation', r.data.code);
                }, 1000 * 60);
            }).catch(() => commit('unset_reservation'));
        },
        async retrieveReservation({commit}, code) {
            await axios.get("/api/v1/reservations/" + code).then(r => {
                commit('set_reservation', r.data.response);
            }).catch(() => commit('unset_reservation'));
        }
    },
    getters: {
        hasActiveReservation: state => !!state.activeReservation,
        getTheReservation: state => state.activeReservation
    }
}
