<template>
  <main-layout :title="name">
    <v-container grid-list-md>
      <v-layout row my-4>
        <inertia-link
          class="headline font-weight-thin inertia-link"
          :href="route('gateway')"
        >
          {{ name }}
        </inertia-link>
        <span class="headline font-weight-thin mx-1">/</span>
        <span class="headline font-weight-thin">Create</span>
      </v-layout>

      <v-layout row>
        <v-flex md4>
          <v-card>
            <v-container class="pa-2" fluid grid-list-md>
              <v-layout column>
                <span class="header grey--text ml-3 mt-3">General</span>

                <v-flex px-5>
                  <v-text-field
                    v-model="form.name"
                    autofocus
                    class="primary--text"
                    label="Name"
                    prepend-icon="assessment"
                    :error-messages="$page.errors.name"
                  />
                  <v-text-field
                    v-model="form.type"
                    class="primary--text"
                    label="Type"
                    prepend-icon="assessment"
                    :error-messages="$page.errors.type"
                  />

                  <v-switch v-model="form.active" label="Active ?" />
                  <v-switch v-model="form.for_payout" label="For Payout ?" />
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-flex>
        <v-flex md8>
          <v-card>
            <v-container class="pa-2" fluid grid-list-md>
              <v-layout column>
                <span class="header grey--text ml-3 mt-3">Details</span>

                <v-flex px-5>
                  <!-- Fields -->

                  <v-layout align-center justify-space-between row>
                    <span class="v-label theme--light" />

                    <v-btn v-show="form.for_payout" @click="addField('')">Add Field</v-btn>
                    <div v-show="!form.for_payout">
                      <v-btn @click="addField('receiver_')">Add Receiver</v-btn>
                      <v-btn @click="addField('sender_')">Add Sender</v-btn>
                    </div>
                  </v-layout>

                  <v-flex md11 offset-md1>
                    <div v-for="(item , index) in form.details" :key="index">
                      <v-layout align-center justify-center row>
                        <v-text-field
                          v-model="form.details[index].name"
                          class="primary--text"
                          label="Field Name"
                          prepend-icon="assignment"
                        />
                        <v-text-field
                          v-model="form.details[index].value"
                          class="primary--text"
                          label="Field Value"
                          prepend-icon="assignment"
                        />
                        <v-btn small icon fab color="grey" @click="deleteField(item)">
                          <v-icon>delete</v-icon>
                        </v-btn>
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

export default {
  components: {
    MainLayout,
  },
  data() {
    return {
      dialog: false,
      name: "Gateway",
      form: {
        busy: false,
        name: null,
        type: null,
        active: false,
        for_payout: false,
        details: [],
      },
    };
  },
  watch: {
    "form.for_payout": {
      handler: function() {
        let self = this;
        self.form.details = [];
      },
      deep: true,
    },
  },
  methods: {
    submit() {
      let self = this;
      self.form.busy = true;
      self.$inertia
        .post(self.route("gateway.store").url(), self.form)
        .then(() => (self.form.busy = false));
    },
    deleteField(item) {
      this.form.details.splice(this.form.details.indexOf(item), 1);
    },
    addField(prefix) {
      this.form.details.push({
        name: prefix,
        value: "",
      });
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
