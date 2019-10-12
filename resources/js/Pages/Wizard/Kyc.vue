<template>
  <main-layout :title="title">
    <v-card flat class="grey lighten-5">
      <v-flex xs12 md8 offset-md2 text-xs-center>
        <app-alert></app-alert>
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          px-2
          v-model="account.fname"
          label="First Name"
          prepend-icon="perm_identity"
          readonly
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-model="account.mname"
          label="Middle Name"
          prepend-icon="person_pin"
          readonly
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-model="account.lname"
          label="Last Name"
          prepend-icon="supervisor_account"
          readonly
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-model="account.suffix"
          label="Suffix"
          prepend-icon="perm_contact_calendar"
          readonly
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field v-model="account.dob" label="Birthday date" prepend-icon="event" readonly />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-model="account.current_address"
          label="Current Address"
          prepend-icon="looks_one"
          readonly
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-model="account.permanent_address"
          label="Permanent Address"
          prepend-icon="looks_two"
          readonly
        />
      </v-flex>

      <v-flex xs12 md8 offset-md2>
        <form @submit.prevent="updateProfile()">
          <v-file-input
            v-if="!$page.auth.user.active"
            v-validate="'required|image'"
            :error-messages="errorMessages('images')"
            :class="{ 'error--text': hasErrors('images') }"
            prepend-icon="image"
            v-model="form.images"
            accept="image/*"
            chips
            multiple
            show-size
            label="Upload 1 Selfie, 1 Valid ID and Proof Of Address"
            data-vv-name="images"
          >
            <template v-slot:selection="{ text }">
              <v-chip small label color="primary">{{ text }}</v-chip>
            </template>
          </v-file-input>
          <v-card v-if="images.length >0">
            <v-container fluid>
              <v-row>
                <v-col v-for="(image,key) in images" :key="key" class="d-flex child-flex" cols="4">
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
          <v-btn
            v-if="!$page.auth.user.active"
            :loading="form.busy"
            :disabled="errors.any() || form.busy"
            type="submit"
            block
            color="secondary"
          >
            Submit Files
            <v-icon right>save</v-icon>
          </v-btn>
        </form>
      </v-flex>
    </v-card>
  </main-layout>
</template>
<script>
import MainLayout from "../../Layouts/MainLayout";
import validationError from "../../mixins/validation-error";
import { Form } from "vform";
import AppAlert from "../../partials/AppAlert";
import Acl from "../../mixins/acl";
import objectToFormData from "object-to-formdata";
export default {
  components: {
    AppAlert,
    MainLayout
  },
  props: {
    account: Object,
    kyc: Array
  },
  mixins: [validationError, Acl],
  data: () => ({
    form: new Form({
      images: null
    }),
    extensions: ["png", "jpeg", "jpg"],
    images: [],
    title: 'Submit KYC Requirements'
  }),
  created() {
    this.images = this.kyc;
    if(this.$page.auth.user.active){
      this.title = 'User KYC Verified'
    }
  },
  watch: {
    "form.images": {
      handler: function(val, oldVal) {
        let self = this;
        self.images = [];
        if (val) {
          var filesAmount = val.length;

          for (let i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
              self.images.push(event.target.result);
            };

            reader.readAsDataURL(val[i]);
          }
        }
      },
      deep: true
    }
  },
  methods: {
    updateProfile() {
      let self = this;
      self.$validator.validate().then(valid => {
        self.form.busy = true;
        if (valid) {
          self.$inertia
            .post(
              self.route("kyc.uploads").url(),
              objectToFormData(self.form),
              {
                replace: true,
                preserveState: true
              }
            )
            .then(() => {
              self.form.busy = false;
            });
        }
        self.form.busy = false;
      });
    }
  }
};
</script>;
