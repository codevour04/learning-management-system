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
  mutations: {
    setDrawToggle (state) {
      state.drawToggle = !state.drawToggle
    }
  }
})

export default store;
