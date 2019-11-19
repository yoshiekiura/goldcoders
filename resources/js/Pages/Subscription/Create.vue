<template>
  <main-layout :title="title">
    <v-card flat class="grey lighten-5">
      <v-flex xs12 md8 offset-md2 text-xs-center>
        <app-alert />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model="form.name"
          v-validate="'required'"
          :error-messages="errorMessages('name')"
          :class="{ 'error--text': hasErrors('name') }"
          class="primary--text"
          name="name"
          label="Plan Name"
          data-vv-name="name"
          counter="255"
          prepend-icon="fa-at"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-combobox
          v-model="ranks"
          :items="$page.ranks"
          :search-input.sync="searchRank"
          deletable-chips
          hide-selected
          hint="Ranks"
          label="Add Ranks"
          multiple
          persistent-hint
          small-chips
        >
          <template v-slot:no-data>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  No Results matching "
                  <strong>{{ searchRank }}</strong>". Press
                  <kbd>enter</kbd> to create a new Rank
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-combobox>
      </v-flex>
      <v-flex class="xs12 offset-md2 md8 pt-5 pb-5">
        <v-autocomplete
          v-model="form.type"
          v-validate="'required'"
          :items="$page.plans"
          :error-messages="errorMessages('type')"
          :class="{ 'error--text': hasErrors('type') }"
          required
          color="blue-grey"
          label="Select Plan Type"
          light
          chips
          clearable
          deletable-chips
          prepend-icon="label_important"
          data-vv-name="type"
        />
      </v-flex>
      <component :is="form.type" v-if="form.type" :commissions="commissions" />
      <v-flex xs12 offset-md2 md8>
        <v-switch v-model="form.lifetime" color="green darken-4" :label="getLifetimeStatus" />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-subheader>Fill Up Fields For Setting Cycle and Cycle Commission</v-subheader>
        <v-chip class="ma-2" color="accent" text-color="white">
          1 Cycle Every {{ cycle_every }} for {{ duration }}
          <v-icon color="primary" right>wb_sunny</v-icon>
        </v-chip>
        <v-divider />
      </v-flex>
      <v-flex class="xs12 offset-md2 md8 pt-5 pb-5">
        <v-autocomplete
          v-model="form.cycle_unit"
          v-validate="'required'"
          :items="$page.intervals"
          :error-messages="errorMessages('cycle_unit')"
          :class="{ 'error--text': hasErrors('cycle_unit') }"
          required
          color="blue-grey"
          label="Cycle Unit"
          light
          chips
          clearable
          item-text="name"
          item-value="value"
          deletable-chips
          prepend-icon="timer"
          data-vv-name="cycle_unit"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model.number="form.cycle_interval"
          v-validate="'required|min_value:1|max_value:1000'"
          type="number"
          min="1"
          max="1000"
          :error-messages="errorMessages('cycle_interval')"
          :class="{ 'error--text': hasErrors('cycle_interval') }"
          class="primary--text"
          name="cycle_interval"
          label="Cycle Interval"
          data-vv-name="cycle_interval"
          counter="255"
          prepend-icon="toys"
        />
      </v-flex>

      <v-flex v-if="!form.lifetime" xs12 offset-md2 md8>
        <v-text-field
          v-model.number="form.cycle_repeat"
          v-validate="'required|min_value:1|max_value:1000'"
          type="number"
          min="1"
          max="1000"
          :error-messages="errorMessages('cycle_repeat')"
          :class="{ 'error--text': hasErrors('cycle_repeat') }"
          class="primary--text"
          name="cycle_repeat"
          label="Cycle Repeat"
          data-vv-name="cycle_repeat"
          counter="255"
          prepend-icon="repeat"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model="duration"
          readdeletable-chipsonly
          class="primary--text"
          name="duration"
          label="Duration"
          prepend-icon="calendar_today"
        />
      </v-flex>

      <v-flex v-if="!form.lifetime" xs12 offset-md2 md8>
        <span class="subheading">Select Cycle To Give Commission</span>
        <v-checkbox
          v-model="selected_all"
          :indeterminate="indeterminate"
          label="Select All"
          @change="toggleSelect()"
        />

        <v-chip-group
          v-model="billing_cycle"
          multiple
          column
          active-class="accent white--text"
          class="white--text"
        >
          <v-chip v-for="(n) in form.cycle_repeat" :key="n" filter :value="n">Cycle {{ n }}</v-chip>
        </v-chip-group>
      </v-flex>

      <v-flex v-if="!form.lifetime" xs12 offset-md2 md8>
        <v-divider />
      </v-flex>
    </v-card>
  </main-layout>
