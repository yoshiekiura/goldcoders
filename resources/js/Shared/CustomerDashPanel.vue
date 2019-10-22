<template>
  <v-layout row wrap pa-5 ma-5>
    <v-flex xs12 md6 text-xs-center>
      <v-card color="blue-grey white--text" class="ma-1" height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;cursor:pointer;"
          @click="test"
        >
          <v-icon x-large color="teal lighten-3">money</v-icon>
          <v-subheader class="white--text">Total Subscriptions</v-subheader>
          {{ stats.subscriptions_count }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs12 md6 text-xs-center>
      <v-card color="blue-grey white--text" class="ma-1" height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;cursor:pointer;"
          @click="test"
        >
          <v-icon x-large color="indigo lighten-5">person_pin</v-icon>
          <v-subheader class="white--text">Direct Referrals</v-subheader>
          {{ stats.referrals_count }}
          <br />
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs12 md6 text-xs-center>
      <v-card color="blue-grey white--text" class="ma-1" height="150px">
        <v-card-text class="title" style="margin-left:auto;margin-right:auto;width:150px;">
          <v-icon x-large color="blue-grey lighten-5">attach_money</v-icon>
          <v-subheader class="white--text">Subscriptions Commission</v-subheader>
          {{ stats.subscriptions_commission }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs12 md6 text-xs-center>
      <v-card color="blue-grey white--text" class="ma-1" height="150px">
        <v-card-text class="title" style="margin-left:auto;margin-right:auto;width:150px;">
          <v-icon x-large color="amber lighten-2">fa-money</v-icon>
          <v-subheader class="white--text">Referral Commission</v-subheader>
          {{ stats.referral_commission }}
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data: () => ({
    stats: {
      subscriptions_count: 1,
      referrals_count: 1,
      subscriptions_commission: 1,
      referral_commission: 1
    }
  }),
  methods: {
    test() {}
  },
  computed: {
    getMe() {
      return this.$page.auth.user;
    }
  },
  mounted() {
    // this.getStats();
  },
  methods: {
    // getStats() {
    //   let self = this;
    // }
  }
};
</script>

<style>
</style>
