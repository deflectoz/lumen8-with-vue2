<template>
  <div>
    <b-navbar type="dark" variant="dark">
      <b-navbar-nav>
        <b-nav-item :to="{ name: 'dashboard' }">Home</b-nav-item>
        <b-nav-item :to="{ name: 'User List' }">Register User</b-nav-item>
        <!-- Navbar dropdowns -->
      </b-navbar-nav>
    </b-navbar>
  </div>
</template>

<script>
export default {};
</script>