<template>
  <v-app-bar app clipped-right color="accent" dark>
    <v-app-bar-nav-icon @click.stop="toggleDrawer()"></v-app-bar-nav-icon>
    <v-toolbar-title>{{ title }}</v-toolbar-title>
    <div class="flex-grow-1"></div>
    <v-app-bar-nav-icon v-if="withRight" @click.stop="toggleRightDrawer()"></v-app-bar-nav-icon>
  </v-app-bar>
</template>

<script>
export default {
  props: { title: String , withRight: Boolean},
  methods: {
    toggleDrawer() {
      Bus.$emit("toggleDrawer");
    },
    toggleRightDrawer() {
      Bus.$emit("toggleRightDrawer");
    }
  }
};
</script>

<style>
</style>
