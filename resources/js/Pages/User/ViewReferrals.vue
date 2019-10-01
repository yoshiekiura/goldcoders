<template>
  <main-layout :title="`${sponsor.name} Referrals`">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-pagination
        v-if="$page.users.links.length  !== 3"
        v-model="page"
        :length="parseInt($page.users.links.length - 2)"
      />
      <v-text-field
        v-model.number="per_page"
        label="Items per page"
        type="number"
        min="-1"
        max="15"
      ></v-text-field>
      <v-data-table
        :headers="headers"
        :items="users.data"
        light
        item-key="id"
        :page.sync="page"
        :server-items-length="parseInt($page.users.links.length -2)"
        :items-per-page="-1"
        hide-default-footer
        :sort-by="sortBy"
        :sort-desc="sortDesc"
        multi-sort
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
          <v-btn text icon color="error" class="compress--icon" @click="openDialog(item)">
            <v-icon>fa-trash</v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Acl from "../../mixins/acl";
import validationError from "../../mixins/validation-error";
import { Form } from "vform";
import swal from "sweetalert2";

export default {
  components: {
    MainLayout
  },
  // from backend
  props: {
    users: Object,
    sponsor: Object,
    status: Boolean,
    filters: Object
  },
  mixins: [Acl, validationError],
  data: () => ({
    headers: [
      { text: "Name", value: "name", align: "left" },
      { text: "Status", value: "active", align: "left" },
      { text: "Actions", value: "action", sortable: false }
    ],
    sortBy: [],
    sortDesc: [false, true],
    form: {
      search: "",
      sortBy: "",
      orderBy: "",
      active: ""
    },
    statuses: ["active", "inactive"],
    page: 1,
    per_page: 10
  }),
  created() {
    let self = this;
    self.form.search = self.filters.search;
    self.form.orderBy = self.filters.orderBy;
    self.form.sortBy = self.filters.sortBy;
    self.form.active = self.filters.active;
    self.form.user = self.$page.sponsor.id;
  },
  methods: {
    getStatus(status) {
      if (status) {
        return "Active";
      } else {
        return "Inactive";
      }
    },
    viewReferrals(user) {
      this.$inertia.visit(route("referrals.view", { id: user.id }).url());
    },
    setQueryString(query, val) {
      let self = this;

      let url = new URL(window.location.href);

      let qs = url.search;

      let sp = new URLSearchParams(qs);

      sp.delete(query);
      if (val) {
        sp.append(query, val);
      }

      url.search = sp.toString();

      let new_url = url.toString();
      console.log(new_url, "power");
      self.$inertia.replace(new_url);
    },
    reset() {
      this.form = _.mapValues(this.form, () => null);
    }
  },
  watch: {
    form: {
      handler: _.throttle(function() {
        this.page = 1;
        this.per_page = 10;

        let query = _.pickBy(this.form);
        let url = this.route(
          "referrals.view",
          Object.keys(query).length ? query : { remember: "forget" }
        ).url();
        this.$inertia.replace(url);
      }, 150),
      deep: true,
      immediate: false
    },
    page: {
      handler(newVal) {
        this.setQueryString("page", newVal);
      }
    },
    per_page: {
      handler(newVal) {
        this.setQueryString("per_page", newVal);
      }
    }
  }
};
</script>
