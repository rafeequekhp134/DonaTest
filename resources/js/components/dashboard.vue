<template>
  <div id="dashboard">
    <v-layout class="treeWrap">
      <button class="button" @click="addNode">Add Root Folder</button>
      <vue-tree-list
        @click="onClick"
        @change-name="onChangeName"
        @delete-node="onDel"
        @add-node="onAddNode"
        :model="data"
        default-tree-node-name="New Folder"
        default-leaf-node-name="New File"
        v-bind:default-expanded="true"
      >
        <template v-slot:leafNameDisplay="slotProps">
          <span>
            {{ slotProps.model.name }} </span>
        </template>
        <span class="icon" slot="addTreeNodeIcon" title="Add folder">📂</span>
        <span class="icon" slot="addLeafNodeIcon" title="Add file">＋</span>
        <span class="icon" slot="editNodeIcon" title="Edit name">📃</span>
        <span class="icon" slot="delNodeIcon" title="Delete">✂️</span>
        <!-- <span class="icon" slot="leafNodeIcon">🍃</span> -->
        <span class="icon" slot="leafNodeIcon">📃</span>
        <!-- <span class="icon" slot="treeNodeIcon">🌲</span> -->
        <span class="icon" slot="treeNodeIcon">📂</span>
      </vue-tree-list>
      <v-flex>
        <button class="button" @click="saveTree">Save Tree</button>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
/* global store router */
import { VueTreeList, Tree, TreeNode } from 'vue-tree-list'
export default {
  data: () => ({
    store: store,
    treeKey: 123,
    data: new Tree([
        {
          name: 'Folder 1',
          id: 1,
          pid: 0,
          children: [
            {
              name: 'File1.txt',
              id: 2,
              isLeaf: true,
              pid: 1
            },
            {
              name: 'Email.php',
              id: 3,
              isLeaf: true,
              pid: 1
            }
          ]
        },
        {
          name: 'Folder 2',
          id: 4,
          pid: 0,
          children: [
            {
              name: 'Folder 2.1',
              id: 6,
              pid: 1
            },
            {
              name: 'Send.java',
              id: 7,
              isLeaf: true,
              pid: 1
            }
          ]
        },
        {
          name: 'Folder 3',
          id: 5,
          pid: 0,
          children: [
            {
              name: 'Folder 4',
              id: 8,
              pid: 1
            }
          ]
        }
      ])
    }),
    components: {
      'vue-tree-list': VueTreeList
    },
    created () {
      this.getUser();
      this.getTree();
    },
    computed: {
      // 
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

      onDel(node) {
        node.remove()
      },
 
      onChangeName(params) {
        // console.log('tree', this.data);
        // console.log('params', params);
      },
 
      onAddNode(params) {
        console.log(params)
      },
 
      onClick(params) {
        console.log(params)
      },
 
      addNode() {
        var node = new TreeNode({ name: 'New Folder', isLeaf: false })
        if (!this.data.children) this.data.children = []
        this.data.addChildren(node)
      },
 
      getNewTree() {
        var vm = this
        function _dfs(oldNode) {
          var newNode = {}
 
          for (var k in oldNode) {
            if (k !== 'children' && k !== 'parent') {
              newNode[k] = oldNode[k]
            }
          }
 
          if (oldNode.children && oldNode.children.length > 0) {
            newNode.children = []
            for (var i = 0, len = oldNode.children.length; i < len; i++) {
              newNode.children.push(_dfs(oldNode.children[i]))
            }
          }
          return newNode
        }
 
        return _dfs(vm.data)
      },
      getTree () {
        let _this = this;
        axios.get('/tree', {
          headers: {
            'Authorization': `Bearer ${store.state.session.access_token}` 
          }})
          .then(function (response) {
          // handle success
          if (response.data.success && response.data.data && response.data.data.tree) {
            _this.data = new Tree([JSON.parse(response.data.data.tree)]);
            _this.treeKey = (new Date()).getTime();
            store.commit('setTree', JSON.parse(response.data.data.tree));
          }
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          _this.$forceUpdate();
          // always executed
        });
      },
      async saveTree (file) {
        let _this = this;
        let payload = {
          tree: JSON.stringify(_this.getNewTree()),
          user_id: store.state.user.id
        };
        axios.post('/tree', payload, {
          headers: {
            'Authorization': `Bearer ${store.state.session.access_token}` 
          }})
          .then(function (response) {
            // handle success
            if (response.data.success) {
              alert('Tree was updated successfully');
            } else {
              alert('Failed to update the tree, please try again');
            }
          })
          .catch(function (error) {
            alert('Failed: Something went wrong');
            console.log(error);
          });
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
  .treeWrap {
    display: flex;
    flex-direction: column;
    align-items: baseline;
    padding: 30px;
  }
  .button {
    padding: 10px 14px;
    background: #3c76d2;
    color: #fff;
    margin: 15px 0;
  }
  .vtl {
    width: 100%;
  }
</style>