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
                    :href="route('approval')"
                  >
                    Approval Manager
                  </inertia-link>
                  <span class="title font-weight-thin mx-1">/</span>
                  <span class="title font-weight-thin">{{ name }}</span>
                </v-flex>
                <v-flex pr-4 xs12 md4 />
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
                <template v-slot:item.download="{ item }">
                  <v-btn
                    depressed
                    icon
                    fab
                    dark
                    color="primary"
                    small
                    @click.native="download(item)"
                  >
                    <v-icon>cloud_download</v-icon>
                  </v-btn>
                </template>

                <template v-slot:item.approved="{ item }">
                  <v-chip :color="getColor(item.approved)" dark>{{ getStatus(item.approved) }}</v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    depressed
                    icon
                    fab
                    dark
                    color="blue"
                    small
                    @click.native="viewRecord(item)"
                  >
                    <v-icon>fa-list-ul</v-icon>
                  </v-btn>

                  <v-btn
                    depressed
                    icon
                    fab
                    dark
                    color="pink"
                    small
                    @click=" item.approved ? disapprovedRecord(item) : approvedRecord(item)"
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
    AppAlert,
  },
  props: {
    files: Array,
  },
  data: () => ({
    name: "User File Manager",
    form: {
      id: null,
      busy: false,
    },
    headers: [
      {
        text: "Download",
        value: "download",
        width: 80,
        align: "center",
        sortable: false,
      },

      { text: "Member", value: "member", align: "left", sortable: true },
      { text: "Title", value: "title", align: "left", sortable: true },
      {
        text: "Date Submitted",
        value: "date_submitted",
        align: "center",
        sortable: true,
      },
      { text: "Approved", value: "approved", align: "center", sortable: true },
      { text: "Actions", value: "actions", align: "center", sortable: false },
    ],
    search: "",
  }),
  computed: {},
  watch: {},
  methods: {
    viewRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      let self = this;
      self.$inertia.visit(
        this.route("user_file_manager.view", data).url(),
        self.form
      );
    },
    approvedRecord(data) {
      this.form.busy = true;
      this.form.id = data.id;
      swal
        .fire({
          title: "Assign as approved?",
          html: `
            Member: <b>${data.member}</b><br>
            Title: <b>${data.title}</b><br>
            Date Submitted: ${data.date_submitted}<br>`,
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#6f6f6f",
          confirmButtonText: "Confirm",
          reverseButtons: true,
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia
              .post(
                this.route("approval.user.file.approved", { file: data }).url()
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
      swal
        .fire({
          title: "Assign as disapproved?",
          html: `
            Member: <b>${data.member}</b><br>
            Title: <b>${data.title}</b><br>
            Date Submitted: ${data.date_submitted}<br>`,
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#6f6f6f",
          confirmButtonText: "Confirm",
          reverseButtons: true,
        })
        .then(result => {
          if (result.value) {
            this.form.busy = true;
            this.$inertia
              .post(
                this.route("approval.user.file.disapproved", {
                  file: data,
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
    getColor(active) {
      if (active) return "green";
      else return "red";
    },
    getStatus(val) {
      return val ? "Approved" : "Pending";
    },
    download(data) {
      let self = this;
      let url = self
        .route("download_files", { admin_file_manager: data.id })
        .url();
      window.open(url);
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
