<template>
  <div class="pa-5">
    <v-row>
      <v-col cols="12" md="6" lg="4" sm="12" v-for="(item,index) in records" :key="index">
        <v-card class>
          <v-list-item align="center" justify="center">
            <v-list-item-content>
              <v-list-item-title class="headline">
                <v-list-item-avatar color="grey">
                  <v-icon class="white--text text--darken-2">{{ item.icon }}</v-icon>
                </v-list-item-avatar>
                {{ item.name }}
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-list-item v-for="(detail,index) in item.details" :key="index">
            <v-list-item-icon>
              <v-icon>{{ detail.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ detail.name }}</v-list-item-title>
            <v-list-item-subtitle class="text-right">{{ detail.value }}</v-list-item-subtitle>
          </v-list-item>

          <v-divider></v-divider>
          <v-card-actions v-if="item.actions.length">
            <v-spacer></v-spacer>
            <v-btn
              text
              v-for="(action,index) in item.actions"
              :key="index"
              @click="action.func()"
            >{{ action.text }}</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>



<script>
export default {
  props: {
    subscription_count: String,
    subscription_verified: String,
    referrals_total: String,
    kyc_verified: String,
    payment_total: String,
    payout_request_total: String
  },
  data() {
    return {
      records: [
        {
          name: "Subscription",
          icon: "money",
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
          details: [
            {
              icon: "check_circle_outline",
              name: "Status",
              value: this.kyc_verified ? 'Verified' : 'Not Yet Verified'
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

