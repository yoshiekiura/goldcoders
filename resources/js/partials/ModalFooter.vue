<template>
  <v-footer 
    :class="[footerClass]" 
    app
    padless
    >
    <v-row
      justify="center"
      no-gutters
    >
      <v-btn
        v-for="link in links"
        :key="link"
        color="white"
        text
        rounded
        class="my-2"
      >
        {{ link }}
      </v-btn>
      <v-col
        class="accent py-4 text-center white--text"
        cols="12"
      >
          <span>© {{ year }} {{ domain }} ® | {{ trademark }}™</span>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
export default {
  data: () => ({
    footerClass: { "primary--text": true, accent: true },
    year: new Date().getFullYear(),
    domain: "fx20.test",
    trademark: "Invest Wisely",
    links: [
        'Home',
        'About Us',
        'Team',
        'Services',
        'Blog',
        'Contact Us',
      ],
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
