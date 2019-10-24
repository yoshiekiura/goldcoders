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
                    :href="route('contract_manager')"
                  >Contract Manager</inertia-link>
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
                :items="files"
              >
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    @click.native="download(item)"
                    depressed
                    icon
                    fab
                    dark
                    color="primary"
                    small
                  >
                    <v-icon>cloud_download</v-icon>
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
    files: Array
  },
  computed: {},
  data: () => ({
    name: "User Downloadable Files",
    form: {
      id: null,
      busy: false
    },
    headers: [
      {
        text: "Download",
        value: "actions",
        width: 80,
        align: "center",
        sortable: false
      },
      { text: "Title", value: "title", align: "left", sortable: true },
      { text: "File Count", value: "count", align: "center", sortable: true }
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
    download(data) {
      let self = this;
      let url = self
        .route("download_files", { admin_file_manager: data.id })
        .url();
      window.open(url);
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




