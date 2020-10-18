<template>
  <v-toolbar dark color="primary">
    <v-toolbar-side-icon></v-toolbar-side-icon>

    <v-toolbar-title class="white--text">TreeView</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-flex>
      <v-btn flat :to="{ name: store.state.session.access_token ? 'dashboard' : 'home' }">Home</v-btn>
    </v-flex>

    <v-btn v-if="!store.state.session.access_token" flat :to="{ name: 'register' }">
      Register
    </v-btn>
    <v-spacer v-if="!store.state.session.access_token"></v-spacer>
    <v-btn flat v-if="!store.state.session.access_token" :to="{ name: 'login' }">
      Login
    </v-btn>

    <v-btn icon @click="logout">
      <v-icon>power_settings_new</v-icon>
    </v-btn>

  </v-toolbar>
</template>

<script>
/* global store, router */
export default {
  name: 'toolbar',
  data: () => ({
    store: store
  }),
  methods: {
    logout () {
      if (store.state.session) {
        axios.post('/auth/logout', {}, {
          headers: {
            'Authorization': `Bearer ${store.state.session.access_token}` 
          }})
          .then(function (response) {
            // handle success
            if (response.status === 200) {
              alert('Logged out');
              store.commit('setSession', {});
              store.commit('setUser', {});
              store.commit('setDocuments', []);
              router.push({name: 'login'});
            }
            console.log(response);
          })
          .catch(function (error) {
            // handle error
            store.commit('setSession', {});
            store.commit('setUser', {});
            store.commit('setDocuments', []);
            router.push({name: 'login'});
            console.log(error);
          })
          .then(function () {
            // always executed
          });
      }
    }
  }
};
</script>

<style scoped>

</style>