<template>
  <main-layout title="Cash Flow History">
    <v-container fluid>
      <!-- User Main Detail -->

      <v-data-table
        :headers="headers"
        :items="cash_flow"
        light
        item-key="id"
        :items-per-page="-1"
        hide-default-footer
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-row no-gutters>
            <v-col cols="12" md="6" lg="8" sm="12">
              <v-btn text color="accent" class="compress--icon" @click="back()">
                <v-icon>arrow_back</v-icon>
              </v-btn>
            </v-col>
            <v-col cols="12" md="6" lg="4" sm="12">
              <v-card-text>
                <v-chip color="white">
                  Total Withdraw: {{ $page.total_withdraw/100 }}
                  <v-icon small right color="green">fa-usd</v-icon>
                </v-chip>
                <div class="flex-grow-1"></div>
                <v-chip color="white">
                  Total Deposit: {{ $page.total_deposit/100 }}
                  <v-icon small right color="green">fa-usd</v-icon>
                </v-chip>
              </v-card-text>
            </v-col>
          </v-row>

          <!--<v-row justify="center">
            <v-btn
              text
              icon
              :disabled="prev_cursor == null"
              color="primary"
              class="mr-2"
              @click="prevPage(prev_cursor)"
            >
              <v-icon x-large>mdi-menu-left</v-icon>
            </v-btn>
            <v-btn
              text
              icon
              :disabled="next_cursor == null"
              color="primary"
              @click="nextPage(next_cursor)"
            >
              <v-icon x-large>mdi-menu-right</v-icon>
            </v-btn>
          </v-row>-->
          <!--
          <v-row justify="center">
            <v-col cols="12">
              <v-text-field
                v-model.number="form.limit"
                label="Items per page"
                type="number"
                min="-1"
                max="15"
              ></v-text-field>
            </v-col>
          </v-row>
          -->
        </template>
        <!-- Table Rows -->
        <template v-slot:item.cashflowId="{ item }">{{ item.cashflowId }}</template>

        <template v-slot:item.type="{ item }">{{ item.type }}</template>

        <template v-slot:item.delta="{ item }">{{ item.delta/100 }}</template>
      </v-data-table>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Acl from "../../mixins/acl";
import swal from "sweetalert2";

export default {
  components: {
    MainLayout
  },
  // from backend
  props: {
    cash_flow: Array,
    trading_account_id: {
      type: [String, Number],
      default: null
    },

    trading_account_id: {
      type: [String, Number],
      default: null
    },
    total_balance: {
      type: [String, Number],
      default: null
    },
    total_withdraw: {
      type: [String, Number],
      default: null
    },
    total_deposit: {
      type: [String, Number],
      default: 0
    }
  },
  mixins: [Acl],
  data: () => ({
    headers: [
      { text: "ID", value: "cashflowId", align: "left" },
      { text: "Type", value: "type", align: "left" },
      { text: "Change", value: "delta", align: "left" }
    ]
  }),

  methods: {
    back() {
      this.$inertia.visit(route("ctrader.accounts.index").url());
    }
  }
};
</script>
