<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <app-alert></app-alert>
      <v-layout row my-4>
        <inertia-link
          class="headline font-weight-thin inertia-link"
          :href="route('user_file_manager')"
        >{{ name }}</inertia-link>
        <span class="headline font-weight-thin mx-1">/</span>
        <span class="headline font-weight-thin">Edit</span>
      </v-layout>

      <v-layout row>
        <v-flex md6>
          <v-card>
            <v-container class="pa-2" fluid grid-list-md>
              <v-layout column>
                <span class="header grey--text ml-3 mt-3">General</span>

                <v-flex px-5>
                  <v-autocomplete
                    autofocus
                    :items="users"
                    v-model="form.member_id"
                    required
                    color="blue-grey"
                    label="Member"
                    item-text="name"
                    item-value="value"
                    light
                    chips
                    clearable
                    deletable-chips
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.member_id"
                  />
                  <v-autocomplete
                    autofocus
                    :items="files_data"
                    v-model="form.file_id"
                    required
                    color="blue-grey"
                    label="File Title"
                    item-text="name"
                    item-value="value"
                    light
                    chips
                    clearable
                    deletable-chips
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.file_id"
                  />

                  <v-dialog
                    ref="dialog1"
                    v-model="modal1"
                    :return-value.sync="form.date_submitted"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="form.date_submitted"
                        :error-messages="$page.errors.date_submitted"
                        label="Date Submitted"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      />
                    </template>
                    <v-date-picker v-model="form.date_submitted" scrollable>
                      <v-spacer />
                      <v-btn color="primary" @click="modal1 = false">Cancel</v-btn>
                      <v-btn color="primary" @click="$refs.dialog1.save(form.date_submitted)">OK</v-btn>
                    </v-date-picker>
                  </v-dialog>
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
                    <v-file-input
                      v-model="form.images"
                      placeholder="Upload your documents"
                      label="Documents"
                      multiple
                      prepend-icon="mdi-camera"
                      :show-size="1000"
                      counter
                    >
                      <template v-slot:selection="{ text }">
                        <v-chip small label color="primary">{{ text }}</v-chip>
                      </template>
                    </v-file-input>

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
                                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
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

            <v-layout align-center justify-center row fill-height py-3>
              <v-btn
                class="ma-2"
                depressed
                color="indigo darken-4"
                :loading="form.busy"
                :disabled="errors.any() || form.busy"
                @click.native="submit()"
              >
                <span class="white--text">Update {{ name }}</span>
              </v-btn>
            </v-layout>
          </v-card>
        </v-flex>
        <pre>{{ $data }}</pre>
      </v-layout>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import objectToFormData from "object-to-formdata";
import AppAlert from "@/partials/AppAlert";
import fileManager from "@/mixins/file_manager";

export default {
  components: {
    MainLayout,
    AppAlert
  },
  mixins: [fileManager],
  props: {
    files: Object,
    documents: Array,
    files_data: Array,
    users: Array,
    url: String
  },
  created() {
    let self = this;
    self.images = self.formatManagerFileForCreated(self.documents);
  },
  data() {
    return {
      dialog: false,
      modal1: false,
      name: "User File Manager",
      images: [],
      form: {
        id: this.files.id,
        member_id: this.files.member_id,
        file_id: this.files.file_id,
        date_submitted: this.files.date_submitted,
        busy: false,
        images: null
      }
    };
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
            preserveState: true
          }
        )
        .then(() => (self.form.busy = false));
    }
  },
  watch: {
    "form.images": {
      handler: function(val, oldVal) {
        let self = this;
        self.images = [];
        self.images = self.formatManagerFiles(val);
      },
      deep: true
    }
  }
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
