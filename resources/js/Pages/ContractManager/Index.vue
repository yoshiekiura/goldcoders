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
              <v-row align="center" justify="center" class="grey lighten-5" style="height: 300px;">
                <v-flex md6 >
                  <v-row align="center" justify="center" class="grey lighten-5">
                    <inertia-link class="btn" :href="route('admin_file_manager')">
                      <v-btn color="indigo" x-large dark class="btn ma-2 white--text">
                        Admin File Manager
                        <v-icon right dark>mdi-cloud-upload</v-icon>
                      </v-btn>
                    </inertia-link>
                  </v-row>
                </v-flex>
                <v-flex md6>
                  <v-row align="center" justify="center" class="grey lighten-5">
                    <inertia-link class="btn" :href="route('view_downloadable_files')">
                      <v-btn color="indigo" x-large dark class="btn ma-2 white--text">
                        User Download Files
                        <v-icon right dark>mdi-cloud-upload</v-icon>
                      </v-btn>
                    </inertia-link>
                    <inertia-link class="btn" :href="route('user_file_manager')">
                      <v-btn color="indigo" x-large dark class="btn ma-2 white--text">
                        User Upload Files
                        <v-icon right dark>mdi-cloud-upload</v-icon>
                      </v-btn>
                    </inertia-link>
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
import ModalLayout from "@/Layouts/ModalLayout";

export default {
  components: {
    MainLayout,
    AdminDashPanel,
    ModalLayout
  },

  data: () => ({
    name: "Contract Manager"
  }),
  methods: {

  }
};
</script>





<style scoped>
.btn {
  text-decoration: none;
}
</style>
