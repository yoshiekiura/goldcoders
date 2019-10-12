<template>
  <main-layout :title="name">
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex centered lg12 md12>
          <app-alert></app-alert>
          <v-card>
            <v-flex xs12 class="white">
              <v-layout align-center justify-space-between row>
                <v-flex pl-4 md4>
                  <span class="headline font-weight-thin">{{ name }} Listing</span>
                </v-flex>
                <v-flex pr-4 xs12 md4 offset-md4>
                  <inertia-link class="btn" :href="route('payment.create')">
                    <v-btn block text color="primary" dark>
                      Add New {{ name }}
                      <v-icon right color="primary">fa-plus</v-icon>
                    </v-btn>
                  </inertia-link>
                </v-flex>
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
                :items="payments"
              >
                <template v-slot:item.activated="{ item }">
                  <v-chip :color="getColor(item.activated)" dark>{{ getStatus(item.activated) }}</v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    @click.native="editRecord(item)"
                    depressed
                    icon
                    fab
                    dark
                    color="primary"
                    small
                  >
                    <v-icon>edit</v-icon>
                  </v-btn>

                  <v-btn @click="deleteRecord(item)" depressed icon fab dark color="pink" small>
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
import AdminDashPanel from "@/Shared/AdminDashPanel";
import ModalLayout from "@/Layouts/ModalLayout";
import AppAlert from "@/partials/AppAlert";
import swal from "sweetalert2";

export default {
  components: {
    MainLayout,
    AdminDashPanel,
    ModalLayout,
    AppAlert
  },
  props: {
    payments: Array,
    link: String
  },

  computed: {},

  data: () => ({
    name: "Payment",
    form: {
      id: null,
      busy: false
    },
    headers: [
      { text: "Paymaster", value: "paymaster_name", align: "left", sortable: true },
      { text: "Member", value: "member_name", align: "left", sortable: true },
      { text: "Amount", value: "amount", align: "center", sortable: true },
      { text: "Date Enter", value: "date_enter", align: "center", sortable: true },
      { text: "Activated", value: "activated", align: "center", sortable: true },
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
    deleteRecord(data) {
      swal
        .fire({
          title: "Are you sure you?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia.post(this.route("payment.delete").url(), data);
            this.alert.model = true;
          }
        });
    },
    editRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      self.$inertia.visit(this.route("payment.edit", data).url(), self.form);
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
</style>




