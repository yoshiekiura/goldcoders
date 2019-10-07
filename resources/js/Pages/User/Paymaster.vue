<template>
  <main-layout :title="`PAYMASTER PORTAL: ${paymaster.name.toUpperCase()} - MEMBERS MANAGEMENT`">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-pagination
        v-if="users.meta.visible"
        v-model="form.page"
        :length="users.meta.total_pages"
        :total-visible="10"
      />
      <v-text-field
        v-model.number="form.per_page"
        label="Items per page"
        type="number"
        min="-1"
        max="15"
      ></v-text-field>
      <v-card-title>
        <div class="flex-grow-1"></div>

        <v-btn color="accent" dark @click="createUser">
          Add New Member
          <v-icon right>person_add</v-icon>
        </v-btn>
      </v-card-title>
      <v-data-table
        v-model="selected"
        :headers="headers"
        :items="users.data"
        light
        item-key="id"
        :page.sync="form.page"
        show-expand
        :expanded.sync="expanded"
        :server-items-length="users.meta.total_pages"
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
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="search"
              label="Search User"
              clearable
            ></v-text-field>
            <div class="flex-grow-1"></div>
            <v-text-field
              v-model="form.sponsor"
              clearable
              flat
              solo-inverted
              label="Search Sponsor"
              hide-details
            ></v-text-field>

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
            <template v-if="can('approve_payment')">
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
            :disabled="!can('approve_payment')"
            color="green darken-4"
            :label="getStatus(item.active)"
            v-model="item.active"
            @change="toggleStatus(item)"
          />
        </template>
        <template v-slot:item.action="{item}">
          <v-btn text icon color="blue" class="compress--icon" @click="editUser(item)">
            <v-icon>edit</v-icon>
          </v-btn>
          <v-btn text icon color="error" class="compress--icon" @click="openDialog(item)">
            <v-icon>fa-trash</v-icon>
          </v-btn>
          <v-btn
            v-if="hasPendingPayments(item)"
            text
            icon
            color="blue"
            class="compress--icon"
            @click="viewUser(item)"
          >
            <v-badge>
              <template v-slot:badge>0</template>
              <v-icon>fa-money</v-icon>
            </v-badge>
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
import { Form } from "vform";
import validationError from "../../mixins/validation-error";
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
    paymaster: {
      type: Object,
      default: null
    },
    filters: Object
  },
  mixins: [Acl, validationError, confirmation],
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
          text: "Status",
          value: "active",
          sortable: true
        },
        { text: "Actions", value: "action", sortable: false }
      ];
    }
  },
  data: () => ({
    expanded: [],
    selected: [],
    sortBy: [],
    sortDesc: [false, true],
    form: {
      search: "",
      sponsor: "",
      status: "",
      page: 1,
      per_page: 10,
      status: ""
    },
    statuses: ["active", "inactive"],
    toggleForm: new Form({
      user_id: null
    }),
    deleteUserForm: new Form({
      user_id: null
    }),
    togglestatus: false
  }),
  remember: {
    data: ["form"]
  },
  created() {
    let self = this;
    self.form.search = self.filters.search;
    self.form.sponsor = self.filters.sponsor;
    self.form.status = self.filters.status;
    self.form.page = parseInt(self.users.meta.page);
    self.form.per_page = parseInt(self.users.meta.per_page);
    self.debouncedGetUsers = _.debounce(self.fetchUsers, 50);
  },
  mounted() {
    let self = this;
    // listen on mail event
    Bus.$on("send-mass-mail", form => {
      self.massMail(form);
    });
  },
  methods: {
    editUser(user) {
      this.$inertia.visit(route("users.edit", { user: user.id }).url());
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
    viewMassMailModal() {
      Bus.$emit("open-modal-mass-mail", this.selected);
    },
    createUser() {
      this.$inertia.visit(route("users.create").url());
    },
    hasPendingPayments(item) {
      return true;
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
    fetchUsers() {
      let query = _.pickBy(this.form);
      let url = this.route(
        "paymaster.index",
        Object.keys(query).length ? query : { remember: "forget" }
      ).url();
      this.$inertia.replace(url);
    },
    getStatus(status) {
      if (status) {
        return "Active";
      } else {
        return "Inactive";
      }
    },
    viewUser(user) {
      this.$inertia.replace(route("paymaster.viewUser", { user }).url());
    }
  },
  watch: {
    "form.search"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.status"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.per_page"() {
      this.form.page = 1;
      this.debouncedGetUsers();
    },
    "form.page"(newVal) {
      if (this.form.page !== 1) {
        this.debouncedGetUsers();
      }
    },
    "form.sponsor"() {
      this.form.page = 1;
      this.debouncedGetUsers();
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