<template>
  <div id="login">
    <v-layout class="loginWrap">
      <v-flex class="loginContainer sm4">
        <h2>Login</h2>
        <form>
          <v-flex>
            <v-text-field
              v-model="user.email"
              :error-messages="emailErrors"
              label="Email"
              required
            ></v-text-field>
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="user.password"
              type="password"
              :error-messages="passwordErrors"
              label="Password"
              required
            ></v-text-field>
          </v-flex>
          <v-btn @click="submit" color="primary">submit</v-btn>
          <v-btn @click="clear">clear</v-btn>
        </form>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
/* global store, router */
const axios = require('axios');
export default {
  data: () => ({
    user: {
      email: '',
      password: ''
    },
    emailErrors: '',
    passwordErrors: '',
    select: null,
    items: [
      'Item 1',
      'Item 2',
      'Item 3',
      'Item 4'
    ],
    checkbox: false
    }),
    methods: {
      submit () {
        axios.post('/auth/login', this.user)
          .then(function (response) {
            // handle success
            console.log(response);
            if (response.error) {
              alert('Error: ' + response.error);
            } else {
              store.commit('setSession', response.data);
              router.push({ name: 'dashboard' });
            }
          })
          .catch(function (error) {
            // handle error
            alert('Error: ' + error);
            console.log(error);
          });
      },
      clear () {
        this.user = {
          password: '',
          password: '',
        };
      }
    }
}
</script>

<style scoped>

  .loginWrap {
    justify-content: center;
  }
  .loginContainer {
    padding: 15px;
    border: 1px solid #ccc;
    margin-top: 50px;
  }

</style>