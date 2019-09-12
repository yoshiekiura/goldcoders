<template>
  <modal-layout class="white" title="Login">
    <v-card :flat="true" color="grey lighten-5">
      <v-toolbar class="accent">
        <v-spacer />
        <v-toolbar-title class="text-xs-center white--text">Welcome to Login Page</v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-card-text style="padding-top:150px;">
        <v-container fluid>
          <form @submit.prevent="login()">
            <v-layout row>
              <v-flex xs12 sm12 md4 offset-md4 lg4 offset-lg4 xl4 offset-xl4>
                <v-text-field
                  v-model="form.email"
                  v-validate="'required|email'"
                  :error-messages="errorMessages('email')"
                  :class="{ 'error--text': hasErrors('email') }"
                  class="primary--text"
                  name="username"
                  label="Type Your Account Email"
                  data-vv-name="email"
                  prepend-icon="email"
                  counter="255"
                />
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs12 sm12 md4 offset-md4 lg4 offset-lg4 xl4 offset-xl4>
                <v-text-field
                  v-model="form.password"
                  v-validate="'required|min:8'"
                  :append-icon="icon"
                  :type="!password_visible ? 'password' : 'text'"
                  :error-messages="errorMessages('password')"
                  :class="{ 'error--text': hasErrors('password') }"
                  class="primary--text"
                  name="password"
                  label="Enter your password"
                  hint="At least 8 characters"
                  data-vv-name="password"
                  counter="255"
                  prepend-icon="fa-key"
                  @click:append="() => (password_visible = !password_visible)"
                />
              </v-flex>
            </v-layout>
            <v-flex xs12 sm12 md4 offset-md4 lg4 offset-lg4 xl4 offset-xl4 text-xs-center>
              <v-btn
                :loading="form.busy"
                :disabled="errors.any()"
                block
                type="submit"
                color="accent"
              >
                Log In
                <v-icon right colo="primary">fa-sign-in</v-icon>
              </v-btn>
            </v-flex>
          </form>
        </v-container>
      </v-card-text>
    </v-card>
    <app-footer></app-footer>
  </modal-layout>
</template>

<script>
import Form from "vform";
import ModalLayout from "../Layouts/ModalLayout";
import validationError from "../mixins/validation-error";
import AppFooter from "../partials/ModalFooter";
export default {
  components: {
    Form,
    ModalLayout,
    AppFooter
  },
  mixins: [validationError],
  data: () => ({
    form: new Form({
      username: "",
      email: "",
      password: "",
      remember: null
    }),
    password_visible: false,
    drawer: null
  }),
  computed: {
    icon() {
      return this.password_visible ? "visibility" : "visibility_off";
    }
  },
  methods: {
    login() {
      let self = this;
      self.$validator.validateAll();
      if (!self.errors.any()) {
        self.$inertia.post(this.route("login.attempt").url(), self.form);
      }
    },
  }
};
</script>

<style lang="scss">
</style>
