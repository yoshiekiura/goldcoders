
<template>
  <main-layout title="Ctrader Api Manager">
    <v-flex xs12>
      <app-alert />
    </v-flex>
    <v-container fill-height>
      <v-row justify="center">
        <v-btn color="accent" @click="connectApi">
          {{ btnTxt }}
          <v-icon right>fa-plug</v-icon>
        </v-btn>
        <v-btn v-if="hasAccessToken && !hasExpiredAccessToken" color="success" text>
          Ctrader Token Active
          <v-icon>check</v-icon>
        </v-btn>
        <v-btn v-if="hasExpiredAccessToken" color="warning" @click="refreshToken">
          Refresh Access Token
          <v-icon right>fa-refresh</v-icon>
        </v-btn>
      </v-row>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Acl from "../../mixins/acl";
import AppAlert from "../../partials/AppAlert";

export default {
  components: {
    MainLayout,
    AppAlert,
  },
  mixins: [Acl],
  props: {
    account: Object,
    expired: Boolean,
  },
  computed: {
    hasAccessToken() {
      if (this.account.ctrader_token) {
        return !!this.account.ctrader_token.access_token;
      }
      return !!this.account.ctrader_token;
    },
    hasExpiredAccessToken() {
      return this.expired;
    },
    btnTxt() {
      if (!this.hasAccessToken) {
        return "Connect Api Token";
      } else {
        return "Modify Api Permission";
      }
    },
  },
  methods: {
    connectApi() {
      window.location.replace(this.route("ctrader.connect").url());
    },
    refreshToken() {
      window.location.replace(this.route("ctrader.refresh_token").url());
    },
  },
};
</script>

<style>
</style>
