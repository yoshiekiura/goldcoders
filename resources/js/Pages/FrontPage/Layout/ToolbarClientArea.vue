<template>
  <v-btn color="#124295">
    <span class="mr-1" v-text="title" />
  </v-btn>
</template>

<script>
export default {
  data() {
    return {
      title: "Client Area",
      value: "",
    };
  },
};
</script>


<style>
.tbhoverprimary:hover {
  color: var(--v-primary-base);
}
</style>
