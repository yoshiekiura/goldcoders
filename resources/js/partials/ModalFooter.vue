<template>
  <v-footer :class="[footerClass]" app padless>
    <v-row justify="center" no-gutters>
      <v-hyperlink v-for="(item, index) in links" :key="index" :href="item.route">
        <v-btn color="white" text rounded class="my-2">{{ item.text }}</v-btn>
      </v-hyperlink>


      <!-- <v-btn v-for="(item, index) in links" :key="index" color="white" text rounded class="my-2">{{ item.text }}</v-btn> -->

      <!-- <v-hyperlink>
        <v-btn color="white" text rounded class="my-2">{{ link }}</v-btn>
      </v-hyperlink>-->

      <v-col class="accent py-4 text-center white--text" cols="12">
        <span>© {{ year }} {{ domain }} ® | {{ trademark }}™</span>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
import VHyperlink from "@/Shared/VHyperlink";

export default {
  components: {
    VHyperlink,
  },
  data: () => ({
    footerClass: { "primary--text": true, accent: true },
    year: new Date().getFullYear(),
    domain: "fx20.test",
    trademark: "Invest Wisely",
    // links: ["Home", "About Us", "Team", "Services", "Blog", "Contact Us"],

    links: [
      { text: "Home", route: "home" },
      { text: "About Us", route: "home" },
      { text: "Team", route: "home" },
      { text: "Services", route: "home" },
      { text: "Blog", route: "home" },
      { text: "Contact Us", route: "home" },
    ],
  }),
  created() {
    /* Emit On a Child Component If You Want This To Be Visible */
    // eslint-disable-next-line no-undef
    Bus.$on("footer-content-visible", visibility => {
      this.contentVisible = visibility;
    });
  },
};
</script>

<style>
</style>
