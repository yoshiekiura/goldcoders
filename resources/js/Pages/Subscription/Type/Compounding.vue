<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.compounding_percent"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('compounding_percent')"
        :class="{ 'error--text': hasErrors('compounding_percent') }"
        class="primary--text"
        name="compounding_percent"
        label="Compounding Percent"
        data-vv-name="compounding_percent"
        counter="255"
        prepend-icon="fa-percent"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.compounding_min"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('compounding_min')"
        :class="{ 'error--text': hasErrors('compounding_min') }"
        class="primary--text"
        name="compounding_min"
        label="Compounding Min Amount"
        data-vv-name="compounding_min"
        counter="255"
        prepend-icon="vertical_align_bottom"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.compounding_max"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('compounding_max')"
        :class="{ 'error--text': hasErrors('compounding_max') }"
        class="primary--text"
        name="compounding_max"
        label="Compounding Max Amount"
        data-vv-name="compounding_max"
        counter="255"
        prepend-icon="vertical_align_top"
      />
    </v-flex>
  </div>
</template>
<script>
import validationError from "../../../mixins/validation-error";
import { Form } from "vform";

export default {
  // make this an array we need to pass in the rank also
  // so each rank has its own compounding form
  mixins: [validationError],
  props: {
    details: {
      type: [Object, Array],
      default: null
    }
  },
  data: () => ({
    form: new Form({
      compounding_min: 1,
      compounding_max: 1000,
      compounding_percent: 5
    })
  })
};
</script>