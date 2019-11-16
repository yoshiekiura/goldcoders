<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <app-alert />
      <v-layout row my-4>
        <inertia-link
          class="headline font-weight-thin inertia-link"
          :href="route('admin_file_manager')"
        >
{{ name }}
</inertia-link>
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
                  <v-text-field
                    v-model="form.title"
                    autofocus
                    class="primary--text"
                    label="Title"
                    prepend-icon="assessment"
                    :error-messages="$page.errors.title"
                  />
                  <v-switch v-model="form.active" label="Active ?" />
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

export default {
  components: {
    MainLayout,
    AppAlert,
  },
  mixins: [fileManager],
  props: {
    files: Object,
    documents: Array,
    url: String,
  },
  data() {
    return {
      dialog: false,
      name: "Admin File Manager",
      images: [],
      form: {
        id: this.files.id,
        title: this.files.title,
        active: this.files.active,
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
  },
  methods: {
    submit() {
      let self = this;
      self.form.busy = true;

      this.$inertia
        .post(
          this.route("admin_file_manager.update").url(),
          objectToFormData(self.form),
          {
            replace: true,
            preserveState: true,
          }
        )
        .then(() => ((this.form.busy = false), (this.alert = true)));
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
