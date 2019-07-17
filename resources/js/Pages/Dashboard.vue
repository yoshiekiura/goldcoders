<template>
  <main-layout title="Dashboard">
    <admin-dash-panel />
    <!-- <customer-dash-panel /> -->
  </main-layout>
</template>

<script>
import MainLayout from "../Layouts/MainLayout";
import AdminDashPanel from "../Shared/AdminDashPanel";
// import CustomerDashPanel from "../Shared/CustomerDashPanel";

export default {
  components: {
    MainLayout,
    AdminDashPanel
    // CustomerDashPanel
  },
  data: () => ({})
};
</script>
