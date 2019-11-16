<template>
  <main-layout title="Ctrader Accounts">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-pagination
        v-if="accounts.meta.visible"
        v-model="form.page"
        :length="accounts.meta.total_pages"
        :total-visible="10"
      />
      <v-text-field
        v-model.number="form.per_page"
        label="Items per page"
        type="number"
        min="-1"
        max="15"
      />
      <v-data-table
        :headers="headers"
        :items="accounts.data"
        light
        item-key="id"
        :page.sync="form.page"
        :expanded.sync="expanded"
        :server-items-length="accounts.meta.total_pages"
        :items-per-page="-1"
        hide-default-footer
        show-expand
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-row>
            <v-col cols="12" md="6" lg="4" sm="12">
              <v-text-field
                v-model="form.search"
                flat
                hide-details
                prepend-inner-icon="search"
                label="Filter By ID"
                clearable
              />
            </v-col>
            <v-col cols="12" md="6" lg="4" sm="12">
              <v-text-field
                v-model="form.broker"
                flat
                hide-details
                prepend-inner-icon="fa-building"
                label="Filter By Broker"
                clearable
              />
            </v-col>

            <v-col cols="12" md="6" lg="4" sm="12">
              <v-text-field
                v-model.number="form.leverage"
                flat
                hide-details
                prepend-inner-icon="fa-superscript"
                label="Filter By Leverage"
                type="number"
                min="1"
                max="3000"
                clearable
              />
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="6" lg="4" sm="12">
              <v-text-field
                v-model.number="form.currency"
                flat
                hide-details
                prepend-inner-icon="fa-usd"
                label="Filter By Currency"
                clearable
              />
            </v-col>
            <v-col>
              <v-card class="d-flex flex-row" flat tile>
                <v-switch v-model="form.live" color="green" label="Live" />
                <v-switch v-model="form.demo" color="warning" label="Demo" />
              </v-card>
            </v-col>

            <v-col v-if="accounts.data.length >0" cols="12" md="6" lg="4" sm="12">
              <v-btn color="primary" @click="getAccounts()">
                <v-icon x-large>fa-groups</v-icon>Update Ctrader Accounts
              </v-btn>
            </v-col>
          </v-row>
        </template>
        <!-- Table Rows -->
        <template v-slot:item.accountId="{ item }">{{ item.id }}</template>

        <template v-slot:item.brokerName="{ item }">{{ item.broker_name.toUpperCase() }}</template>

        <template v-slot:item.currency="{ item }">{{ item.currency }}</template>

        <template v-slot:item.balance="{ item }">{{ item.balance/100 }}</template>

        <template v-slot:item.live="{ item }">
          <v-chip v-if="item.live">
            <v-icon left color="green">mdi-checkbox-marked-circle</v-icon>Live
          </v-chip>
          <v-chip v-else>
            <v-icon left color="warning">fa-bug</v-icon>Demo
          </v-chip>
        </template>
        <template v-slot:item.action="{item}">
          <v-btn text icon color="blue" class="compress--icon" @click="viewHistory(item)">
            <v-icon>timeline</v-icon>
          </v-btn>
          <v-btn text icon color="primary" @click="getCashFlow(item)">
            <v-icon>fa-usd</v-icon>
          </v-btn>
        </template>
        <template v-slot:expanded-item="props">
          <td colspan="12" fluid pa-0 ma-0>
            <v-row no-gutters justify="center">
              <span class="title primary--text">Account ID : {{ props.item.id }}</span>
              <v-col cols="12">
                <p class="title accent--text">Additional Info</p>
              </v-col>
              <v-col cols="12" md="6" lg="6" sm="6" xs="12">
                <v-text-field
                  v-model="props.item.account_no"
                  label="Ctrader Account No."
                  prepend-icon="fa-hashtag"
                  light
                  readonly
                />
              </v-col>
              <v-col cols="12" md="6" lg="6" sm="6" xs="12">
                <v-text-field
                  v-model="props.item.registration_date"
                  label="Date Registered"
                  prepend-icon="fa-calendar"
                  light
                  readonly
                />
              </v-col>

              <v-col cols="12" md="6" lg="6" sm="6" xs="12">
                <v-text-field
                  v-model="props.item.broker_title"
                  label="Broker Title"
                  prepend-icon="fa-building"
                  light
                  readonly
                />
              </v-col>

              <v-col align="left" justify="end" cols="12" md="6" lg="6" sm="6" xs="12">
                <v-chip>
                  <v-icon left color="primary">local_atm</v-icon>
                  {{ props.item.type }}
                </v-chip>
                <v-chip v-if="props.item.status === 'ACTIVE'">
                  <v-icon left color="green">how_to_reg</v-icon>ACTIVE
                </v-chip>
                <v-chip v-if="props.item.status !== 'ACTIVE'">
                  <v-icon left color="warning">block</v-icon>INACTIVE
                </v-chip>
                <v-chip v-if="props.item.deleted">
                  <v-icon left color="red">event_busy</v-icon>DELETED
                </v-chip>
                <v-chip v-if="!props.item.swap_free">
                  <v-icon left color="pink">360</v-icon>Swap Free
                </v-chip>
              </v-col>
            </v-row>
          </td>
        </template>
        <template v-slot:no-data>
          <v-btn text color="primary" @click="getAccounts()">
            <v-icon x-large>fa-groups</v-icon>Get All Accounts
          </v-btn>
        </template>
      </v-data-table>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Acl from "../../mixins/acl";

