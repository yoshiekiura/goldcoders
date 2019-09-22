<template>
  <main-layout title="User Management">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-pagination
        v-if="$page.users.links.length  !== 3"
        v-model="page"
        :length="parseInt($page.users.links.length - 2)"
      />
      <v-text-field
        v-model.number="per_page"
        label="Items per page"
        type="number"
        min="-1"
        max="15"
      ></v-text-field>
      <v-card-title>
        <div class="flex-grow-1"></div>

        <v-btn color="accent" dark @click="createUser">
          Create New User
          <v-icon right>person_add</v-icon>
        </v-btn>
      </v-card-title>
      <v-data-table
        v-model="selected"
        :headers="headers"
        :items="users.data"
        light
        item-key="id"
        show-expand
        :page.sync="page"
        :expanded.sync="expanded"
        :server-items-length="parseInt($page.users.links.length -2)"
        :items-per-page="-1"
        hide-default-footer
        :sort-by="sortBy"
        show-select
        :sort-desc="sortDesc"
        multi-sort
        class="elevation-1"
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-toolbar dark color="blue-grey darken-4" class="mb-1">
            <v-text-field
              v-model="form.search"
              clearable
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="search"
              label="Search User"
              @click:append="reset()"
              append-icon="refresh"
            ></v-text-field>
            <div class="flex-grow-1"></div>
            <v-text-field
              v-model="form.sponsor"
              clearable
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="person"
              label="Search Sponsor"
              @click:append="reset()"
              append-icon="refresh"
            ></v-text-field>

            <div class="flex-grow-1"></div>
            <v-select
              v-model="form.role"
              :items="roles"
              label="Filter Roles"
              clearable
              hide-details
              solo-inverted
              prepend-inner-icon="group"
              flat
            ></v-select>
            <div class="flex-grow-1"></div>
            <v-select
              v-model="form.status"
              :items="statuses"
              label="Filter Status"
              clearable
              hide-details
              solo-inverted
              prepend-inner-icon="group"
              flat
            ></v-select>
            <template v-if="can('manage_users')">
              <div class="flex-grow-1"></div>

              <v-btn :disabled="selected.length<1" icon text @click="massDeactivate">
                <v-icon color="amber">block</v-icon>
              </v-btn>
              <v-btn :disabled="selected.length<1" icon text @click="massActivate">
                <v-icon color="green">how_to_reg</v-icon>
              </v-btn>
              <v-btn :disabled="selected.length<1" icon text @click="viewMassMailModal">
                <v-icon color="yellow darken-1">mail</v-icon>
              </v-btn>
              <v-btn :disabled="selected.length<1" icon text @click="openMassDialog()">
                <v-icon color="red">delete_outline</v-icon>
              </v-btn>
            </template>
          </v-toolbar>
        </template>
        <!-- Table Rows -->
        <template v-slot:item.name="{ item }">{{ item.name.toUpperCase() }}</template>
        <template v-slot:item.sponsor="{ item }">
          <span v-if="item.sponsor">{{ item.sponsor.toUpperCase() }}</span>
        </template>
        <template v-slot:item.active="{ item }">
          <v-switch
            :disabled="!can('manage_users')"
            color="green darken-4"
            :label="getStatus(item.active)"
            v-model="item.active"
            @change="toggleStatus(item)"
          />
        </template>
        <template v-slot:item.roles="{ item }">
          <v-chip v-for="(role,key) in item.roles" :key="key" color="blue-grey darken-4">
            <v-avatar
              left
              :class="{
                    'amber lighten-2': (role === 'admin'),
                    'blue lighten-2': (role === 'paymaster'),
                    'lime lighten-2': (role === 'member')
                  }"
            >
              <span class="headline white--text">{{ role.charAt(0).toUpperCase() }}</span>
            </v-avatar>
            <span
              :class="{
                    'amber--text text--lighten-2': (role === 'admin'),
                    'blue--text text--lighten-2': (role === 'paymaster'),
                    'lime--text text--lighten-2': (role === 'member')
                  }"
            >{{ role.toUpperCase() }}</span>
          </v-chip>
        </template>
        <template v-if="can('manage_users')" v-slot:item.action="{item}">
          <v-btn text icon color="blue" class="compress--icon" @click="editUser(item)">
            <v-icon>edit</v-icon>
          </v-btn>
          <v-btn text icon color="error" class="compress--icon" @click="openDialog(item)">
            <v-icon>fa-trash</v-icon>
          </v-btn>
        </template>

        <template v-slot:expanded-item="props">
          <td colspan="12" fluid pa-0 ma-0>
            <v-card light text text-xs-center>
              <v-img class="white--text blue-grey" height="75px">
                <v-container fill-height fluid>
                  <v-layout fill-height>
                    <v-flex xs12 align-end flexbox>
                      <v-avatar text-xs-left>
                        <img :src="props.item.avatar" :alt="props.item.name" />
                      </v-avatar>
                      <span class="headline">{{ props.item.name }}</span>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-img>
              <v-card-title>
                <v-container fluid>
                  <p
                    v-if="props.item.sponsor"
                    class="title accent--text"
                  >Sponsor: {{ props.item.sponsor }}</p>

                  <p class="title accent--text">Account Details</p>
                  <v-layout row wrap>
                    <v-flex xs6 px-1>
                      <v-text-field
                        v-model="props.item.username"
                        label="Username"
                        prepend-icon="fa-at"
                        light
                        readonly
                      />
                    </v-flex>
                    <v-flex xs6 px-1>
                      <v-text-field
                        v-model="props.item.email"
                        label="Email"
                        prepend-icon="fa-envelope"
                        light
                        readonly
                      />
                    </v-flex>
                    <v-flex xs6 px-1>
                      <v-text-field
                        :value="props.item.current_address"
                        label="Current Address"
                        light
                        readonly
                        prepend-icon="looks_one"
                      />
                    </v-flex>
                    <v-flex xs6 px-1>
                      <v-text-field
                        :value="props.item.permanent_address"
                        label="Permanent Address"
                        light
                        readonly
                        prepend-icon="looks_two"
                      />
                    </v-flex>
                    <v-flex xs6 px-1>
                      <v-text-field
                        v-model="props.item.mobile_no"
                        label="Phone"
                        light
                        readonly
                        prepend-icon="phone"
                      />
                    </v-flex>
                    <v-flex xs6 px-1>
                      <v-text-field
                        :value="props.item.dob"
                        label="Date Of Birth"
                        light
                        readonly
                        prepend-icon="cake"
                      />
                    </v-flex>
                    <v-flex xs6>
                      <v-switch
                        v-model="props.item.active"
                        :label="getStatus(props.item.active)"
                        readonly
                      />
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-title>
            </v-card>
          </td>
        </template>
      </v-data-table>
      <confirm name="item" :callback="confirmed(deleteUser)" />
      <massConfirm name="mass" :callback="confirmed(massDelete)" />
      <mass-mail />
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
import Confirm from "../../Shared/Confirm";
import MassMail from "../../Shared/MassMail";
import Acl from "../../mixins/acl";
import validationError from "../../mixins/validation-error";
import { Form } from "vform";
import swal from "sweetalert2";
import confirmation from "../../mixins/confirmation";
import MassConfirm from "../../Shared/MassConfirm";

