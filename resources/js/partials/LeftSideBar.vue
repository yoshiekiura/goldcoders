<template>
  <v-navigation-drawer v-model="drawer" app class="blue-grey darken-4">
    <v-list color="primary darken-1">
      <v-row justify="center" class="mt-2">
        <v-avatar color="grey" size="62">
          <v-img class="elevation-6" :src="$page.auth.user.avatar" />
        </v-avatar>
      </v-row>

      <v-list-item>
        <v-list-item-content>
          <v-list-item-title
            class="text-center white--text"
          >
            {{ $page.auth.user.fname }} {{ $page.auth.user.lname }}
          </v-list-item-title>
          <v-list-item-subtitle
            class="caption font-weight-light text-center white--text"
          >
            Email: {{ $page.auth.user.email }}
          </v-list-item-subtitle>
          <v-btn
            v-if="$page.auth.isImpersonating"
            text
            color="white"
            class="compress--icon"
            @click="leave(item)"
          >
            <v-icon>power_settings_new</v-icon>
          </v-btn>
        </v-list-item-content>
      </v-list-item>
    </v-list>
    <v-divider />

    <v-list>
      <v-link
        title="Dashboard"
        href="dashboard"
        icon="dashboard"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('manage_users')"
        title="Manage Users"
        href="users.index"
        icon="fa-users"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('manage_users')"
        title="Manage Plans"
        href="subscription.create"
        icon="monetization_on"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('approve_payment')"
        title="Paymaster Portal"
        href="paymaster.index"
        icon="fa-money"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_referrals')"
        title="Referrals"
        href="referrals.index"
        icon="fa-sitemap"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('add_access_token')"
        title="Ctrader Connect"
        href="ctrader.view"
        icon="fa-plug"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_ctrader_account')"
        title="Ctrader Accounts"
        href="ctrader.accounts.index"
        icon="fa-bar-chart"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_gateway')"
        title="Gateway"
        href="gateway"
        icon="card_travel"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_payments')"
        title="Payment"
        href="payment"
        icon="fa-credit-card"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_payouts')"
        title="Payout"
        href="payout"
        icon="fa-money"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_contract_manager')"
        title="Contract Manager"
        href="contract_manager"
        icon="fa-file-word"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />

      <v-link
        v-if="can('view_approval')"
        title="Approval"
        href="approval"
        icon="fa-shield"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />

      <v-link
        v-if="can('view_profile')"
        title="Profile"
        href="profile.show"
        icon="fa-user"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        v-if="can('view_kyc')"
        title="KYC"
        href="kyc.show"
        icon="assignment_turned_in"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        title="Logout"
        href="logout"
        icon="power_settings_new"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import VLink from "../Shared/VLink";
import Acl from "../mixins/acl";

export default {
  components: {
    VLink,
  },
  mixins: [Acl],
  data: () => ({
    drawer: false,
    user: null,
  }),
  created() {
    let self = this;
    switch (self.$vuetify.breakpoint.name) {
    case "xs":
      return (self.drawer = false);
    case "sm":
      return (self.drawer = false);
    case "md":
      return (self.drawer = true);
    case "lg":
      return (self.drawer = true);
    case "xl":
      return (self.drawer = true);
    }
  },
  mounted() {
    let self = this;
    // eslint-disable-next-line no-undef
    Bus.$on("toggleDrawer", function() {
      self.drawer = !self.drawer;
    });
  },
  methods: {
    leave() {
      this.$inertia.visit(this.route("impersonate.leave").url());
    },
  },
};
</script>
