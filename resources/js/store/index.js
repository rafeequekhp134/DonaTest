import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    session: {},
    user: {},
    tree: {},
  },
  mutations: {
    setUser (state, user) {
      state.user = user
    },
    setSession (state, session) {
      state.session = session
    },
    setTree (state, tree) {
      state.tree = tree
    },
  }
})

export default store;