export default {
  components: {
    MainLayout,
    Confirm,
    MassMail,
    MassConfirm
  },
  // from backend
  props: {
    users: Object,
    status: Boolean,
    filters: Object
  },
  mixins: [Acl, validationError, confirmation],
  data: () => ({
    dialog: false,
    expanded: [],
    // server side
    selected: [],
    toggleForm: new Form({
      user_id: null
    }),
    roles: [],
    deleteUserForm: new Form({
      user_id: null
    }),
    togglestatus: false,
    sortBy: [],
    sortDesc: [false, true],
    form: {
      search: "",
      sortBy: "",
      orderBy: "",
      sponsor: "",
      active: "",
      role: ""
    },
    statuses: ["active", "inactive"],
    page: 1,
    per_page: 10
  }),
  computed: {
    headers() {
      return [
        {
          text: "Member",
          align: "left",
          sortable: true,
          value: "name"
        },
        {
          text: "Sponsor",
          value: "sponsor",
          sortable: true
        },
        {
          text: "Roles",
          value: "roles",
          sortable: true
        },
        {
          text: "Status",
          value: "active",
          sortable: true
        },
        { text: "Actions", value: "action", sortable: false }
      ];
    }
  },
  created() {
    let self = this;
    self.form.search = self.filters.search;
    self.form.orderBy = self.filters.orderBy;
    self.form.sortBy = self.filters.sortBy;
    self.form.role = self.filters.role;
    self.form.active = self.filters.active;
    self.form.sponsor = self.filters.sponsor;
    self.roles = self.$page.roles;
  },
  mounted() {
    let self = this;
    // listen on mail event
    Bus.$on("send-mass-mail", form => {
      self.massMail(form);
    });
  },
  methods: {
    setQueryString(query, val) {
      let self = this;

      let url = new URL(window.location.href);

      let qs = url.search;

      let sp = new URLSearchParams(qs);

      sp.delete(query);

      sp.append(query, val);

      url.search = sp.toString();

      let new_url = url.toString();

      self.$inertia.replace(new_url);
    },
    reset() {
      this.form = _.mapValues(this.form, () => null);
    },
    viewMassMailModal() {
      Bus.$emit("open-modal-mass-mail", this.selected);
    },
    massDelete() {
      let self = this;

      let selected = _.map(self.selected, "id");
      let massDeleteForm = new Form({
        selected
      });

      self.$inertia.post(route("users.massDelete").url(), massDeleteForm);

      swal.fire({
        title: "<strong>Success!</u></strong>",
        type: "success",
        html: " <b>Selected Users Deleted!</b>",
        focusConfirm: true,
        confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
        confirmButtonAriaLabel: "Back!"
      });
    },
    massMail(form) {
      let self = this;
      form
        .post(route("users.massMail").url())
        .then(response => {
          swal.fire({
            title: "<strong>Success!</u></strong>",
            type: "success",
            html: "<b>" + response.data.message + "</b>",
            focusConfirm: true,
            confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
            confirmButtonAriaLabel: "Back!"
          });
          self.selected = [];
          Bus.$emit("close-modal-mass-mail");
        })
        .catch(errors => {
          console.log(errors);
          if (errors.response.data.message) {
            swal.fire({
              title: "<strong>Success!</u></strong>",
              type: "success",
              html: "<b>" + response.data.message + "</b>",
              focusConfirm: true,
              confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
              confirmButtonAriaLabel: "Back!"
            });
          }
          self.selected = [];
          Bus.$emit("close-modal-mass-mail");
        });
    },
    editUser(user) {
      this.$inertia.visit(route("users.edit", { user: user.id }).url());
    },
    toggleStatus(user) {
      let self = this;
      self.toggleForm.user_id = user.id;
      let index = _.findIndex(self.users.data, { id: user.id });
      self.$inertia.post(route("users.toggleStatus").url(), self.toggleForm);
      swal.fire({
        title: "<strong>Success!</u></strong>",
        type: "success",
        html: " <b>User Status Toggled!</b>",
        focusConfirm: true,
        confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
        confirmButtonAriaLabel: "Back!"
      });
    },
    getStatus(status) {
      if (status) {
        return "Active";
      } else {
        return "Inactive";
      }
    },
    createUser() {
      this.$inertia.visit(route("users.create").url());
    },
    async massDeactivate() {
      let self = this;
      let selected = _.map(self.selected, "id");
      let toggleStatusForm = new Form({
        selected
      });

      self.$inertia.post(route("users.massDeactivate").url(), toggleStatusForm);

      swal.fire({
        title: "<strong>Success!</u></strong>",
        type: "success",
        html: " <b>Selected Users Deactivated!</b>",
        focusConfirm: true,
        confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
        confirmButtonAriaLabel: "Back!"
      });
    },
    async massActivate() {
      let self = this;
      let selected = _.map(self.selected, "id");
      let toggleStatusForm = new Form({
        selected
      });

      self.$inertia.post(route("users.massActivate").url(), toggleStatusForm);
      swal.fire({
        title: "<strong>Success!</u></strong>",
        type: "success",
        html: " <b>Selected Users Activated!</b>",
        focusConfirm: true,
        confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
        confirmButtonAriaLabel: "Back!"
      });
    },
    deleteUser(user) {
      let self = this;
      self.deleteUserForm.user_id = user.id;

      self.$inertia.post(
        route("users.destroy", { user: user.id }).url(),
        self.deleteUserForm
      );
      swal.fire({
        title: "<strong>Success!</u></strong>",
        type: "success",
        html: " <b>Selected Users Activated!</b>",
        focusConfirm: true,
        confirmButtonText: '<i class="fa fa-arrow-left"></i> Back!',
        confirmButtonAriaLabel: "Back!"
      });
    },
    toProperCase(key) {
      let newStr = key.replace(/_/g, " ");
      return newStr.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
      });
    }
  },
  watch: {
    status(newValue) {
      this.togglestatus = newValue;
    },
    form: {
      handler: _.throttle(function() {
        this.page = 1;
        this.per_page = 10;
        let query = _.pickBy(this.form);
        let url = this.route(
          "users.index",
          Object.keys(query).length ? query : { remember: "forget" }
        ).url();
        this.$inertia.replace(url);
      }, 150),
      deep: true
    },
    page: {
      handler(newVal) {
        this.setQueryString("page", newVal);
      }
    },
    per_page: {
      handler(newVal) {
        this.setQueryString("per_page", newVal);
      }
    }
  }
};
</script>
<style scoped>
.compress--icon {
  margin-left: -5px;
  margin-right: -5px;
}
</style>
