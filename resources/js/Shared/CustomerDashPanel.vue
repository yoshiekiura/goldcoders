<template>
  <div class="pa-5">
    <v-row dense>
      <v-col cols="12" md="6" lg="4" sm="12" v-for="(item,index) in records" :key="index">
        <card-dashboard
          :name="item.name"
          :icon="item.icon"
          :details="item.details"
          :actions="item.actions"
          :color="item.color"
        ></card-dashboard>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import CardDashboard from "@/Shared/CardDashboard";

export default {
  components: {
    CardDashboard
  },
  props: {
    subscription_count: String,
    subscription_verified: String,
    referrals_total: Number,
    kyc_verified: Boolean,
    payment_total: Number,
    payout_request_total: Number
  },
  data() {
    return {
      records: [
        {
          name: "Subscription",
          icon: "money",
          color: "#00CAE3",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Counts",
              value: this.subscription_count
            },
            {
              icon: "check_circle_outline",
              name: "Verified",
              value: this.subscription_verified
            }
          ],
          actions: [
            {
              text: "Details",
              func: () => this.subscription()
            }
          ]
        },
        {
          name: "Referrals",
          icon: "mdi-account-group",
          color: "#E91E63",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total Referrals",
              value: this.referrals_total
            }
          ],
          actions: [
            {
              text: "Details",
              func: () => this.referral()
            }
          ]
        },

        {
          name: "KYC",
          icon: "assignment_turned_in",
          color: "#4CAF50",
          details: [
            {
              icon: "check_circle_outline",
              name: "Status",
              value: this.kyc_verified ? "Verified" : "Not Yet Verified"
            }
          ],
          actions: [
            {
              text: "Details",
              func: () => this.kyc()
            }
          ]
        },
        {
          name: "Deposit",
          icon: "assignment_returned",
          color: "#FF9800",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total Deposit",
              value: this.payment_total
            }
          ],
          actions: [
            {
              text: "Details",
              func: () => this.deposit()
            }
          ]
        },
        {
          name: "Payout",
          icon: "work",
          color: "#4557b7",
          details: [
            {
              icon: "format_list_numbered_rtl",
              name: "Total Payout",
              value: this.payout_request_total
            }
          ],
          actions: [
            {
              text: "Details",
              func: () => this.income()
            }
          ]
        }
      ]
    };
  },
  methods: {
    referral() {
      console.log("referral");
    },
    subscription() {
      console.log("subscription");
    },
    kyc() {
      console.log("kyc");
    },
    deposit() {
      console.log("deposit");
    },
    income() {
      console.log("income");
    }
  }
};
</script>

