import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    session: {},
    user: {},
    documents: [],
  },
  mutations: {
    setUser (state, user) {
      state.user = user
    },
    setSession (state, session) {
      state.session = session
    },
    setDocuments (state, documents) {
      state.documents = documents
    },
  }
})

export default store;