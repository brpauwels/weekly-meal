<template>
  <div v-if="isLoading">
    <div class="d-flex justify-content-center py-4">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <div v-else>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <router-link class="navbar-brand" to="/">Weekly Meal</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <router-link class="nav-item" tag="li" to="/" active-class="active">
              <a class="nav-link">Home</a>
            </router-link>
          </ul>
          <div class="d-flex">
            <div v-if="isAuthenticated" class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ user.email }}
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <main>
      <router-view/>
    </main>
  </div>
</template>

<script>
export default {
  name: "App",
  computed: {
    isLoading() {
      return this.$store.getters['security/isLoading']
    },
    user() {
      return this.$store.getters['security/user']
    },
    isAuthenticated() {
      return this.$store.getters['security/isAuthenticated']
    },
  }
}
</script>
