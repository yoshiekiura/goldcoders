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

      <v-flex class="xs12 offset-md2 md8">
        <v-autocomplete
          v-validate="'required'"
          :items="intervals"
          v-model="interval"
          :error-messages="errorMessages('interval')"
          :class="{ 'error--text': hasErrors('interval') }"
          required
          color="blue-grey"
          label="Select Time Interval"
          light
          chips
          clearable
          item-text="name"
          item-value="value"
          deletable-chips
          prepend-icon="timer"
          data-vv-name="interval"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-validate="'required'"
          v-model.number="interval_count"
          type="number"
          min="1"
          max="1000"
          :error-messages="errorMessages('interval_count')"
          :class="{ 'error--text': hasErrors('interval_count') }"
          class="primary--text"
          name="fname"
          label="No of Interval"
          data-vv-name="interval_count"
          counter="255"
          prepend-icon="fa-calendar"
        />
      </v-flex>
      <v-flex xs12 offset-md2 md8 v-if="duration">
        <v-text-field
          readonly
          v-model="duration"
          class="primary--text"
          name="duration"
          label="Duration"
          prepend-icon="wb_sunny"
        />
      </v-flex>
      <v-flex class="xs12 offset-md2 md8">
        <v-autocomplete
          v-validate="'required'"
          :items="types"
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
      <component v-if="type" :is="type" />
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
    types: ["fix_value", "percentage", "compounding", "profit_sharing"],
    title: "Create New Plan",
    form: new Form({
      type: null,
      details: null,
      // define here common value we need to be save on subscription table
      name: "",
      amount: "",
      interval: null,
      cycle: 1,
      duration: "" // in unit of hrs
      // we can select daily, weekly, hourly but the value here should be in hours
    }),
    interval: null,
    interval_count: 1,
    intervals: [
      // for custom we would multiply it to the duration we want
      // i.e.
      // except for tier base \ranking
      { name: "hourly", value: 1 },
      { name: "daily", value: 24 },
      { name: "weekly", value: 168 },
      { name: "monthly", value: 730 },
      { name: "quarterly", value: 2190 },
      { name: "semianually", value: 4380 },
      { name: "yearly", value: 8760 }
    ],
    // define here the structure of our data for each type
    fix_value: {
      value: 30
    },
    percentage: {
      percent: 30
    },
    compounding: {
      percent: 3
    },
    profit_sharing: {
      percent: 50
    },
    type: null
  }),
  computed: {
    duration() {
      if (this.interval) {
        let day = Math.floor((this.interval * this.interval_count) / 24);
        return `${day} day(s)`;
        1;
      }
    }
  },
  methods: {
    toCamelCase(str) {
      return str.replace(/([-_][a-z])/g, group =>
        group
          .toUpperCase()
          .replace("-", "")
          .replace("_", "")
      );
    }
  },
  watch: {
    "form.type"(newVal) {
      // set new type component
      this.type = this.toCamelCase(newVal);
      // evaluate the newVal text to object
      this.form.details = eval(`this.${newVal}`);
    },
    interval_count(newVal) {
      this.form.interval = this.interval * newVal;
    },
    interval(newVal) {
      this.form.interval = this.interval_count * newVal;
    }
  }
};
</script>