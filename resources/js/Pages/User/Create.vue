<template>
  <modal-layout class="white">
    <v-card :flat="true">
      <v-toolbar class="accent">
        <v-btn text icon color="white" @click.native="redirectBack()">
          <v-icon>arrow_back</v-icon>
        </v-btn>
        <v-spacer />
        <v-toolbar-title class="text-xs-center white--text">Create New User</v-toolbar-title>
        <v-spacer />
        <v-toolbar-items>
          <!-- If There is no User Account Login Yet Redirect to Authentication Page -->
          <v-btn
            :loading="form.busy"
            :disabled="errors.any() || form.busy"
            text
            color="white"
            @click.native="submit()"
          >
            Save
            <v-icon right>save</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-layout row wrap>
        <v-flex v-if="form.id != 1" class="xs12 offset-md2 md8">
          <v-autocomplete
            v-model="form.sp_id"
            v-validate="'required'"
            :items="sponsors"
            :error-messages="errorMessages('sponsor')"
            :class="{ 'error--text': hasErrors('sponsor') }"
            required
            item-text="name"
            item-value="id"
            color="blue-grey"
            label="Select Sponsor"
            light
            chips
            clearable
            deletable-chips
            prepend-icon="verified_user"
            data-vv-name="sponsor"
          />
        </v-flex>

        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field
            v-model="form.fname"
            v-validate="'required'"
            :error-messages="errorMessages('fname')"
            :class="{ 'error--text': hasErrors('fname') }"
            class="primary--text"
            name="fname"
            label="First Name"
            data-vv-name="fname"
            counter="255"
            prepend-icon="perm_identity"
          />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-text-field
            v-model="form.mname"
            class="primary--text"
            name="mname"
            label="Middle Name"
            counter="255"
            prepend-icon="person_pin"
          />
        </v-flex>
        <v-flex class="xs4 md2" px-2>
          <v-switch v-model="form.active" :label="getStatus(form.active)" />
        </v-flex>
        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field
            v-model="form.lname"
            v-validate="'required'"
            :error-messages="errorMessages('lname')"
            :class="{ 'error--text': hasErrors('lname') }"
            class="primary--text"
            name="lname"
            label="Last Name"
            data-vv-name="lname"
            counter="255"
            prepend-icon="supervisor_account"
          />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-text-field
            v-model="form.suffix"
            :error-messages="errorMessages('suffix')"
            :class="{ 'error--text': hasErrors('suffix') }"
            class="primary--text"
            name="suffix"
            label="Suffix"
            data-vv-name="suffix"
            counter="255"
            prepend-icon="perm_contact_calendar"
          />
        </v-flex>
        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field
            v-model="form.email"
            v-validate="{ email: true }"
            :error-messages="errorMessages('email')"
            :class="{ 'error--text': hasErrors('email') }"
            label="Email"
            prepend-icon="mail"
            data-vv-name="email"
          />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-text-field
            v-model="form.username"
            v-validate="'required|alpha_dash|min:6'"
            :error-messages="errorMessages('username')"
            :class="{ 'error--text': hasErrors('username') }"
            label="Username"
            prepend-icon="alternate_email"
            data-vv-name="username"
          />
        </v-flex>
        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field v-model="form.mobile_no" label="Mobile No." prepend-icon="phone" />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-menu
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
                v-model="form.dob"
                v-validate="'required'"
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
        <v-flex class="xs12 offset-md2 md8">
          <v-autocomplete
            v-model="form.roles"
            v-validate="'required'"
            :items="roles"
            :error-messages="errorMessages('roles')"
            :class="{ 'error--text': hasErrors('roles') }"
            required
            color="blue-grey"
            label="Select Account Type"
            light
            multiple
            chips
            clearable
            deletable-chips
            prepend-icon="fa-tags"
            data-vv-name="roles"
          />
        </v-flex>
        <v-flex v-if="showPaymasterDrownDown" class="xs12 offset-md2 md8">
          <v-autocomplete
            v-model="form.paymaster_id"
            :items="paymasters"
            required
            item-text="name"
            item-value="id"
            color="blue-grey"
            label="Select Paymaster"
            light
            chips
            clearable
            deletable-chips
            prepend-icon="verified_user"
          />
        </v-flex>
        <!-- <v-flex class="xs12 offset-md2 md8">
          <v-autocomplete
            :items="permissions"
            v-model="form.permissions"
            color="blue-grey"
            label="Select Permissions"
            light
            multiple
            chips
            clearable
            deletable-chips
            prepend-icon="fa-tags"
          />
        </v-flex>-->

        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field
            v-model="form.password"
            v-validate="'min:6|confirmed:password_confirmation'"
            :append-icon="icon"
            :type="!password_visible ? 'password' : 'text'"
            :error-messages="errorMessages('password')"
            :class="{ 'error--text': hasErrors('password') }"
            class="primary--text"
            name="password"
            label="Password"
            data-vv-name="password"
            prepend-icon="fa-key"
            counter="255"
            @click:append="() => (password_visible = !password_visible)"
          />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-text-field
            ref="password_confirmation"
            v-model="form.password_confirmation"
            :append-icon="icon"
            :type="!password_visible ? 'password' : 'text'"
            class="primary--text"
            name="password_confirmation"
            label="Confirm Password"
            prepend-icon="fa-copy"
            counter="255"
            @click:append="() => (password_visible = !password_visible)"
          />
        </v-flex>
        <v-flex xs12 md4 offset-md2 px-2>
          <v-text-field
            v-model="form.current_address"
            label="Current Address"
            prepend-icon="looks_one"
          />
        </v-flex>
        <v-flex xs12 md4 px-2>
          <v-text-field
            v-model="form.permanent_address"
            label="Permanent Address"
            prepend-icon="looks_two"
          />
        </v-flex>
        <v-flex xs12 md8 offset-md2>
          <v-btn
            :loading="form.busy"
            :disabled="errors.any() || form.busy"
            block
            color="accent"
            @click="submit()"
          >
            Save
            <v-icon right>save</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-card>
  </modal-layout>
