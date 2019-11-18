<template>
  <v-footer color="#292929" class="white--text" height="auto">
    <v-container fluid mx-12>
      <v-row class="my-8">
        <v-col cols="12" md="3" xs="12">
          <div class="pb-4 title text-uppercase white--text text--justify">About FTMO</div>
          <li
            v-for="(item, i) in links_about"
            :key="i"
            style="list-style-type: none;"
            class="white--text font-weight-light subtitle-1"
          >
            <a :href="item.href">{{ item.text }}</a>
          </li>
        </v-col>
        <v-col cols="12" md="3" xs="12">
          <div class="pb-4 title text-uppercase white--text text--justify">Trading</div>
          <li
            v-for="(item, i) in links_trading"
            :key="i"
            style="list-style-type: none;"
            class="white--text font-weight-light subtitle-1"
          >
            <a :href="item.href">{{ item.text }}</a>
          </li>
        </v-col>
        <v-col cols="12" md="3" xs="12">
          <div class="pb-4 title text-uppercase white--text text--justify">Apps</div>
          <li
            v-for="(item, i) in links_apps"
            :key="i"
            style="list-style-type: none;"
            class="white--text font-weight-light subtitle-1"
          >
            <a :href="item.href">{{ item.text }}</a>
          </li>
        </v-col>

        <v-col cols="12" md="3" xs="12">
          <div class="title text-uppercase white--text text--justify">CONTACT</div>
          <img :src="image_src">

          <li
            style="list-style-type: none;"
            class="white--text font-weight-light subtitle-1"
          >
            support@ftmo.com
          </li>
          <li
            style="list-style-type: none;"
            class="mb-8 white--text font-weight-light subtitle-1"
          >
            EN +420 773 010 372
          </li>

          <li
            v-for="(item, i) in links_contact"
            :key="i"
            style="list-style-type: none;"
            class="white--text font-weight-light subtitle-1"
          >
            <a :href="item.href">{{ item.text }}</a>
          </li>

          <div class="mt-8">
            <a v-for="(item, i) in links_social_media" :key="i" :href="item.href">
              <img :src="item.image" class="pr-2">
            </a>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>


<script>
// import AppLogo from "@/Shared/AppLogo";
export default {
  components: {
    // AppLogo
  },
  data() {
    return {
      image_src: "/images/logo/logo.png",
      links_about: [
        { text: "Home", href: "#" },
        { text: "Funding Process", href: "#" },
        { text: "Trading Objectives", href: "#" },
        { text: "Why our Challenge?", href: "#" },
        { text: "Testimonials", href: "#" },
        { text: "Scaling Plan", href: "#" },
        { text: "Help Center", href: "#" },
        { text: "Partners", href: "#" },
        { text: "Affiliate Programme", href: "#" },
        { text: "Terms & Conditions", href: "#" },
      ],
      links_trading: [
        { text: "Blog", href: "#" },
        { text: "Dax Daily Prep", href: "#" },
        { text: "Economic Calendar", href: "#" },
        { text: "Ebook: How to Receive Funding", href: "#" },
      ],
      links_apps: [
        { text: "Account MetriX", href: "#" },
        { text: "Statistical App", href: "#" },
        { text: "Mentor App", href: "#" },
        { text: "Trading Journal", href: "#" },
        { text: "Account Analysis", href: "#" },
        { text: "Broker Review", href: "#" },
      ],
      links_contact: [
        { text: "Contact Options", href: "#" },
        { text: "Privacy Policy", href: "#" },
        { text: "Cookies", href: "#" },
      ],
      links_social_media: [
        { image: "/images/logo/facebook.png", href: "#" },
        { image: "/images/logo/twitter.png", href: "#" },
        { image: "/images/logo/instagram-1.png", href: "#" },
        { image: "/images/logo/youtube.png", href: "#" },
      ],
    };
  },
  computed: {},
};
</script>


<style scoped>
a {
  color: white;
  text-decoration: none; /* no underline */
}
a:hover {
  color: var(--v-primary-base);
}
</style>
