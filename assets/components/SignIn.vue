<template>
  <div class="container">
    <div class="row py-4 justify-content-center">
      <div class="col-md-4 text-center">
        <a class="btn btn-primary" href="/connect/google">Sign in with Google</a>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "SignIn",
  created() {
    if (this.$store.getters["security/isAuthenticated"]) {
      this.$router.push({path: "/"});
    }
  }
}
</script>
