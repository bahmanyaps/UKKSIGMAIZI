<template lang="">
  <nav class="navbar-container">
    <tr>
      <th>
        <router-link to="/" style="text-decoration: none; color: black">List To Do</router-link>
      </th>
      <th style="background-color: yellow">
        <router-link to="/create" style="text-decoration: none; color: black"
          >Add To Do</router-link
        >
      </th>
    </tr>
  </nav>
  <div class="overlay">
    <div class="popup" style="margin-right: 50px;">
      <h2>Tambah List Baru</h2>
      <form id="tambah" @submit.prevent="createList()">
        <div class="form-group">
          <label>Nama List:</label>
          <input
            v-model="newList"
            type="text"
            placeholder="Masukkan nama list"
            required
          />
        </div>
        <div class="popup-buttons">
          <button type="submit" class="btn primary">Tambah</button>
        </div>
      </form>
    </div>
    <div class="popup">
      <h2>Tambah Tugas Baru</h2>
      <form id="tambah" @submit.prevent="createTask()">
        <div class="form-group">
          <label>Nama Tugas:</label>
          <input
            v-model="newTask.task_name"
            type="text"
            placeholder="Masukkan nama tugas"
            required
          />
        </div>
        <div class="form-group">
          <label>List:</label>
          <select v-model="newTask.list_id" required>
            <option value="" disabled selected>Pilih list</option>
            <option v-for="(item, index) in lists" :key="item.id" :value="item.id">
              {{ item.list_name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label>Prioritas:</label>
          <select v-model="newTask.priority" required>
            <option value="" selected disabled>Pilih prioritas</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
          </select>
        </div>
        <div class="form-group">
          <label>Tanggal:</label>
          <input
            v-model="newTask.date"
            type="date"
            :min="new Date().toLocaleDateString('en-CA')"
            required
          />
        </div>
        <div class="popup-buttons">
          <button type="submit" class="btn primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from 'axios'

export default {
  data() {
    return {
      lists: [],
      newTask: {
        task_name: '',
        list_id: '',
        priority: '',
        date: '',
      },
      newList: ''
    }
  },
  mounted() {
    this.getLists()
  },
  methods: {
    createTask() {
      const formData = new FormData()
      formData.append('task_name', this.newTask.task_name)
      formData.append('list_id', this.newTask.list_id)
      formData.append('priority', this.newTask.priority)
      formData.append('date', this.newTask.date)

      axios.post(`http://127.0.0.1:8000/api/todolist`, formData).then((response) => {
        this.newTask = {
          task_name: '',
          list_id: '',
          priority: '',
          date: '',
        }

        this.$router.push('/')
      })
    },
    getLists() {
      axios.get(`http://127.0.0.1:8000/api/todolist/lists`).then((response) => {
        this.lists = response.data
      })
    },
    createList() {
      const formData = new FormData()
      formData.append('list_name', this.newList)

      axios.post(`http://127.0.0.1:8000/api/todolist/lists`, formData).then((response) => {
        this.getLists();
        this.newList = '';

        this.$router.push('/')
      })
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

input,
select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}

.popup-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
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

.overlay {
  margin-top: 50px;
  left: 0;
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.title,
.button-container,
.table-container,
.popup,
form,
input,
select,
table,
th,
td {
  font-family: 'Lucida Console', 'Courier New', monospace;
}
</style>
