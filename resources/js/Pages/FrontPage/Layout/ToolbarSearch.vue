<template>
  <v-btn icon x-small class="mx-10">
    <v-icon>fa-search</v-icon>
  </v-btn>
</template>

<script>
export default {
  data() {
    return {
      title: "Search",
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
