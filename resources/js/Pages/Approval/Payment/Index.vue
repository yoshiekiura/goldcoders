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
                :items="items"
              >
                <template v-slot:item.approved="{ item }">
                  <!-- <v-chip :color="getColor(item.approved)" dark>{{ getStatus(item.approved) }}</v-chip> -->
                  <v-switch disabled color="green darken-4" :label="getStatus(item.approved)" />
                  <!-- <v-switch
                    color="green darken-4"
                    :label="getStatus(item.approved)"
                    @change="editRecord(item)"
                  />-->
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    v-show="item.approved == 0"
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
    items: Array,
    link: String
  },

  computed: {},

  data: () => ({
    name: "Payment Approval",
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
        text: "Date Payment",
        value: "date_paid",
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
    editRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      swal
        .fire({
          title: "Assign as approved?",
          html: `
            Paymaster: <b>${data.paymaster_name}</b><br>
            Member: <b>${data.member_name}</b><br>
            Amount: ${data.amount}<br>
            Date: ${data.date_paid}<br>`,
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
            this.$inertia.post(
              this.route("approval.payment.approved", data).url()
            );
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




