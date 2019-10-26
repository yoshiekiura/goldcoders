<template>
  <main-layout :title="name">
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex centered lg12 md12>
          <app-alert></app-alert>
          <v-card>
            <v-flex xs12 class="white">
              <v-layout align-center justify-space-between row>
                <v-flex pl-4 md6>
                  <inertia-link
                    class="title font-weight-thin inertia-link"
                    :href="route('approval')"
                  >Approval Manager</inertia-link>
                  <span class="title font-weight-thin mx-1">/</span>
                  <span class="title font-weight-thin">{{ name }}</span>
                </v-flex>
                <v-flex pr-4 xs12 md4></v-flex>
                <v-flex>
                  <v-text-field
                    solo
                    prepend-icon="search"
                    :placeholder="`Search ${name} Here`"
                    v-model="search"
                    hide-details
                    class="hidden-sm-and-down"
                  ></v-text-field>
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
                    @click.native="viewRecord(item)"
                    depressed
                    icon
                    fab
                    dark
                    color="blue"
                    small
                  >
                    <v-icon>fa-list-ul</v-icon>
                  </v-btn>
                  <v-btn
                    @click=" item.approved ? disapprovedRecord(item) : approvedRecord(item)"
                    depressed
                    icon
                    fab
                    dark
                    color="pink"
                    small
                  >
                    <v-icon v-if="item.approved">fa-thumbs-o-down</v-icon>
                    <v-icon v-else>fa-thumbs-o-up</v-icon>
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
    AppAlert
  },
  props: {
    payouts: Array,
    link: String
  },

  computed: {},

  data: () => ({
    name: "Payout Approval",
    form: {
      id: null,
      busy: false
    },
    headers: [
      {
        text: "Paymaster",
        value: "paymaster_name",
        align: "left",
        sortable: true
      },
      { text: "Member", value: "member_name", align: "left", sortable: true },
      { text: "Amount", value: "amount", align: "center", sortable: true },
      {
        text: "Date Payout",
        value: "date_payout",
        align: "center",
        sortable: true
      },
      { text: "Approved", value: "approved", sortable: true },
      { text: "Actions", value: "actions", align: "center", sortable: false }
    ],
    search: "",
    alert: {
      model: true,
      message: "message here",
      type: "info" //info success warning error
    }
  }),
  watch: {},
  methods: {
    viewRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      self.$inertia.visit(this.route("payout.view", data).url(), self.form);
    },
    approvedRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      swal
        .fire({
          title: "Assign as approved?",
          html: `
            Paymaster: <b>${data.paymaster_name}</b><br>
            Member: <b>${data.member_name}</b><br>
            Amount: <b>${data.amount}</b><br>
            Date Submitted: ${data.date_payout}<br>`,
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#6f6f6f",
          confirmButtonText: "Confirm",
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia
              .post(
                this.route("approval.payout.approved", { payout: data }).url()
              )
              .then(res => {
                if (res) {
                  data.approved = 1;
                }
              });
          }
        });
    },
    disapprovedRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      swal
        .fire({
          title: "Assign as disapproved?",
          html: `
            Paymaster: <b>${data.paymaster_name}</b><br>
            Member: <b>${data.member_name}</b><br>
            Amount: <b>${data.amount}</b><br>
            Date Submitted: ${data.date_payout}<br>`,
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#6f6f6f",
          confirmButtonText: "Confirm",
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia
              .post(
                this.route("approval.payout.disapproved", {
                  payout: data
                }).url()
              )
              .then(res => {
                if (res) {
                  data.approved = 0;
                }
              });
          }
        });
    },
    getColor(status) {
      if (status) return "green";
      else return "red";
    },
    getStatus(val) {
      return val ? "Yes" : "No";
    }
  }
};
</script>

<style scoped>
.btn {
  text-decoration: none;
}
.inertia-link {
  text-decoration: none;
}
</style>




