<template>
  <v-footer 
    :class="[footerClass]" 
    app>
    <v-spacer/>
    <span>© {{ year }} {{ domain }} ® | {{ trademark }}™</span>
    <v-spacer/>
  </v-footer>
</template>

<script>
export default {
  data: () => ({
    footerClass: { "primary--text": true, accent: true },
    year: new Date().getFullYear(),
    domain: "fx20.test",
    trademark: "Invest Wisely"
  }),
  created() {
    /* Emit On a Child Component If You Want This To Be Visible */
    Bus.$on("footer-content-visible", visibility => {
      this.contentVisible = visibility;
    });
  }
};
</script>

<style>
</style>
