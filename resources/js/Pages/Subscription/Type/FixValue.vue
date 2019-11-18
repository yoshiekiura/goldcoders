<template>
  <div v-if="commissions">
    <div v-for="(rank,key) in commissions" :key="key">
      <v-flex xs12 offset-md2 md8>
        <v-subheader>key-{{ key }}</v-subheader>
        <pre>rank {{ rank }}</pre>
        <pre>commission key {{ commissions[key] }}</pre>
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model="rank.amount"
          v-validate="'required'"
          :error-messages="errorMessages(`${key}_amount`)"
          :class="{ 'error--text': hasErrors(`${key}_amount`,rank) }"
          :data-vv-name="`${key}_amount`"
          class="primary--text"
          name="amount"
          label="Commission Per Cycle"
          prepend-icon="fa-money"
        />
      </v-flex>

      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model.number="rank.min"
          v-validate="'required|min_value:1|max_value:1000'"
          :error-messages="errorMessages(`${key}_min`)"
          :class="{ 'error--text': hasErrors(`${key}_min`,rank) }"
          :data-vv-name="`${key}_min`"
          type="number"
          min="1"
          max="1000"
          class="primary--text"
          name="min"
          label="Min"
          counter="255"
          prepend-icon="vertical_align_bottom"
        />
      </v-flex>

      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model.number="rank.max"
          v-validate="'required|min_value:1|max_value:1000'"
          :error-messages="errorMessages(`${key}_min`)"
          :class="{ 'error--text': hasErrors(`${key}_min`,rank) }"
          :data-vv-name="`${key}_min`"
          type="number"
          min="1"
          max="1000"
          class="primary--text"
          name="max"
          label="Max"
          counter="255"
          prepend-icon="vertical_align_top"
        />
      </v-flex>
    </div>
  </div>
</template>
<script>
import validationError from "../../../mixins/validation-error";
export default {
  mixins: [validationError],
  // make this an array we need to pass in the rank also
  // so each rank has its own compounding form
  props: {
    commissions: {
      type: [Object],
      default: null,
    },
  },
  methods: {
    hasErrors(field, rank) {
      console.log(rank);
      let errors = this.errors.collect(field).concat(rank.errors.only(field));
      if (errors.length > 0) {
        return true;
      }
      return false;
    },
  },
};
</script>