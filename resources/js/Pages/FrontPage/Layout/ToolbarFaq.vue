<template>
  <v-btn text class="hidden-sm-and-down">
    <span class="mr-1" v-text="title" />
  </v-btn>
</template>

<script>
export default {
  data() {
    return {
      title: "Faq",
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
