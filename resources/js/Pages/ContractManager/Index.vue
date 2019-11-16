<template>
  <main-layout :title="name">
    <v-container fluid>
      <v-row>
        <v-col cols="12">
          <v-row align="center" justify="center" class="grey lighten-5 py-12 my-12">
            <button-card
              v-for="(item,index) in details"
              v-show="index == 0 ? !ifMemberOnly : true"
              :key="index"
              :icon="item.icon"
              :name="item.name"
              :description="item.description"
              :func="item.func"
            />
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </main-layout>
</template>


<script>
import MainLayout from "@/Layouts/MainLayout";
import RM from "@/mixins/role_helper";
import ButtonCard from "@/Shared/ButtonCard";

export default {
  components: {
    MainLayout,
    ButtonCard,
  },
  mixins: [RM],

  data() {
    return {
      name: "Contract Manager",
      ifMemberOnly: false,
      details: [
        {
          icon: "all_inbox",
          name: "file manager",
          description: "admin",
          func: () => this.adminManagement(),
        },
        {
          icon: "assignment_returned",
          name: "download files",
          description: "user",
          func: () => this.userDownload(),
        },
        {
          icon: "backup",
          name: "upload files",
          description: "user",
          func: () => this.userUpload(),
        },
      ],
    };
  },
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
    },
  },
};
</script>

<style scoped>
.btn {
  text-decoration: none;
}
</style>