</template>

<script>
import ModalLayout from "../../Layouts/ModalLayout";
import validationError from "../../mixins/validation-error";
import { Form } from "vform";
import swal from "sweetalert2";
export default {
  components: {
    ModalLayout,
  },
  mixins: [validationError],
  props: {
    roles: {
      type: [Array],
      required: true,
    },
    sponsors: {
      type: [Array],
      required: true,
    },
    paymasters: {
      type: [Array],
      required: true,
    },
    // permissions: {
    //   type: [Array],
    //   required: true
    // }
  },
  data: () => ({
    /* Always Declare Your Form Object */
    form: new Form({
      id: null,
      sp_id: null,
      paymaster_id: null,
      username: null,
      fname: null,
      mname: null,
      lname: null,
      suffix: null,
      dob: null,
      active: false,
      roles: [],
      // permissions: [],
      password: null,
      password_confirmation: null,
      email: null,
      mobile_no: null,
      current_address: null,
      permanent_address: null,
    }),
    menu: false,
    password_visible: false,
    showPaymasterDrownDown: false,
  }),
  computed: {
    icon() {
      return this.password_visible ? "visibility" : "visibility_off";
    },
  },
  // add watcher for sponsor , and roles
  watch: {
    menu(val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    "form.roles"(val) {
      if (val.length === 0) {
        this.showPaymasterDrownDown = false;
        this.form.paymaster_id = null;
      }
      if (val.includes("member")) {
        this.showPaymasterDrownDown = true;
      } else {
        this.showPaymasterDrownDown = false;
        this.form.paymaster_id = null;
      }
    },
  },
  methods: {
    save(date) {
      this.$refs.menu.save(date);
    },
    getStatus(status) {
      if (status) {
        return "Status: Active";
      } else {
        return "Status: Inactive";
      }
    },
    submit() {
      let self = this;
      this.$validator.validateAll().then(result => {
        if (result) {
          // eslint-disable-next-line
          self.createUser();
        } else {
          const validationModal = swal.mixin({
            confirmButtonClass: "v-btn blue-grey  subheading white--text",
            buttonsStyling: false,
          });
          validationModal({
            title: "Validation Error",
            html: "<p class=\"title\">Please Fix Form Errors</p>",
            type: "warning",
            confirmButtonText: "Back",
          });
        }
      });
    },
    createUser() {
      let self = this;
      self.form.busy = true;
      self.$inertia
        .post(this.route("users.store").url(), self.form)
        .then(() => {
          self.form.busy = false;
        });
    },
    redirectBack() {
      let self = this;
      self.$nextTick(() => self.$inertia.visit(this.route("users.index").url()));
    },
  },
};
</script>
