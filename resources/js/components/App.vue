<template>
    <div>
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