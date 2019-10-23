<template>
  <main-layout :title="name">
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex centered lg12 md12>
          <v-card>
            <v-flex xs12 class="white">
              <v-layout align-center justify-space-between row>
                <v-flex pl-4 md4>
                  <span class="headline font-weight-thin">{{ name }}</span>
                </v-flex>

                <v-flex></v-flex>
              </v-layout>
            </v-flex>

            <v-flex md12 class="white py-12">
              <v-row dense align="center" justify="center" class style="height: 300px;">
                <v-row dense align="center" justify="center">
                  <v-col
                    cols="12"
                    md="6"
                    lg="4"
                    sm="12"
                    v-for="(action,index) in details"
                    :key="index"
                    v-show="index == 0 ? !ifMemberOnly : true"
                  >
                    <v-btn
                      x-large
                      outlined
                      class="ma-2"
                      min-width="250"
                      height="200"
                      text
                      @click="action.func()"
                    >
                      <v-list-item-avatar color="#1867C0">
                        <v-icon color="white">{{ action.icon }}</v-icon>
                      </v-list-item-avatar>
                      <v-list-item two-line>
                        <v-list-item-content>
                          <v-list-item-title>{{ action.name }}</v-list-item-title>
                          <v-list-item-subtitle>{{ action.description }}</v-list-item-subtitle>
                        </v-list-item-content>
                      </v-list-item>
                      <v-spacer></v-spacer>
                      <v-icon color="grey" right>keyboard_arrow_right</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>

                <v-flex md6>
                  <v-row justify="center">
                    <v-col justify="center" cols="auto"></v-col>
                  </v-row>
                </v-flex>
              </v-row>
            </v-flex>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import AdminDashPanel from "@/Shared/AdminDashPanel";
import RM from "@/mixins/role_helper";

export default {
  components: {
    MainLayout,
    AdminDashPanel
  },
  mixins: [RM],
  created() {
    this.ifMemberOnly = this.checkIfMemberOnly();
  },
  methods: {
    userDownload() {
      this.$inertia.visit(this.route("view_downloadable_files").url());
    },
    userUpload() {
      this.$inertia.visit(this.route("user_file_manager").url());
    },
    adminManagement() {
      this.$inertia.visit(this.route("admin_file_manager").url());
    }
  },

  data() {
    return {
      name: "Contract Manager",
      ifMemberOnly: false,
      details: [
        {
          icon: "all_inbox",
          name: "file manager",
          description: "admin",
          func: () => this.adminManagement()
        },
        {
          icon: "assignment_returned",
          name: "download files",
          description: "user",
          func: () => this.userDownload()
        },
        {
          icon: "backup",
          name: "upload files",
          description: "user",
          func: () => this.userUpload()
        }
      ]
    };
  }
};
</script>

<style scoped>
.btn {
  text-decoration: none;
}
</style>
