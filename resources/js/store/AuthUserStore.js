import { defineStore } from 'pinia'

export const useAuthUserStore = defineStore("AuthUserStore", {
  state: () => {
    return {
      user: {
        name: "jayson",
        permissions: ['yeah']
      }
    }
  }
})
