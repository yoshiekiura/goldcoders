
<template>
  <main-layout title="My Profile">
    <v-card flat class="grey lighten-5">
      <v-flex xs12 md8 offset-md2 text-xs-center>
        <app-alert></app-alert>
      </v-flex>

      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="'required|alpha_dash|min:6'"
          v-model="form.username"
          :error-messages="errorMessages('username')"
          :class="{ 'error--text': hasErrors('username') }"
          label="Username"
          prepend-icon=" fa-at"
          data-vv-name="username"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="{ email: true }"
          v-model="form.email"
          :error-messages="errorMessages('email')"
          :class="{ 'error--text': hasErrors('email') }"
          label="Email"
          prepend-icon=" mail"
          data-vv-name="email"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          :readonly="$page.auth.user.active"
          v-validate="{ required: true, regex: /^[a-zA-Z0-9 ]+$/ }"
          v-model="form.fname"
          :error-messages="errorMessages('fname')"
          :class="{ 'error--text': hasErrors('fname') }"
          label="First Name"
          prepend-icon="perm_identity"
          data-vv-name="fname"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          :readonly="$page.auth.user.active"
          v-model="form.mname"
          :error-messages="errorMessages('mname')"
          :class="{ 'error--text': hasErrors('mname') }"
          label="Middle Name"
          prepend-icon="person_pin"
          data-vv-name="mname"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          :readonly="$page.auth.user.active"
          v-validate="{ required: true, regex: /^[a-zA-Z0-9 ]+$/ }"
          v-model="form.lname"
          :error-messages="errorMessages('lname')"
          :class="{ 'error--text': hasErrors('lname') }"
          label="Last Name"
          prepend-icon="supervisor_account"
          data-vv-name="lname"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          :readonly="$page.auth.user.active"
          v-model="form.suffix"
          :error-messages="errorMessages('suffix')"
          :class="{ 'error--text': hasErrors('suffix') }"
          label="Suffix"
          prepend-icon="perm_contact_calendar"
          data-vv-name="suffix"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-menu
          :disabled="$page.auth.user.active"
          ref="menu"
          v-model="menu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-text-field
              v-validate="'required'"
              v-model="form.dob"
              :error-messages="errorMessages('dob')"
              :class="{ 'error--text': hasErrors('dob') }"
              label="Birthday date"
              prepend-icon="event"
              readonly
              data-vv-name="dob"
              v-on="on"
            />
          </template>
          <v-date-picker
            ref="picker"
            v-model="form.dob"
            :max="new Date().toISOString().substr(0, 10)"
            min="1900-01-01"
            @change="save"
          />
        </v-menu>
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="{ required: false }"
          v-model="form.mobile_no"
          :error-messages="errorMessages('mobile_no')"
          :class="{ 'error--text': hasErrors('mobile_no') }"
          label="Mobile No."
          prepend-icon="phone"
          data-vv-name="mobile_no"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="{ required: false }"
          v-model="form.current_address"
          :error-messages="errorMessages('current_address')"
          :class="{ 'error--text': hasErrors('current_address') }"
          label="Current Address"
          prepend-icon="looks_one"
          data-vv-name="current_address"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          :readonly="$page.auth.user.active"
          v-validate="{ required: false }"
          v-model="form.permanent_address"
          :error-messages="errorMessages('permanent_address')"
          :class="{ 'error--text': hasErrors('permanent_address') }"
          label="Permanent Address"
          prepend-icon="looks_two"
          data-vv-name="permanent_address"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="{ min: 6,regex: /^([a-zA-Z0-9@*#]{6,15})$/ }"
          v-model="form.old_password"
          :append-icon="icon"
          :type="!password_visible ? 'password' : 'text'"
          :error-messages="errorMessages('old_password')"
          :class="{ 'error--text': hasErrors('old_password') }"
          label="Current Password"
          prepend-icon="fa-hashtag"
          data-vv-name="old_password"
          @click:append="() => (password_visible = !password_visible)"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="'min:6'"
          ref="password"
          v-model="form.password"
          :append-icon="icon"
          :type="!password_visible ? 'password' : 'text'"
          :error-messages="errorMessages('password')"
          :class="{ 'error--text': hasErrors('password') }"
          label="New Password"
          name="password"
          prepend-icon="fiber_new"
          data-vv-name="password"
          @click:append="() => (password_visible = !password_visible)"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-text-field
          v-validate="'min:6|confirmed:password'"
          :append-icon="icon"
          :type="!password_visible ? 'password' : 'text'"
          v-model="form.password_confirmation"
          :error-messages="errorMessages('password_confirmation')"
          :class="{ 'error--text': hasErrors('password_confirmation') }"
          label="Confirm New Password"
          prepend-icon="done_all"
          data-vv-name="password_confirmation"
          @click:append="() => (password_visible = !password_visible)"
        />
      </v-flex>
      <v-flex xs12 md8 offset-md2>
        <v-btn
          :loading="form.busy"
          :disabled="errors.any() || form.busy"
          block
          color="accent"
          @click="updateProfile"
        >
          Save
          <v-icon right>save</v-icon>
        </v-btn>
      </v-flex>
    </v-card>
  </main-layout>
</template>

<script>
import MainLayout from "../Layouts/MainLayout";
import Acl from "../mixins/acl";
import validationError from "../mixins/validation-error";
import { Form } from "vform";
import AppAlert from "../partials/AppAlert";

export default {
  components: {
    MainLayout,
    AppAlert
  },
  props: {
    account: Object
  },
  mixins: [validationError, Acl],
  data: () => ({
    form: new Form({
      fname: "",
      lname: "",
      mname: "",
      username: "",
      email: "",
      current_address: "",
      permanent_address: "",
      suffix: null,
      dob: null,
      mobile_no: "",
      old_password: "",
      password: "",
      password_confirmation: ""
    }),
    password_visible: false,
    menu: false
  }),
  computed: {
    icon() {
      return this.password_visible ? "visibility" : "visibility_off";
    }
  },
  watch: {
    menu(val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    "$page.flash.success"() {
      this.resetPass();
    }
  },
  mounted() {
    let self = this;
    self.form.fname = self.account.fname;
    self.form.lname = self.account.lname;
    self.form.mname = self.account.mname;
    self.form.username = self.account.username;
    self.form.email = self.account.email;
    self.form.current_address = self.account.current_address;
    self.form.permanent_address = self.account.permanent_address;
    self.form.suffix = self.account.suffix;
    self.form.dob = self.account.dob;
    self.form.mobile_no = self.account.mobile_no;
  },
  methods: {
    save(date) {
      this.$refs.menu.save(date);
    },
    resetPass() {
      let self = this;
      self.form.old_password = "";
      self.form.password = "";
      self.form.password_confirmation = "";
    },
    updateProfile() {
      let self = this;
      self.$validator.validate().then(valid => {
        self.form.busy = true;
        if (valid) {
          if (self.form.old_password === "") {
            delete self.form.old_password;
          }
          if (self.form.password === "") {
            delete self.form.password;
          }
          if (self.form.password_confirmation === "") {
            delete self.form.password_confirmation;
          }
          self.$inertia.post(self.route("profile.update").url(), self.form, {
            replace: true,
            preserveState: true
          });
        }
        self.form.busy = false;
      });
    },
    toProperCase(key) {
      let newStr = key.replace(/_/g, " ");
      return newStr.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
      });
    }
  }
};
</script>

<style>
</style>
