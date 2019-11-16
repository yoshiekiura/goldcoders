<template>
  <div class="pa-5">
    <v-row dense>
      <v-col v-for="(item,index) in overall_records" :key="index" cols="12" md="6" lg="6" sm="12">
        <card-dashboard-admin
          :name="item.name"
          :icon="item.icon"
          :details="item.details"
          :actions="item.actions"
          :color="item.color"
        />
      </v-col>
      <v-col v-for="(item,index) in total_accounts" :key="index" cols="12" md="6" lg="4" sm="12">
        <card-dashboard-admin
          :name="item.name"
          :icon="item.icon"
          :details="item.details"
          :actions="item.actions"
          :color="item.color"
        />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import CardDashboardAdmin from "@/Shared/CardDashboardAdmin";

export default {
  components: {
    CardDashboardAdmin,
  },
  data() {
    return {
      stats: {
        total_users: 0,
        subscription_total: 0,
        account_subscriptions: 0,
        direct_referrals: 0,
        total_subscription_commissions: 0,
        account_subscription_commission: 0,
        direct_referral_commission: 0,
        overriding_commission: 0,
      },
      overall_records: [
        {
          name: "Overall Subscription Commission",
          icon: "local_atm",
          color: "#00CAE3",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Overall Overriding Commission",
          icon: "local_atm",
          color: "#E91E63",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
      ],
      total_accounts: [
        {
          name: "Total Users",
          icon: "supervised_user_circle",
          color: "#4CAF50",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Total Subscriptions",
          icon: "fa-sitemap",
          color: "#FF9800",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Account Subscriptions Count",
          icon: "money",
          color: "#4557b7",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Count",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Direct Referrals",
          icon: "person_pin",
          color: "#3565b7",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Direct Referral Commission",
          icon: "fa-users",
          color: "#E11113",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
        {
          name: "Account Subscription Commission",
          icon: "attach_money",
          color: "#229197",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total",
              value: 0,
            },
          ],
          actions: [
            {
              text: "Details",
              func: () => this.test(),
            },
          ],
        },
      ],
    };
  },

  computed: {
    test() {},
    getMe() {
      return this.$page.auth.user;
    },
    isSuperAdmin() {
      if (this.getMe.id === 1) {
        return true;
      }
      return false;
    },
    five_percent() {
      let subtotal =
        parseInt(this.stats.total_subscription_commissions) -
        parseInt(this.stats.account_subscription_commission) -
        parseInt(this.stats.direct_referral_commission);
      let percent = subtotal * 0.05;
      if (isNaN(percent)) {
        return 0;
      } else {
        return Math.round(percent);
      }
    },
  },
  mounted() {},
  methods: {},
};
</script>

<style>
</style>
