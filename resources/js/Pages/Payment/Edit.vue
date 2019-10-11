<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <app-alert></app-alert>
      <v-layout row my-4>
        <inertia-link
          class="headline font-weight-thin inertia-link"
          :href="route('payment')"
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
                    :items="paymasters"
                    v-model="form.paymaster_id"
                    @change="form.member_id = null"
                    required
                    color="blue-grey"
                    label="Pay Master"
                    item-text="name"
                    item-value="id"
                    light
                    chips
                    clearable
                    deletable-chips
                    prepend-icon="fa-user"
                    :error-messages="$page.errors['master.id']"
                  />

                  <v-autocomplete
                    :items="getMembers"
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
                    :error-messages="$page.errors['member.id']"
                  />

                  <v-dialog
                    ref="dialog1"
                    v-model="modal1"
                    :return-value.sync="form.date_enter"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="form.date_enter"
                        :error-messages="$page.errors.date_enter"
                        label="Date Enter"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      />
                    </template>
                    <v-date-picker v-model="form.date_enter" scrollable>
                      <v-spacer />
                      <v-btn color="primary" @click="modal1 = false">Cancel</v-btn>
                      <v-btn color="primary" @click="$refs.dialog1.save(form.date_enter)">OK</v-btn>
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
                    <v-text-field
                      v-model="form.amount"
                      class="primary--text"
                      label="Amount"
                      :error-messages="$page.errors.amount"
                    />

                    <v-autocomplete
                      :items="gateways"
                      v-model="form.gateway"
                      required
                      color="blue-grey"
                      label="Gateway"
                      item-text="name"
                      item-value="value"
                      return-object
                      light
                      chips
                      clearable
                      deletable-chips
                      prepend-icon="fa-user"
                      :error-messages="$page.errors['master.id']"
                    />

                    <div v-for="(item , index) in form.gateway.details" :key="index">
                      <v-layout align-center justify-center row>
                        <v-text-field
                          v-model="form.gateway.details[index].value"
                          class="primary--text"
                          :label="form.gateway.details[index].name"
                          prepend-icon="assignment"
                          :error-messages="$page.errors.name"
                        />
                      </v-layout>
                    </div>
                  </v-flex>

                  <!-- END of Fields -->
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
import AdminDashPanel from "@/Shared/AdminDashPanel";
import AppAlert from "@/partials/AppAlert";

export default {
  components: {
    MainLayout,
    AdminDashPanel,
    AppAlert
  },
  props: {
    payment: Object,
    users: Array,
    paymasters: Array,
    gateways: Array
  },
  computed: {
    getMembers() {
      if (this.form.paymaster_id != null) {
        return _.filter(this.users, ["paymaster", this.form.paymaster_id]);
      }
      return [];
    }
  },
  data() {
    return {
      dialog: false,
      name: "Payment",
      modal1: false,
      form: {
        id: this.payment.id,
        paymaster_id: this.payment.paymaster_id,
        member_id: this.payment.member_id,
        date_enter: this.payment.date_enter,
        amount: this.payment.amount,
        gateway_id: this.payment.gateway_id,
        gateway: this.payment.gateway,
        file: null,
        busy: false,
        imageUrl: null
      },
      selected: []
    };
  },
  methods: {
    submit() {
      this.form.busy = true;
      this.$inertia
        .post(this.route("payment.update").url(), this.form)
        .then(() => ((this.form.busy = false), (this.alert = true)));
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
