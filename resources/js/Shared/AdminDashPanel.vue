<template>
  <v-layout
    row
    wrap
    px-5
    mx-5
  >
    <v-flex xs12>
      <v-alert
        :value="true"
        type="info"
        class="text-xs-center secondary--text"
        my-0
        py-0
        mx-3
        px-3
      >
        Note: Press Ctrl or CMD + F5 To Do Hard Page Refresh If You Experience Blank Page Unresponsive Due to Old Cached Of Assets (Only In Development Stage)
      </v-alert>
    </v-flex>
    <v-flex
      :class="{ md6: isSuperAdmin }"
      xs12
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
          <v-icon
            x-large
            color="brown lighten-3"
          >
            local_atm
          </v-icon>
          <v-card-title class="white--text">Overall Subscription Commission</v-card-title>
          <span style="margin-left:auto;margin-right:auto;width:150px;">{{ stats.total_subscription_commissions }}</span>
      </v-card>
    </v-flex>
    <v-flex
      v-if="getMe.id === 1"
      :class="{ md6: isSuperAdmin }"
      xs12
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;"
        >
          <v-icon
            x-large
            color="blue lighten-2"
          >
            fa-percent
          </v-icon>
          <p class="white--text">Overall Overriding Commission</p>
          {{ five_percent }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px"
        >
          <v-icon
            x-large
            color="pink lighten-4"
          >
            supervised_user_circle
          </v-icon>
          <v-subheader class="white--text">Total Users</v-subheader>
          {{ stats.total_users }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;"
        >
          <v-icon
            x-large
            color="cyan lighten-3"
          >
            fa-sitemap
          </v-icon>
          <v-subheader class="white--text">Total Subscriptions</v-subheader>
          {{ stats.subscription_total }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;cursor:pointer;"
          @click="$router.push({name:'subscriptions'})"
        >
          <v-icon
            x-large
            color="teal lighten-3"
          >
            money
          </v-icon>
          <v-subheader class="white--text">Account Subscriptions Count</v-subheader>
          {{ stats.account_subscriptions }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;cursor:pointer;"
          @click="$router.push({name:'account-referrals'})"
        >
          <v-icon
            x-large
            color="indigo lighten-5"
          >
            person_pin
          </v-icon>
          <v-subheader class="white--text">Direct Referrals</v-subheader>
          {{ stats.direct_referrals }}
          <br>
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;"
        >
          <v-icon
            x-large
            color="green lighten-2"
          >
            fa-money-bill-alt
          </v-icon>
          <v-subheader class="white--text">Direct Referral Commission</v-subheader>
          {{ stats.direct_referral_commission }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex
      xs12
      md4
      text-xs-center>
      <v-card
        color="secondary white--text"
        class="ma-1"
        height="150px">
        <v-card-text
          class="title"
          style="margin-left:auto;margin-right:auto;width:150px;"
        >
          <v-icon
            x-large
            color="secondary lighten-5"
          >
            attach_money
          </v-icon>
          <v-subheader class="white--text">Account Subscription Commission</v-subheader>
          {{ stats.account_subscription_commission }}
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>

export default {
  data: () => ({
    stats: {
      total_users: 0,
      subscription_total: 0,
      account_subscriptions: 0,
      direct_referrals: 0,
      total_subscription_commissions: 0,
      account_subscription_commission: 0,
      direct_referral_commission: 0,
      overriding_commission: 0
    }
  }),
  computed: {
    getMe(){
      return this.$page.auth.user
    }, 
    isSuperAdmin(){
        if(this.getMe.id === 1){
            return true;
        }
        return false;
    },
    five_percent(){
        let subtotal = parseInt(this.stats.total_subscription_commissions) - parseInt(this.stats.account_subscription_commission) - parseInt(this.stats.direct_referral_commission)
        let percent = subtotal * 0.05
        if(isNaN(percent)){
            return 0
        }else{
           return  Math.round(percent)
        }
    }
  },
  mounted() {
    // this.getStats();
  },
  methods: {
    // getStats() {
    //   let self = this;
    //   axios.post(route("api.dashboard.admin.getStats")).then(response => {
    //       console.log(response.data)
    //     self.stats = response.data.data;
    //   });
    // }
  }
};
</script>

<style>
</style>
