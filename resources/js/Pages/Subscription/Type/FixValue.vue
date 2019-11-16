<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.amount"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('amount')"
        :class="{ 'error--text': hasErrors('amount') }"
        class="primary--text"
        name="amount"
        label="Compounding Percent"
        data-vv-name="amount"
        counter="255"
        prepend-icon="fa-percent"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.min"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('min')"
        :class="{ 'error--text': hasErrors('min') }"
        class="primary--text"
        name="min"
        label="Min Amount"
        data-vv-name="min"
        counter="255"
        prepend-icon="vertical_align_bottom"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-validate="'required|min_value:1|max_value:1000'"
        v-model.number="form.max"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('max')"
        :class="{ 'error--text': hasErrors('max') }"
        class="primary--text"
        name="max"
        label="Fix Value Max Amount"
        data-vv-name="max"
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
      min: 1,
      max: 1000,
      amount: 5
    })
  })
};
</script>