<template>
  <main-layout title="Ctrader Accounts">
    <v-container fluid>
      <!-- User Main Detail -->

      <v-data-table
        :headers="headers"
        :items="deals"
        light
        item-key="id"
        :items-per-page="-1"
        hide-default-footer
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-card-text>
            <v-chip outline color="white">
              Current Balance: {{ balance }}
              <v-icon small right color="green">fa-usd</v-icon>
            </v-chip>
            <div class="flex-grow-1"></div>
            <v-chip outline color="white">
              Total Deposit: {{ total_deposit }}
              <v-icon small right color="green">fa-usd</v-icon>
            </v-chip>
          </v-card-text>

          <v-row justify="center">
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
          </v-row>

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
        </template>
        <!-- Table Rows -->
        <template v-slot:item.dealId="{ item }">{{ item.dealId }}</template>

        <template v-slot:item.symbolName="{ item }">{{ item.symbolName.toUpperCase() }}</template>

        <template v-slot:item.tradeSide="{ item }">{{ item.tradeSide }}</template>

        <template v-slot:item.volume="{ item }">{{ item.volume/10000 }}</template>

        <template v-slot:item.positionCloseDetails.profitInPips="{ item }">{{ getPips(item) }}</template>
        <template v-slot:item.positionCloseDetails.profit="{ item }">{{ getPRL(item)}}</template>
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
    deals: Array,
    filters: Object,
    paymaster: {
      type: Object,
      default: null
    },
    next_cursor: {
      type: String,
      default: null
    },
    prev_cursor: {
      type: String,
      default: null
    },
    from: {
      type: [String, Number],
      default: null
    },
    to: {
      type: [String, Number],
      default: null
    },
    trading_account_id: {
      type: [String, Number],
      default: null
    },
    cursors: {
      type: Array,
      default: null
    },
    deposit: {
      type: [String, Number],
      default: null
    }
  },
  mixins: [Acl],
  data: () => ({
    headers: [
      { text: "DID", value: "dealId", align: "left" },
      { text: "Symbol", value: "symbolName", align: "left" },
      { text: "Trade Side", value: "tradeSide", align: "left" },
      { text: "Lot Size", value: "volume", align: "left" },
      {
        text: "Pips",
        value: "positionCloseDetails.profitInPips",
        align: "left"
      },
      { text: "Net Pr/L", value: "positionCloseDetails.profit", align: "left" }
    ],
    form: {
      trading_account_id: null,
      from: null,
      to: null,
      cursor: null, // always save this on session?
      prev_cursor: null,
      limit: 25
    },
    balance: 0,
    total_deposit: 0
  }),

  created() {
    let self = this;
    self.form.trading_account_id = self.trading_account_id;
    self.form.from = self.filters.from;
    self.form.to = self.filters.to;
    self.form.cursor = self.filters.cursor; // current
    self.form.limit = self.filters.limit;
    self.debouncedGetHistory = _.debounce(self.fetchDeals, 50);
    self.balance = this.deals[0].positionCloseDetails.balance / 100;
    self.total_deposit = self.deposit / 100;
  },
  methods: {
    getPips(item) {
      if (item.positionCloseDetails && item.positionCloseDetails.profitInPips) {
        return parseFloat(item.positionCloseDetails.profitInPips);
      }
      return 0;
    },
    getPRL(item) {
      if (item.positionCloseDetails && item.positionCloseDetails.profit) {
        return parseFloat(item.positionCloseDetails.profit) / 100;
      }
      return 0;
    },
    nextPage(cursor) {
      if (cursor) {
        this.form.cursor = cursor;
      }
    },
    prevPage(cursor) {
      //cursor here is the current
      let index = this.cursors.indexOf(cursor);
      if (index > 0) {
        index = index - 1;
      }
      let pointer = this.cursors[index];
      this.form.cursor = pointer;
    },
    fetchDeals() {
      let query = _.pickBy(this.form);
      let url = this.route(
        "ctrader.tradinghistory",
        Object.keys(query).length ? query : { remember: "forget" }
      ).url();
      this.$inertia.replace(url);
    },
    reset(key) {
      this.form[key] = undefined;
    }
  },
  watch: {
    "form.cursor"(newVal) {
      this.debouncedGetHistory();
    },
    "form.limit"(newVal) {
      this.reset("cursor");
      this.reset("from");
      this.reset("to");
      this.debouncedGetHistory();
    },
    "form.from"(newVal) {
      this.debouncedGetHistory();
    },
    "form.to"(newVal) {
      this.debouncedGetHistory();
    }
  }
};
</script>
