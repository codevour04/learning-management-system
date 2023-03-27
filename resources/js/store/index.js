import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      user: {
        name: "",
        email: "",
        permissions: []
      },
      drawToggle: false
    }
  },

  getters: {
    user (state) {
      return state.user
    }
  },

  mutations: {
    setDrawToggle (state) {
      state.drawToggle = !state.drawToggle
    },

    setUser (state, value) {
      state.user = value;
    }
  }
})

export default store;
