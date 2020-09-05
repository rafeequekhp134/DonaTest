<template>
    <div>
        <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'welcome' }" class="nav-link">Home</router-link>
                    <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                </ul>
            </div>
        </nav> -->
        <toolbar class="app--toolbar"></toolbar>
        <v-app>
          <v-content>
            <main>
                <router-view></router-view>
            </main>
          </v-content>
        </v-app>
    </div>
</template>
<script>
  import Toolbar from './shared/toolbar'
  export default {
    data () {
      return {}
    },
    components: { Toolbar }
  }
</script>