<template>
  <main-layout title="Dashboard">
    <admin-dash-panel v-if="$page.auth.user.roles.includes('paymaster','admin')" />
    <customer-dash-panel
      :subscription_count="subscription_count"
      :subscription_verified="subscription_verified"
      :referrals_total="referrals_total"
      :kyc_verified="kyc_verified"
      :payment_total="payment_total"
      :payout_request_total="payout_request_total"
      v-else
    />
  </main-layout>
</template>

<script>
import MainLayout from "../Layouts/MainLayout";
import AdminDashPanel from "../Shared/AdminDashPanel";
import CustomerDashPanel from "../Shared/CustomerDashPanel";

export default {
  props: {
    subscription_count: String,
    subscription_verified: String,
    referrals_total: Number,
    kyc_verified: Boolean,
    payment_total: Number,
    payout_request_total: Number
  },
  components: {
    MainLayout,
    AdminDashPanel,
    CustomerDashPanel
  },
  data() {
    return {};
  }
};
</script>
