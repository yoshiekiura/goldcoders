<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <v-layout row my-4>
        <inertia-link
          class="headline font-weight-thin inertia-link"
          :href="route('payment')"
        >{{ name }}</inertia-link>
        <span class="headline font-weight-thin mx-1">/</span>
        <span class="headline font-weight-thin">Create</span>
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
                    :disabled="ifMemberOnly"
                    cache-items
                    required
                    color="blue-grey"
                    label="Pay Master"
                    item-text="name"
                    item-value="id"
                    light
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.paymaster_id"
                  />

                  <v-autocomplete
                    :items="getMembers"
                    v-model="form.member_id"
                    :disabled="ifMemberOnly"
                    required
                    color="blue-grey"
                    label="Member"
                    item-text="name"
                    item-value="value"
                    light
                    prepend-icon="fa-user"
                    :error-messages="$page.errors.member_id"
                  />

                  <v-dialog
                    ref="dialog1"
                    v-model="modal1"
                    :return-value.sync="form.date_paid"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="form.date_paid"
                        :error-messages="$page.errors.date_paid"
                        label="Date Paid"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                      />
                    </template>
                    <v-date-picker v-model="form.date_paid" scrollable>
                      <v-spacer />
                      <v-btn color="primary" @click="modal1 = false">Cancel</v-btn>
                      <v-btn color="primary" @click="$refs.dialog1.save(form.date_paid)">OK</v-btn>
                    </v-date-picker>
                  </v-dialog>

                  <v-file-input
                    v-model="form.images"
                    placeholder="Upload your documents"
                    label="Documents"
                    multiple
                    prepend-icon="mdi-camera"
                    :show-size="1000"
                    counter
                    accept="image/*"
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
                      prepend-icon="mdi-credit-card"
                      prefend
                      :error-messages="$page.errors.amount"
                    />

                    <v-autocomplete
                      :items="gateways"
                      v-model="form.payment_details"
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
                      :error-messages="$page.errors['payment_details.value']"
                    />

                    <div v-for="(item , index) in form.payment_details.details" :key="index">
                      <v-layout align-center justify-center row>
                        <v-text-field
                          v-model="form.payment_details.details[index].value"
                          class="primary--text"
                          :label="form.payment_details.details[index].name"
                          prepend-icon="assignment"
                          :error-messages="$page.errors.name"
                        />
                      </v-layout>
                    </div>
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
                <span class="white--text">Create {{ name }}</span>
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
import OT from "../../mixins/object_transform";
import RM from "@/mixins/role_helper";

export default {
  components: {
    MainLayout
  },
  mixins: [OT, RM],
  props: {
    users: Array,
    paymasters: Array,
    gateways: Array
  },
  created() {
    this.ifMemberOnly = this.checkIfMemberOnly();
    if (this.ifMemberOnly) {
      this.form.paymaster_id = this.$page.auth.user.sponsor.id;
      this.form.member_id = this.$page.auth.user.id;
    }
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
      images: [],
      ifMemberOnly: false,
      form: {
        paymaster_id: null,
        member_id: null,
        payment_details: {},
        date_paid: null,
        date_approved: null,
        amount: 0,
        files: [],
        busy: false,
        images: null
      }
    };
  },
  methods: {
    submit() {
      let self = this;
      self.form.busy = true;
      let payment_details = this.form.payment_details.details;
      this.form.payment_details.details = this.toPropertyValue(payment_details);
      self.$inertia
        .post(self.route("payment.store").url(), objectToFormData(self.form), {
          replace: true,
          preserveState: true
        })
        .then(() => (self.form.busy = false));
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
