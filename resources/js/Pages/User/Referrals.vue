<template>
  <main-layout :title="`${sponsor.name.toUpperCase()} REFERRALS`">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-pagination
        v-if="users.meta.visible"
        v-model="form.page"
        :length="users.meta.total_pages"
        :total-visible="10"
      />
      <v-text-field
        v-model.number="form.per_page"
        label="Items per page"
        type="number"
        min="-1"
        max="15"
      ></v-text-field>
      <v-card-title v-if="showBack">
        <v-btn color="accent" dark @click="back()">
          Back
          <v-icon right>arrow_back</v-icon>
        </v-btn>
        <div class="flex-grow-1"></div>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="users.data"
        light
        item-key="id"
        :page.sync="form.page"
        :server-items-length="users.meta.total_pages"
        :items-per-page="-1"
        hide-default-footer
        class="elevation-1"
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-toolbar dark color="blue-grey darken-4" class="mb-1">
            <v-text-field
              v-model="form.search"
              clearable
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="search"
              label="Search User"
              @click:append="reset()"
              append-icon="refresh"
            ></v-text-field>
            <div class="flex-grow-1"></div>
            <v-select
              v-model="form.status"
              :items="statuses"
              label="Filter Status"
              clearable
              @click:append="reset()"
              append-icon="refresh"
              hide-details
              solo-inverted
              prepend-inner-icon="group"
              flat
            ></v-select>
          </v-toolbar>
        </template>
        <!-- Table Rows -->
        <template v-slot:item.name="{ item }">{{ item.name.toUpperCase() }}</template>

        <template v-slot:item.active="{ item }">
          <v-switch v-model="item.active" :label="getStatus(item.active)" readonly />
        </template>
        <template v-slot:item.action="{item}">
          <v-btn text icon color="blue" class="compress--icon" @click="viewReferrals(item)">
            <v-icon>fa-users</v-icon>
          </v-btn>
        </template>
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
    user: {
      type: String,
      default: null
    },
    users: Object,
    sponsor: {
      type: Object,
      default: null
    },
    status: Boolean,
    filters: Object
  },
  mixins: [Acl],
  computed: {
    showBack() {
      if (window.location.href.indexOf(`/referrals/${this.sponsor.id}`) > 0) {
        return true;
      }
      return false;
    }
  },
  data: () => ({
    headers: [
      { text: "Name", value: "name", align: "left" },
      { text: "Status", value: "active", align: "left" },
      { text: "Referrals", value: "action", sortable: false }
    ],
    form: {
      user: null,
      search: "",
      page: 1,
      per_page: 10,
      status: ""
    },
    statuses: ["active", "inactive"]
  }),
  created() {
    let self = this;
    self.form.search = self.filters.search;
    self.form.status = self.filters.status;
    self.form.page = parseInt(self.users.meta.page);
    self.form.per_page = parseInt(self.users.meta.per_page);
    self.form.user = self.filters.user;
    self.debouncedGetUsers = _.debounce(self.fetchUsers, 50);
  },
  methods: {
    back() {
      if (this.user) {
        this.$inertia.replace(
          route("referrals.index", { user: this.user }).url()
        );
      } else {
        this.$inertia.replace(route("referrals.index").url());
      }
    },
    fetchUsers() {
      let query = _.pickBy(this.form);
      let url = this.route(
        "referrals.index",
        Object.keys(query).length ? query : { remember: "forget" }
      ).url();
      this.$inertia.replace(url);
    },
    getStatus(status) {
      if (status) {
        return "Active";
      } else {
        return "Inactive";
      }
    },
    viewReferrals(user) {
      this.$inertia.replace(route("referrals.index", { user }).url());
    },
    reset() {
      this.form = _.mapValues(this.form, () => null);
    }
  },
  watch: {
    "form.search"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.role"() {
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
    "form.user"(newVal) {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.page"(newVal) {
      if (this.form.page !== 1) {
        this.debouncedGetUsers();
      }
    }
  }
};
</script>