</template>
<script>
import MainLayout from "../../Layouts/MainLayout";
import AppAlert from "../../partials/AppAlert";
import validationError from "../../mixins/validation-error";
import { Form } from "vform";
import Compounding from "./Type/Compounding";
import FixValue from "./Type/FixValue";
import Percentage from "./Type/Percentage";
import Ranking from "./Type/Ranking";
import ProfitSharing from "./Type/ProfitSharing";

export default {
  components: {
    AppAlert,
    MainLayout,
    Compounding,
    FixValue,
    Percentage,
    Ranking,
    ProfitSharing,
  },
  mixins: [validationError],
  data: () => ({
    title: "Create Subscription Plan",
    // start : working on this
    details: null,
    commissions: null, // we need to add to  each key (rank) the billing cycle with value
    billing_cycle: [],
    // end
    form: new Form({
      type: null,
      name: "",
      amount: "",
      cycle_unit: 24,
      cycle_interval: 1,
      cycle_repeat: 1,
      // empty array will default to a range from 1-max-repitition
      // int (single)
      // array [1,3,5,7]
      // range['1-2','3-5','8-9']
      cycle_period: [], // push here billing cycle on submit
      lifetime: false,
    }),
    selected_all: false,
    periods: [1],
    ranks: [],
    searchRank: null,
  }),
  computed: {
    indeterminate() {
      if (
        this.billing_cycle.length !== this.periods.length &&
        this.selected_all
      ) {
        return true;
      }
    },
    getLifetimeStatus() {
      return this.form.lifetime ? "Lifetime" : "Expiring";
    },
    cycle_every() {
      if (this.form.cycle_unit) {
        let day = Math.floor(
          (this.form.cycle_unit * this.form.cycle_interval) / 24
        );
        let dw = "days";
        if (day < 2) {
          dw = "day";
        }
        return `${day} ${dw}`;
      }
    },
    duration() {
      if (this.form.lifetime) {
        return "Forever";
      }
      if (this.form.cycle_unit) {
        let day = Math.floor(
          (this.form.cycle_unit *
            this.form.cycle_interval *
            this.form.cycle_repeat) /
            24
        );
        let dw = "days";
        if (day < 2) {
          dw = "day";
        }
        return `${day} ${dw}`;
      }
    },
  },
  watch: {
    ranks() {
      let details = {};
      // eslint-disable-next-line no-unused-vars
      let self = this;
      this.ranks.forEach(key => {
        if (this.form.type) {
          details[key] = self.newForm();
        } else {
          details[key] = new Form();
        }
      });
      this.details = details;
      this.commissions = details;
    },
    "form.type"() {
      // set new type component
      let self = this;
      let details = {};

      this.ranks.forEach(key => {
        details[key] = self.newForm();
      });
      this.details = details;
      this.commissions = details;
    },
    "form.cycle_repeat"(newVal) {
      this.billing_cycle = [];
      this.selected_all = false;
      this.periods = this.rangeCycle(1, newVal);
    },
    "form.lifetime"(newVal) {
      if (newVal) {
        this.billing_cycle = [];
        this.selected_all = false;
      }
    },
  },
  methods: {
    newForm() {
      return new Form({
        min: null,
        max: null,
        amount: null,
      });
    },
    toggleSelect() {
      if (this.selected_all === true) {
        this.billing_cycle = this.periods;
      }
      if (this.selected_all === false) {
        this.billing_cycle = [];
      }
    },
    submit() {
      // before submit check if the not life time
      // we set duration to -1 meaning this is a non expiring cycle
    },
    rangeCycle(start, end) {
      var ans = [];
      for (let i = start; i <= end; i++) {
        ans.push(i);
      }
      return ans;
    },
  },
};
</script>
