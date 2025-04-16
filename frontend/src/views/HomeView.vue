<template>
  <nav class="navbar-container">
    <tr>
      <th style="background-color: yellow">
        <router-link to="/" style="text-decoration: none; color: black">List To Do</router-link>
      </th>
      <th>
        <router-link to="/create" style="text-decoration: none; color: black"
          >Add To Do</router-link
        >
      </th>
    </tr>
  </nav>

  <h1 class="title">Daftar List</h1>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama list</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(list, index) in lists" :key="list.id">
          <td>{{ index + 1 }}</td>
          <td>{{ list.list_name }}</td>
          <td>
            <button class="btn warning" @click="openEditPopup(list)">Edit</button>
            <button class="btn danger" @click="deleteList(list)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="overlay" v-if="showPopup">
    <div class="popup">
      <h2>Edit list</h2>
      <form @submit.prevent="updateList()">
        <div class="form-group">
          <label>Nama list baru:</label>
          <input v-model="newListName" type="text" placeholder="Masukkan nama list baru" required />
        </div>
        <div class="popup-buttons">
          <button type="submit" class="btn primary" style="margin-right: 5px">Edit</button>
          <button type="button" class="btn secondary" @click="closePopup">Tutup</button>
        </div>
      </form>
    </div>
  </div>

  <h1 class="title">Daftar Tugas</h1>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>List</th>
          <th>Tugas</th>
          <th>Prioritas</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(task, index) in tasks" :key="task.id">
          <td>{{ index + 1 }}</td>
          <td>{{ task.lists.list_name }}</td>
          <td>{{ task.task_name }}</td>
          <td>{{ task.priority }}</td>
          <td>{{ task.date }}</td>
          <td>{{ task.status }}</td>
          <td>
            <button class="btn success" v-if="task.status !== 'Selesai'" @click="updateTask(task)">
              Selesai
            </button>
            <button class="btn danger" @click="deleteTask(task)">Hapus</button>
            <button
              class="btn warning"
              v-if="task.status !== 'Belum selesai'"
              @click="downdateTask(task)"
            >
              Belum Selesai
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      showPopup: false,
      tasks: [],
      lists: [],
      newTask: {
        task_name: '',
        priority: '',
        date: '',
      },
      newListName: '',
      listToEdit: null,
    }
  },
  mounted() {
    this.getTask()
    this.getLists()
  },
  methods: {
    getLists() {
      axios.get(`http://127.0.0.1:8000/api/todolist/lists`).then((response) => {
        this.lists = response.data
      })
    },
    deleteList(list) {
      const confirmed = confirm('Konfirmasi hapus?')
      if (confirmed) {
        axios.delete(`http://127.0.0.1:8000/api/todolist/lists/${list.id}`).then(() => {
          this.getTask()
          this.getLists()
        })
      }
    },
    openEditPopup(list) {
      this.showPopup = true
      this.listToEdit = list
      this.newListName = list.list_name
    },
    closePopup() {
      this.showPopup = false
      this.newListName = ''
      this.listToEdit = null
    },
    updateList() {
      if (!this.newListName.trim()) return
      axios
        .patch(`http://127.0.0.1:8000/api/todolist/lists/${this.listToEdit.id}`, {
          list_name: this.newListName,
        })
        .then(() => {
          this.getLists()
          this.getTask()
          this.closePopup()
        })
        .catch((error) => {
          console.error('Gagal update list:', error)
        })
    },

    getTask() {
      axios.get(`http://127.0.0.1:8000/api/todolist`).then((response) => {
        this.tasks = response.data
      })
    },
    updateTask(task) {
      const confirmed = confirm('Konfirmasi selesai?')
      if (confirmed) {
        axios.patch(`http://127.0.0.1:8000/api/todolist/${task.id}`).then(() => {
          this.getTask()
        })
      }
    },
    downdateTask(task) {
      const confirmed = confirm('Konfirmasi belum?')
      if (confirmed) {
        axios.patch(`http://127.0.0.1:8000/api/todolist/${task.id}/downdate`).then(() => {
          this.getTask()
        })
      }
    },
    deleteTask(task) {
      const confirmed = confirm('Konfirmasi hapus?')
      if (confirmed) {
        axios.delete(`http://127.0.0.1:8000/api/todolist/${task.id}`).then(() => {
          this.getTask()
        })
      }
    },
  },
}
</script>

<style scoped>
.navbar-container {
  display: flex;
  justify-content: center;
  background-color: rgb(67, 164, 255);
  color: white;
  padding: 20px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 20px;
}

.navbar-container th {
  font-family: Arial, Helvetica, sans-serif;
}

.title {
  text-align: center;
  font-size: 2rem;
  margin-top: 20px;
  margin-bottom: 20px;
  color: #333;
}

.table-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

table {
  width: 90%;
  border-collapse: collapse;
  background-color: #f9f9f9;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th,
td {
  padding: 12px 15px;
  border: 1px solid #ddd;
  text-align: center;
}

th {
  background-color: #f0f0f0;
  font-weight: 600;
}

.btn {
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.2s ease-in-out;
}

.btn.primary {
  background-color: #3f51b5;
  color: white;
}

.btn.primary:hover {
  background-color: #2c3e9c;
}

.btn.secondary {
  background-color: #e0e0e0;
  color: #333;
}

.btn.secondary:hover {
  background-color: #d5d5d5;
}

.btn.success {
  background-color: #4caf50;
  color: white;
}

.btn.success:hover {
  background-color: #45a049;
}

.btn.danger {
  background-color: #f44336;
  color: white;
}

.btn.danger:hover {
  background-color: #e53935;
}

.btn.warning {
  background: yellow;
}

.btn.warning:hover {
  background: rgb(238, 238, 0);
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.popup {
  background: white;
  padding: 30px;
  border-radius: 12px;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

.form-group {
  display: flex;
  flex-direction: column;
  text-align: left;
  margin-bottom: 15px;
}

.form-group label {
  margin-bottom: 6px;
  font-weight: 500;
  color: #555;
}
</style>
