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
      count: 0
    }
  },
  mutations: {
    increment  (state) {
      state.count++
    }
  }
})

export default store;
