
<template>
  <main-layout title="Connect Ctrader Account">
    <v-container fill-height>
      <v-row justify="center">
        <v-btn color="accent" @click="connectApi">
          Connect Ctrader Account
          <v-icon right>fa-plug</v-icon>
        </v-btn>
      </v-row>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Acl from "../../mixins/acl";

export default {
  components: {
    MainLayout
  },
  props: {
    account: Object,
  },
  mixins: [Acl],
  computed: {
    hasAccessToken() {
      return false;
    },
    hasExpiredAccessToken() {
      return false;
    }
  },
  methods: {
    connectApi() {
      window.location.replace(route("ctrader.connect").url())
    }
  }
};
</script>

<style>
</style>
