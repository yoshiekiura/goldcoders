<template>
  <main-layout title="User Management">
    <v-container fluid>
      <!-- User Main Detail -->
      <v-card-title>
        <div class="flex-grow-1"></div>
        <v-btn color="accent" dark @click="createUser">
          Create New User
          <v-icon right>person_add</v-icon>
        </v-btn>
      </v-card-title>
      <v-data-table
        v-model="selected"
        :loading="loading"
        :headers="headers"
        :items="items"
        :search="search"
        light
        item-key="id"
        show-expand
        :expanded.sync="expanded"
        show-select
        :sort-by="sortBy"
        :sort-desc="sortDesc"
        :items-per-page="5"
        multi-sort
        class="elevation-1"
        :footer-props="{
      showFirstLastPage: true,
      firstIcon: 'mdi-arrow-collapse-left',
      lastIcon: 'mdi-arrow-collapse-right',
      prevIcon: 'mdi-minus',
      nextIcon: 'mdi-plus'
    }"
      >
        <!-- toolbar search -->
        <template v-slot:top>
          <v-toolbar dark color="blue-grey darken-4" class="mb-1">
            <v-text-field
              v-model="search"
              clearable1
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="search"
              label="Filter By Name"
            ></v-text-field>
            <div class="flex-grow-1"></div>
            <v-text-field
              v-model="filterSponsor"
              clearable1
              flat
              solo-inverted
              hide-details
              prepend-inner-icon="fa-user"
              label="Filter By Sponsor"
            ></v-text-field>
            <div class="flex-grow-1"></div>

            <v-select
              label="Filter By Roles"
              flat
              hide-details
              small
              multiple
              clearable
              :items="roles"
              v-model="filterRole"
            ></v-select>
            <div class="flex-grow-1"></div>

            <v-select
              label="Filter By Status"
              flat
              hide-details
              small
              clearable
              :items="statuses"
              v-model="filterStatus"
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
        <template v-slot:item.name="{ item }">{{ item.name.toUpperCase() }}</template>
        <template v-slot:item.sponsor="{ item }">
          <span v-if="item.sponsor">{{ item.sponsor.toUpperCase() }}</span>
        </template>
        <template v-slot:item.active="{ item }">
          <v-switch
            color="green darken-4"
            :label="getStatus(item.active)"
            v-model="item.active"
            @change="toggleStatus(item)"
          />
        </template>
        <template v-slot:item.roles="{ item }">
          <v-chip v-if="item.id === 1" color="blue-grey darken-4">
            <v-avatar
              left
              :class="{
                    'primary': true,
                    'white--text': true,
                  }"
            >S</v-avatar>
            <span class="white--text">Super Admin</span>
          </v-chip>
          <v-chip v-for="(role,key) in item.roles" :key="key" color="blue-grey darken-4">
            <v-avatar
              left
              :class="{
                    'amber lighten-2': (role === 'admin'),
                    'white--text': true,
                    'blue lighten-2': (role === 'paymaster'),
                    'lime lighten-2': (role === 'member')
                  }"
            >
              <span class="headline white--text">{{ role.charAt(0).toUpperCase() }}</span>
            </v-avatar>
            <span class="white--text">{{ role }}</span>
          </v-chip>
        </template>
        <template v-slot:item.action="{item}">
          <v-btn text icon color="blue" class="compress--icon" @click="editUser(item)">
            <v-icon>edit</v-icon>
          </v-btn>
          <v-btn text icon color="green" class="compress--icon" @click="viewSubscriptions(item)">
            <v-icon>attach_money</v-icon>
          </v-btn>
          <v-btn text icon color="indigo" class="compress--icon" @click="viewReferrals(item)">
            <v-icon>fa-users</v-icon>
          </v-btn>
          <v-btn
            :disabled="!can('manage_users')"
            text
            icon
            color="error"
            class="compress--icon"
            @click="openDialog(item)"
          >
            <v-icon>fa-trash</v-icon>
          </v-btn>
        </template>

        <template
          slot="pageText"
          slot-scope="{ pageStart, pageStop }"
        >From {{ pageStart }} to {{ pageStop }}</template>

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
                  <v-layout row wrap>
                    <v-flex xs12>
                      <p class="title accent--text">Active Subscription</p>
                    </v-flex>
                    <v-flex v-if="props.item.subscriptions.length >0" xs12>
                      <v-chip
                        v-for="subscription in props.item.subscriptions"
                        :key="subscription.id"
                      >
                        <v-avatar class="primary white--text">
                          <span class="headline">{{ getRank(subscription).charAt(0).toUpperCase() }}</span>
                        </v-avatar>
                        {{ getSubscriptionName(subscription) }}
                      </v-chip>
                    </v-flex>
                    <v-flex v-else xs12>NO ACTIVE SUBSCRIPTION YET</v-flex>
                  </v-layout>
                </v-container>
              </v-card-title>
            </v-card>
          </td>
        </template>
      </v-data-table>
      <confirm name="item" :callback="confirmed(deleteUser)" />
      <massConfirm name="mass" :callback="confirmed(massDelete)"/>
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
    status: Boolean
  },
  mixins: [Acl, validationError, confirmation],
  data: () => ({
    contentClass: { grey: true, "lighten-4": true, "accent--text": true },
    dialog: false,
    expanded: [],

    // server side
    filters: [
      { text: "Filter By Name", value: "name" },
      { text: "Filter By Role", value: "role" },
      { text: "Filter by Status", value: "active" },
      { text: "Filter By Sponsor", value: "sponsor" }
    ],
    // server side
    orderByData: "ASC",
    orderColor: "teal",
    items: [],
    total_items: 0,
    selected: [],
    pagination: {
      descending: false,
      sortBy: "name",
      rowsPerPage: 50,
      page: 1
    },
    rows_per_page_items: [5, 10, 25, 50],
    current_user: {},
    usersForm: new Form({}),
    toggleForm: new Form({
      user_id: null
    }),
    search: "",
    roles: [],
    permissions: [],
    rolesForm: new Form({
      roles: []
    }),
    permissionsForm: new Form({
      permissions: []
    }),
    deleteUserForm: new Form({
      user_id: null
    }),
    meta: {
      current_page: 1,
      last_page: 1,
      per_page: 50
    },
    page: 1,
    togglestatus: false,
    loading: false,
    sortBy: ["name", "sponsor", "roles", "active"],
    sortByValue: "name",
    sortDesc: [false, true],
    filterRole: [],
    filterStatus: "",
    filterSponsor: "",
    statuses: ["active", "inactive"]
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
          sortable: true,
          filter: value => {
            if (!this.filterSponsor) return true;
            if (value) {
              return (
                this.filterSponsor.toLowerCase().trim() ===
                value.toLowerCase().trim()
              );
            }
          }
        },
        {
          text: "Roles",
          value: "roles",
          sortable: true,
          filter: value => {
            if (this.filterRole.length <= 0) return true;

            if (this.filterRole.length === 1) {
              return this.filterRole.some(r => value.indexOf(r) >= 0);
            } else {
              return _.isEqual(this.filterRole.sort(), value);
            }
          }
        },
        {
          text: "Status",
          value: "active",
          sortable: true,
          filter: value => {
            let status = false;
            let active = ["active"];
            let inactive = ["inactive"];
            if (active.includes(this.filterStatus)) {
              status = true;
            }
            if (inactive.includes(this.filterStatus)) {
              status = false;
            }
            if (!this.filterStatus) return true;

            return status === value;
          }
        },
        { text: "Actions", value: "action", sortable: false }
      ];
    }
  },
  mounted() {
    let self = this;
    self.items = self.users.data;
    self.roles = self.$page.roles;
    self.permissions = self.$page.permissions;

    Bus.$on("send-mass-mail", form => {
      self.massMail(form);
    });
  },
  methods: {
    getRank(subscription) {
      let rank = "";
      switch (subscription.rank) {
        case "1ex":
          rank = "Executive";
          break;
        case "1br":
          rank = "Bronze";
          break;
        case "1sl":
          rank = "Silver";
          break;
        case "1gd":
          rank = "Gold";
          break;
        case "1gd":
          rank = "Gold";
          break;
        case "1dm":
          rank = "Diamond";
          break;
        case "1lt":
          rank = "Elite";
          break;
        default:
          break;
      }
      return rank;
    },
    getSubscriptionName(subscription) {
      let name = "";

      name =
        this.toProperCase(subscription.plan) +
        " " +
        this.getRank(subscription) +
        " - " +
        subscription.amount;
      return name;
    },
    viewReferrals(user) {
      vm.$router.push({
        name: "user-referrals",
        params: { user: `${user.id}` }
      });
    },
    viewSubscriptions(user) {
      vm.$router.push({
        name: "user-subscriptions",
        params: { id: `${user.id}` }
      });
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
      let toggleModal = swal.mixin({
        confirmButtonClass: "v-btn blue-grey  subheading white--text",
        buttonsStyling: false
      });

      massDeleteForm
        .post(route("users.massDelete").url())
        .then(response => {
          toggleModal.fire({
            title: "Success!",
            html: '<p class="title">' + "Success" + "</p>",
            type: "success",
            confirmButtonText: "Back"
          });
          selected.forEach(id => {
            console.log(id);
            if (id !== 1) {
              let index = _.findIndex(self.items, { id });
              self.$delete(self.items, index);
            }
          });
          self.selected = [];
        })
        .catch(errors => {
          console.log(errors);
          toggleModal.fire({
            title: "Oops! Something Went Wrong...",
            html: '<p class="title">' + errors + "</p>",
            type: "warning",
            confirmButtonText: "Back"
          });
        });
    },
    massMail(form) {
      let self = this;
      form
        .post(route("users.massMail").url())
        .then(response => {
          let toggleModal = swal.mixin({
            confirmButtonClass: "v-btn blue-grey  subheading white--text",
            buttonsStyling: false
          });
          toggleModal.fire({
            title: "Success!",
            html: '<p class="title">' + response.data.message + "</p>",
            type: "success",
            confirmButtonText: "Back"
          });
          self.selected = [];
          Bus.$emit("close-modal-mass-mail");
        })
        .catch(errors => {
          console.log(errors);
          if (errors.response.data.message) {
            let toggleModal = swal.mixin({
              confirmButtonClass: "v-btn blue-grey  subheading white--text",
              buttonsStyling: false
            });
            toggleModal.fire({
              title: "Oops! Something Went Wrong...",
              html: '<p class="title">' + errors.response.data.message + "</p>",
              type: "error",
              confirmButtonText: "Back"
            });
          }
          self.selected = [];
          Bus.$emit("close-modal-mass-mail");
        });
    },
    toggleOrderByData() {
      if (this.orderByData === "ASC") {
        this.orderByData = "DESC";
        this.orderColor = "orange";
      } else {
        this.orderByData = "ASC";
        this.orderColor = "teal";
      }
    },
    editUser(user) {
      this.$inertia.visit(route("users.edit", { user: user.id }).url());
    },
    toggleStatus(user) {
      let self = this;
      self.toggleForm.user_id = user.id;
      let index = _.findIndex(self.items, { id: user.id });
      self.toggleForm
        .post(route("users.toggleStatus").url())
        .then(({ data }) => {
          console.log(data.status);
          let toggleModal = swal.mixin({
            confirmButtonClass: "v-btn blue-grey  subheading white--text",
            buttonsStyling: false
          });
          if (data.status === true) {
            toggleModal.fire({
              title: "Success!",
              html: '<p class="title">User Status Activated!</p>',
              type: "success",
              confirmButtonText: "Back"
            });
          } else {
            toggleModal.fire({
              title: "Success!",
              html: '<p class="title">User Status Deactivated!</p>',
              type: "success",
              confirmButtonText: "Back"
            });
          }
        })
        .catch(errors => {
          let toggleModal = swal.mixin({
            confirmButtonClass: "v-btn blue-grey  subheading white--text",
            buttonsStyling: false
          });
          toggleModal.fire({
            title: "Oops! Forbidden Action!",
            html: '<p class="title">' + errors.response.data.message + "</p>",
            type: "warning",
            confirmButtonText: "Back"
          });
          user.active = true;
          self.items.splice(index, 1, user);
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
      let toggleModal = swal.mixin({
        confirmButtonClass: "v-btn blue-grey  subheading white--text",
        buttonsStyling: false
      });

      try {
        const payload = await toggleStatusForm.post(
          route("users.massDeactivate").url()
        );
        let updated = payload.data.updated;
        _.map(updated, id => {
          let index = _.findIndex(self.items, { id });
          self.items[index].active = false;
        });
        toggleModal.fire({
          title: "Success",
          html: `<p class="title">${payload.data.message}</p>`,
          type: "success",
          confirmButtonText: "Back"
        });
      } catch (errors) {
        toggleModal.fire({
          title: "Oops Something Went Wrong!",
          html: `<p class="title">${errors}</p>`,
          type: "error",
          confirmButtonText: "Back"
        });
      }
    },
    async massActivate() {
      let self = this;
      let selected = _.map(self.selected, "id");
      let toggleStatusForm = new Form({
        selected
      });
      let toggleModal = swal.mixin({
        confirmButtonClass: "v-btn blue-grey  subheading white--text",
        buttonsStyling: false
      });

      try {
        const payload = await toggleStatusForm.post(
          route("users.massActivate").url()
        );
        let updated = payload.data.updated;
        console.log(updated);
        _.map(updated, id => {
          let index = _.findIndex(self.items, { id });
          self.items[index].active = true;
        });
        toggleModal.fire({
          title: "Success",
          html: `<p class="title">${payload.data.message}</p>`,
          type: "success",
          confirmButtonText: "Back"
        });
      } catch (errors) {
        toggleModal.fire({
          title: "Oops Something Went Wrong!",
          html: `<p class="title">${errors}</p>`,
          type: "error",
          confirmButtonText: "Back"
        });
      }
    },
    deleteUser(user) {
      let self = this;
      self.deleteUserForm.user_id = user.id;
      let index = _.findIndex(self.items, { id: user.id });
      let toggleModal = swal.mixin({
        confirmButtonClass: "v-btn blue-grey  subheading white--text",
        buttonsStyling: false
      });
      self.deleteUserForm
        .post(route("users.destroy", { user: user.id }).url())
        .then(response => {
          if (response.data.status === true) {
            toggleModal.fire({
              title: "Success",
              html: `<p class="title">User Deleted!</p>`,
              type: "success",
              confirmButtonText: "Back"
            });
            self.$delete(self.items, index);
          } else {
            toggleModal.fire({
              title: "Forbidden Action!",
              html: `<p class="title">Cannot Delete Super Admin!</p>`,
              type: "warning",
              confirmButtonText: "Back"
            });
          }
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
