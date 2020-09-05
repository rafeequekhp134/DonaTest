<template>
  <div id="dashboard">
    <v-layout class="dashboardWrap">
      <v-flex>
        <upload-btn title="Upload" class="mt-3" small @file-update="fileSelected($event)"></upload-btn>
      </v-flex>
    </v-layout>
    <v-layout class="filesWrapper">
      <v-flex class="sm8 mt-5">
        <v-card>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Type query and hit enter"
            class="searchFiles"
            hint="Hit enter to search"
            id="fileSearch"
            @keyup.enter="searchFiles($event)" 
            single-line
            hide-details
          ></v-text-field>
          <v-data-table
            :headers="headers"
            :items="documents"
            :pagination.sync="pagination"
            no-data-text="No files exist, please upload"
          >
            <template v-slot:items="props">
              <tr>
                <td>{{ props.index + 1 }}</td>
                <td>{{ props.item }}</td>
                <td>
                  <v-btn icon title="Delete" @click="deleteDoc(props.item)">
                    <v-icon color="red">delete</v-icon>
                  </v-btn>
                </td>
              </tr>
            </template>
          </v-data-table>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
/* global store router */
import UploadButton from 'vuetify-upload-button';
// const axios = require('axios');
export default {
  data: () => ({
    documents: [],
    pagination: {
      rowsPerPage: 10
    },
    headers: [
      { text: '#', value: '', align: 'left' },
      { text: 'File path', value: '' },
      { text: '', sortable: false },
    ],
    search: ''
    }),
    components: {
      'upload-btn': UploadButton
    },
    created () {
      this.getUser();
      this.getDocuments();
    },
    beforeRouteEnter (to, from, next) {
      if (typeof store.state.session.access_token === 'undefined') {
        router.push({ name: 'login' });
      } else {
        next();
      }
    },
    methods: {
      getUser () {
        let _this = this;
        axios.get('/auth/me', {
          headers: {
            'Authorization': `Bearer ${store.state.session.access_token}` 
          }})
          .then(function (response) {
          // handle success
          if (response.status === 200) {
            store.commit('setUser', response.data);
          }
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
      },
      getDocuments () {
        let _this = this;
        axios.get('/documents_dir', {
          headers: {
            'Authorization': `Bearer ${store.state.session.access_token}` 
          }})
          .then(function (response) {
          // handle success
          if (response.data.success) {
            _this.documents = response.data.data;
            store.commit('setDocuments', response.data.data);
          }
          console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
      },
      searchFiles (e) {
        let query = e.target.value ? e.target.value : document.querySelector('input[id="fileSearch"]').value;
        let allDocs = JSON.parse(JSON.stringify(store.state.documents));
        // let regex = new RegExp("/" + query + "/", "gi")
        this.documents = allDocs.filter(x => {
          return x.indexOf(query) > -1;
        })
      },
      async fileSelected (file) {
        let _this = this;
        if (file !== 'undefined') {
          this.fileName = file.name;
          if (this.fileName.lastIndexOf('.') <= 0) {
            return;
          }
          const fr = new FileReader();
          fr.readAsDataURL(file);
          fr.addEventListener('load', async () => {
            let filePath = fr.result;
            let uploadUrl = '/store-file';
            let formData = new FormData();
            formData.append('file', file);
            formData.append('user_id', store.state.user.id);
            axios.post(uploadUrl, formData, {
              headers: {
                'Authorization': `Bearer ${store.state.session.access_token}` 
              }})
              .then(function (response) {
                // handle success
                if (response.data.success) {
                  alert('File was uploaded successfully');
                  _this.getDocuments();
                } else {
                  alert('Failed to upload, please try again');
                }
                console.log(response);
              })
              .catch(function (error) {
                alert('Failed: Please upload only txt, doc, docx, pdf, png, jpeg, jpg, gif file with less than 2MB size');
                console.log(error);
              });
          });
        }
      },
      deleteDoc (path) {
        console.log('path', path);
        let _this = this;
        if (path && confirm('Are you sure ?')) {
          axios.post('/document_delete', { path: path }, {
            headers: {
              'Authorization': `Bearer ${store.state.session.access_token}` 
            }})
            .then(function (response) {
              // handle success
              if (response.data.success) {
                alert('Photo deleted!');
                _this.getDocuments();
              }
              console.log(response);
            })
            .catch(function (error) {
              // handle error
              alert('Error: ' + error);
              _this.getDocuments();
              console.log(error);
            })
        }
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
  .filesWrapper {
    justify-content: center;
  }
  .searchFiles {
    width: 50%;
    margin: 0 5px;
    float: right;
  }
  .upload-btn {
    display: flex;
    justify-content: flex-end;
  }
</style>