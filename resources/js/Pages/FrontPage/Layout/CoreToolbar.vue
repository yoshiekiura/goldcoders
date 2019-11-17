<template>
  <section>
    <v-layout column>
      <v-toolbar app class="white px-5" flat id="app-toolbar">
        <v-toolbar-title class="mr-3 text-xs-center">
          <v-layout row align-center justify-center>
            <v-hyperlink>
              <!-- <app-logo width="50"></app-logo> -->
               <img :src="image_src">

            </v-hyperlink>

            <span class="hidden-sm-and-down">
              <v-list>
                <v-list-tile>
                  <v-list-tile-content>
                    <v-list-tile-title class="font-weight-bold" style="margin-bottom: -5px">Gold</v-list-tile-title>
                    <v-list-tile-title class="font-weight-bold">Coders</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </span>
          </v-layout>
        </v-toolbar-title>

        <v-toolbar-items>
          <!-- <tb-about-us></tb-about-us>
          <tb-customer></tb-customer>
          <tb-news></tb-news>
          <tb-career></tb-career> -->
        </v-toolbar-items>

        <v-spacer />

        <v-toolbar-items>
          <v-btn icon flat>
            <v-avatar size="35px">
              <img :src="profileLogo" alt="avatar" />
            </v-avatar>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
    </v-layout>
  </section>
</template>

<script>
import VHyperlink from "@/Shared/VHyperlink";
import AppLogo from "@/Shared/AppLogo";
export default {
  components: {
    VHyperlink,
    AppLogo,
  },

  data() {
    return {
        image_src: '/images/logo/logo.png',
    };
  }
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
