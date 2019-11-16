<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <app-alert />
      <v-layout row my-4>
        <inertia-link
          class="title font-weight-thin inertia-link"
          :href="route('approval.user.file')"
        >
          {{ name }}
        </inertia-link>
      </v-layout>

      <v-layout row>
        <v-flex md6>
          <v-card>
            <v-container class="pa-2" fluid grid-list-md>
              <v-layout column>
                <span class="header grey--text ml-3 mt-3">General</span>

                <v-flex px-5>
                  <v-autocomplete
                    v-model="form.member_id"
                    readonly
                    :items="users"
                    required
                    color="blue-grey"
                    label="Member"
                    item-text="name"
                    item-value="value"
                    light
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.member_id"
                  />
                  <v-autocomplete
                    v-model="form.file_id"
                    :items="files_data"
                    readonly
                    color="blue-grey"
                    label="File Title"
                    item-text="name"
                    item-value="value"
                    light
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.file_id"
                  />

                  <v-text-field
                    v-model="form.date_submitted"
                    readonly
                    :error-messages="$page.errors.date_submitted"
                    label="Date Submitted"
                    prepend-icon="event"
                    v-on="on"
                  />

                  <v-text-field
                    v-model="form.date_approved"
                    readonly
                    :error-messages="$page.errors.date_submitted"
                    label="Date Approved"
                    prepend-icon="event"
                    v-on="on"
                  />
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-flex>
        <v-flex md6>
          <v-card>
            <v-container class="pa-2" fluid grid-list-md>
              <v-layout column>
                <span class="header grey--text ml-3 mt-3">Details</span>

                <v-flex px-5>
                  <v-flex md11 offset-md1>
                    <v-card v-if="images.length > 0">
                      <v-container fluid>
                        <v-row>
                          <v-col
                            v-for="(image,key) in images"
                            :key="key"
                            class="d-flex child-flex"
                            cols="4"
                          >
                            <v-card flat tile class="d-flex">
                              <v-img :src="image" aspect-ratio="1" class="grey lighten-2">
                                <template v-slot:placeholder>
                                  <v-row class="fill-height ma-0" align="center" justify="center">
                                    <v-progress-circular indeterminate color="grey lighten-5" />
                                  </v-row>
                                </template>
                              </v-img>
                            </v-card>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>
                  </v-flex>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-flex>
        <!-- <pre>{{ $data }}</pre> -->
      </v-layout>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import objectToFormData from "object-to-formdata";
import AppAlert from "@/partials/AppAlert";
import fileManager from "@/mixins/file_manager";
import RM from "@/mixins/role_helper";
export default {
  components: {
    MainLayout,
    AppAlert,
  },
  mixins: [fileManager, RM],
  props: {
    files: Object,
    documents: Array,
    filesData: Array,
    users: Array,
    url: String,
  },
  data() {
    return {
      dialog: false,
      modal1: false,
      name: "Approval User File View",
      images: [],
      form: {
        id: this.files.id,
        member_id: this.files.member_id,
        file_id: this.files.file_id,
        date_submitted: this.files.date_submitted,
        date_approved: this.files.date_approved,
        busy: false,
        images: null,
      },
    };
  },
  watch: {
    "form.images": {
      handler: function(val) {
        let self = this;
        self.images = [];
        self.images = self.formatManagerFiles(val);
      },
      deep: true,
    },
  },
  created() {
    let self = this;
    self.images = self.formatManagerFileForCreated(self.documents);

    this.ifMemberOnly = this.checkIfMemberOnly();
  },
  methods: {
    submit() {
      let self = this;
      self.form.busy = true;
      self.$inertia
        .post(
          self.route("user_file_manager.update").url(),
          objectToFormData(self.form),
          {
            replace: true,
            preserveState: true,
          }
        )
        .then(() => (self.form.busy = false));
    },
  },
};
</script>

<style scoped>
.img {
  max-width: 100%;
  max-height: 100%;
  height: auto;
  width: auto;
}
.card-action {
  background-color: #f1f5f8;
}
.inertia-link {
  text-decoration: none;
}
</style>