export default {
  components: {
    MainLayout
  },
  mixins: [Acl],
  // from backend
  props: {
    accounts: Object,
    paymaster: {
      type: Object,
      default: null
    },
    filters: Object
  },
  data: () => ({
    expanded: [],
    headers: [
      { text: "ID", value: "id", align: "left" },
      { text: "Broker", value: "broker_name", align: "left" },
      { text: "Leverage", value: "leverage", align: "left" },
      { text: "Currency", value: "currency", align: "left" },
      { text: "Balance", value: "balance", align: "left" },
      { text: "Live", value: "live", align: "left" },
      { text: "Action", value: "action", sortable: false }
    ],
    form: {
      search: "",
      broker: "",
      leverage: "",
      currency: "",
      live: null,
      demo: null,
      status: "",
      page: 1,
      per_page: 10
    }
  }),
  watch: {
    "form.search"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.broker"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.leverage"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.currency"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.live"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.demo"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.status"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.per_page"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },

    "form.page"() {
      this.debouncedGetUsers();
    }
  },

  created() {
    let self = this;
    self.form.search = self.filters.search;
    self.form.broker = self.filters.broker;
    self.form.leverage = self.filters.leverage;
    self.form.currency = self.filters.currency;
    self.form.live = self.filters.live;
    self.form.demo = self.filters.demo;
    self.form.status = self.filters.status;
    self.form.page = parseInt(self.accounts.meta.page);
    self.form.per_page = parseInt(self.accounts.meta.per_page);

    // eslint-disable-next-line no-undef
    self.debouncedGetUsers = _.debounce(self.fetchUsers, 50);
  },
  methods: {
    getCashFlow(item) {
      this.$inertia.visit(
        this.route("ctrader.getCashFlow", {
          trading_account_id: item.id
        }).url()
      );
    },
    getAccounts() {
      this.$inertia.visit(this.route("ctrader.getAccounts").url());
    },
    fetchUsers() {
      // eslint-disable-next-line no-undef
      let query = _.pickBy(this.form);
      let url = this.route(
        "ctrader.accounts.index",
        Object.keys(query).length ? query : { remember: "forget" }
      ).url();
      this.$inertia.replace(url);
    },
    viewHistory(account) {
      this.$inertia.replace(
        this.route("ctrader.tradinghistory", {
          trading_account_id: account.id
        }).url()
      );
    },
    reset(key) {
      this.form[key] = undefined;
    }
  }
};
</script>
