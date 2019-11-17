<template>
  <main-layout :title="name">
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex centered lg12 md12>
          <app-alert />
          <v-card>
            <v-flex xs12 class="white">
              <v-layout align-center justify-space-between row>
                <v-flex pl-4 md4>
                  <span class="headline font-weight-thin">{{ name }} Listing</span>
                </v-flex>
                <v-flex pr-4 xs12 md4 offset-md4>
                  <inertia-link class="btn" :href="route('payout.create')">
                    <v-btn block text color="primary" dark>
                      Add New {{ name }}
                      <v-icon right color="primary">fa-plus</v-icon>
                    </v-btn>
                  </inertia-link>
                </v-flex>
                <v-flex>
                  <v-text-field
                    v-model="search"
                    solo
                    prepend-icon="search"
                    :placeholder="`Search ${name} Here`"
                    hide-details
                    class="hidden-sm-and-down"
                  />
                </v-flex>
              </v-layout>
            </v-flex>
          </v-card>

          <v-card>
            <v-card-text class="pa-0">
              <v-data-table
                :headers="headers"
                :search="search"
                item-key="name"
                class="elevation-1"
                :items="payouts"
              >
                <template v-slot:item.approved="{ item }">
                  <v-chip :color="getColor(item.approved)" dark>{{ getStatus(item.approved) }}</v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    depressed
                    icon
                    fab
                    dark
                    color="primary"
                    small
                    @click.native="editRecord(item)"
                  >
                    <v-icon>edit</v-icon>
                  </v-btn>

                  <v-btn depressed icon fab dark color="pink" small @click="deleteRecord(item)">
                    <v-icon>delete</v-icon>
                  </v-btn>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import AppAlert from "@/partials/AppAlert";
import swal from "sweetalert2";

export default {
  components: {
    MainLayout,
    AppAlert,
  },
  props: {
    payouts: Array,
    link: String,
  },

  data: () => ({
    name: "Payout",
    form: {
      id: null,
      busy: false,
    },
    headers: [
      {
        text: "Paymaster",
        value: "paymaster_name",
        align: "left",
        sortable: true,
      },
      { text: "Member", value: "member_name", align: "left", sortable: true },
      { text: "Amount", value: "amount", align: "center", sortable: true },
      {
        text: "Date Payout",
        value: "date_payout",
        align: "center",
        sortable: true,
      },
      { text: "Approved", value: "approved", align: "center", sortable: true },
      { text: "Actions", value: "actions", align: "center", sortable: false },
    ],
    search: "",
    alert: {
      model: true,
      message: "message here",
      type: "info", //info success warning error
    },
  }),

  computed: {},
  watch: {},
  methods: {
    deleteRecord(data) {
      if (data.approved) {
        this.notAllowed();
        return;
      }
      swal
        .fire({
          title: "Are you sure you?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          reverseButtons: true,
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia.post(this.route("payout.delete").url(), data);
            this.alert.model = true;
          }
        });
    },
    editRecord(data) {
      if (data.approved) {
        this.notAllowed();
        return;
      }
      this.form.busy = true;
      this.form.id = data.id;
      this.$inertia.visit(this.route("payout.edit", data).url(), this.form);
    },
    getColor(status) {
      if (status) return "green";
      else return "red";
    },
    getStatus(val) {
      return val ? "Yes" : "No";
    },
    notAllowed() {
      swal.fire({
        title: "Not Allowed",
        text: "Record was already approved.",
        type: "warning",
        confirmButtonColor: "#3085d6",
      });
    },
  },
};
</script>

<style scoped>
.btn {
  text-decoration: none;
}
</style>




