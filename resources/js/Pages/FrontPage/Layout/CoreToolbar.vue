<template>
  <v-toolbar id="app-toolbar" dark class flat>
    <v-toolbar-title class="hidden-sm-and-down mr-3 text-xs-center">
      <v-row justify="center" align="center">
        <v-hyperlink>
          <img :src="image_src">
        </v-hyperlink>
      </v-row>
    </v-toolbar-title>

    <v-spacer class="hidden-sm-and-down" />

    <toolbar-how-it-work />
    <toolbar-faq />
    <toolbar-testimonials />
    <toolbar-tradings />
    <toolbar-contact />


    <v-spacer class="d-flex d-sm-none" />

    <v-hyperlink href="login">
      <toolbar-client-area />
    </v-hyperlink>


    <toolbar-search />
  </v-toolbar>
</template>

<script>
import VHyperlink from "@/Shared/VHyperlink";
import ToolbarHowItWork from "./ToolbarHowItWork";
import ToolbarFaq from "./ToolbarFaq";
import ToolbarTestimonials from "./ToolbarTestimonials";
import ToolbarTradings from "./ToolbarTradings";
import ToolbarContact from "./ToolbarContact";
import ToolbarClientArea from "./ToolbarClientArea";
import ToolbarSearch from "./ToolbarSearch";

export default {
  components: {
    VHyperlink,
    ToolbarHowItWork,
    ToolbarFaq,
    ToolbarTestimonials,
    ToolbarTradings,
    ToolbarContact,
    ToolbarClientArea,
    ToolbarSearch,
  },

  data() {
    return {
      image_src: "/images/logo/logo.png",
    };
  },
};
</script>

<style>
.toolbar-bottom-line {
  background-color: var(--v-primary-base);
  background: var(--v-primary-base);
  height: 20px;
}
</style>

<style lang="sass">
#app-toolbar
  .v-toolbar__title
    margin-left: .5em
  font-weight: 300
    font-size: 21px
    position: relative
    top: 1px

  .v-toolbar__items
    .v-btn
      text-transform: capitalize
      font-size: 16px
      font-weight: 300

  .v-toolbar__extension
    padding: 0
    z-index: -1
</style>


<style scoped>
.btn {
  text-decoration: none;
}
.inertia-link {
  text-decoration: none;
}
</style>




