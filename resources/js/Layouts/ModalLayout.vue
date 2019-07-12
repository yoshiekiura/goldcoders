<template>
  <v-app v-cloak standalone>
    <main>
      <v-container transition="slide-x-transition" fluid class="pa-0 ma-0 white">
        <v-card :flat="true">
          <slot name="toolbar" />
          <slot />
          <slot name="footer" />
        </v-card>
      </v-container>
    </main>
  </v-app>
</template>

<script>
export default {
  props: {
    title: String
  },
  mounted(){
    this.updatePageTitle(this.title)
  },
  methods: {
    updatePageTitle(title) {
      document.title = title
        ? `${title} | ${this.$page.app.name}`
        : this.$page.app.name;
    }
  },
  watch: {
    title(title) {
      this.updatePageTitle(title);
    }
  }
};
</script>

<style>
</style>
