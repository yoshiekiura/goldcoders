<template>
  <main-layout :title="name">
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex centered lg12 md12>
          <app-alert />
          <v-card>
            <v-flex xs12 class="white">
              <v-layout align-center justify-space-between row>
                <v-flex pl-4 md6>
                  <inertia-link
                    class="title font-weight-thin inertia-link"
                    :href="route('contract_manager')"
                  >
                    Contract Manager
                  </inertia-link>
                  <span class="title font-weight-thin mx-1">/</span>
                  <span class="title font-weight-thin">{{ name }}</span>
                </v-flex>
                <v-flex pr-4 xs12 md4>
                  <inertia-link class="btn" :href="route('admin_file_manager.create')">
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
                :items="files"
              >
                <template v-slot:item.active="{ item }">
                  <v-chip :color="getColor(item.active)" dark>{{ getStatus(item.active) }}</v-chip>
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
    files: Array,
    link: String,
  },

  data: () => ({
    name: "Admin File Manager",
    form: {
      id: null,
      busy: false,
    },
    headers: [
      { text: "Title", value: "title", align: "left", sortable: true },
      { text: "Active", value: "active", align: "center", sortable: true },
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
            this.$inertia.post(
              this.route("admin_file_manager.delete").url(),
              data
            );
            this.alert.model = true;
          }
        });
    },
    editRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      self.$inertia.visit(
        this.route("admin_file_manager.edit", data).url(),
        self.form
      );
    },
    getColor(active) {
      if (active) return "green";
      else return "red";
    },
    getStatus(val) {
      return val ? "Active" : "Inactive";
    },
  },
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




