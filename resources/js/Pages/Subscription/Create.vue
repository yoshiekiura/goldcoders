<template>
  <main-layout :title="title">
    <v-card flat class="grey lighten-5">
      <v-flex xs12 md8 offset-md2 text-xs-center>
        <app-alert></app-alert>
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-validate="'required'"
          v-model="form.name"
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
      <v-flex class="xs12 offset-md2 md8 pt-5 pb-5">
        <v-autocomplete
          v-validate="'required'"
          :items="$page.plans"
          v-model="form.type"
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
      <component v-if="form.type" :is="form.type" />
      <v-flex xs12 offset-md2 md8>
        <v-switch color="green darken-4" :label="getLifetimeStatus" v-model="form.lifetime" />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-subheader>Cycle Every (Unit Of Time) for (X) Amount Of Times</v-subheader>
        <v-divider></v-divider>
      </v-flex>
      <v-flex class="xs12 offset-md2 md8 pt-5 pb-5">
        <v-autocomplete
          v-validate="'required'"
          :items="$page.intervals"
          v-model="form.cycle_unit"
          :error-messages="errorMessages('cycle_unit')"
          :class="{ 'error--text': hasErrors('cycle_unit') }"
          required
          color="blue-grey"
          label="Cycle Unit Of Time"
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
          v-validate="'required|min_value:1|max_value:1000'"
          v-model.number="form.cycle_interval"
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
      <v-flex xs12 offset-md2 md8 v-if="cycle_every">
        <v-text-field
          readonly
          v-model="cycle_every"
          class="primary--text"
          name="duration"
          label="1 Cycle Every"
          prepend-icon="wb_sunny"
        />
      </v-flex>
      <v-flex v-if="!form.lifetime" xs12 offset-md2 md8>
        <v-text-field
          v-validate="'required|min_value:1|max_value:1000'"
          v-model.number="form.cycle_repeat"
          type="number"
          min="1"
          max="1000"
          :error-messages="errorMessages('cycle_repeat')"
          :class="{ 'error--text': hasErrors('cycle_repeat') }"
          class="primary--text"
          name="cycle_repeat"
          label="Repeat(s)"
          data-vv-name="cycle_repeat"
          counter="255"
          prepend-icon="repeat"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          readonly
          v-model="duration"
          class="primary--text"
          name="duration"
          label="Duration"
          prepend-icon="calendar_today"
        />
      </v-flex>

      <v-flex xs12 offset-md2 md8>
        <span class="subheading">Cycle Period For Commission</span>
        <v-chip-group multiple active-class="accent">
          <v-chip
            filter
            @change="addOrRemove(n)"
            v-for="n in form.cycle_repeat"
            :key="n"
          >Cycle {{ n }}</v-chip>
        </v-chip-group>
      </v-flex>

      <v-flex v-if="!form.lifetime" xs12 offset-md2 md8>
        <v-divider></v-divider>
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
    ProfitSharing
  },
  mixins: [validationError],
  data: () => ({
    title: "Create Subscription Plan",
    form: new Form({
      type: null,
      details: null,
      name: "",
      amount: "",
      cycle_unit: 24,
      cycle_interval: 1,
      cycle_repeat: 1,
      // empty array will default to a range from 1-max-repitition
      // int (single)
      // array [1,3,5,7]
      // range['1-2','3-5','8-9']
      cycle_period: [],
      lifetime: false
    }),
    billing_cycle: [
      // we need a implement here a way to cash range to loop and add it to array
      // we always show the remaining cycle
      "every_repeat", //loop 1 up to cycle_repeat
      "custom" // [1,'2-3',cucle_repeat count]
    ],
    // define here the structure of our data for each type
    fix_value: {
      value: 30,
      shit: "powerA"
    },
    percentage: {
      percent: 30
    },
    compounding: {
      percent: 3
    },
    profit_sharing: {
      percent: 50
    }
  }),
  computed: {
    getLifetimeStatus() {
      return this.form.lifetime ? "Lifetime" : "Expiring";
    },
    cycle_every() {
      if (this.form.cycle_unit) {
        let day = Math.floor(
          (this.form.cycle_unit * this.form.cycle_interval) / 24
        );
        return `${day} day(s)`;
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
        return `${day} day(s)`;
      }
    }
  },
  methods: {
    addOrRemove(value) {
      let array = this.form.cycle_period;
      var index = array.indexOf(value);

      if (index === -1) {
        array.push(value);
      } else {
        array.splice(index, 1);
      }
      this.form.cycle_period.sort((a, b) => a - b);
    },

    toCamelCase(str) {
      return str.replace(/([-_][a-z])/g, group =>
        group
          .toUpperCase()
          .replace("-", "")
          .replace("_", "")
      );
    },
    submit() {
      // before submit check if the not life time
      // we set duration to -1 meaning this is a non expiring cycle
    }
  },
  watch: {
    "form.type"(newVal) {
      // set new type component
      this.type = this.toCamelCase(newVal);
      // evaluate the newVal text to object
      this.form.details = eval(`this.${newVal}`);
    },
    "form.cycle_repeat"() {
      this.form.cycle_period = [];
    }
  }
};
</script>
