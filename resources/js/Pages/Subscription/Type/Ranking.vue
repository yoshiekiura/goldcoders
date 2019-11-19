<template>
  <div v-if="!!ranks">
    <div v-for="(rank,key) in ranks" :key="key">
      <v-flex xs12 offset-md2 md8>
        <v-subheader class="text-capitalize font-weight-black">{{ key }}</v-subheader>
      </v-flex>
      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model.number="rank.min"
          v-validate="'required|min_value:1'"
          :error-messages="errorMessages(`${key}_min`)"
          :class="{ 'error--text': hasErrors(`${key}_min`,rank) }"
          :data-vv-name="`${key}_min`"
          type="number"
          min="1"
          class="primary--text"
          name="min"
          label="Min Payment"
          prepend-icon="vertical_align_bottom"
        />
      </v-flex>

      <v-flex xs12 offset-md2 md8>
        <v-text-field
          v-model.number="rank.max"
          v-validate="'required|min_value:1'"
          :error-messages="errorMessages(`${key}_max`)"
          :class="{ 'error--text': hasErrors(`${key}_max`,rank) }"
          :data-vv-name="`${key}_max`"
          type="number"
          min="1"
          class="primary--text"
          name="max"
          label="Max Payment"
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
    ranks: {
      type: [Object],
      default: null,
    },
  },
  methods: {
    hasErrors(field, rank) {
      let errors = this.errors.collect(field).concat(rank.errors.only(field));
      if (errors.length > 0) {
        return true;
      }
      return false;
    },
  },
};
</script>