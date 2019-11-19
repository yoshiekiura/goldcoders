<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-model.number="form.compounding"
        v-validate="'required|min_value:1'"
        type="number"
        min="1"
        :error-messages="errorMessages('compounding')"
        :class="{ 'error--text': hasErrors('compounding') }"
        class="primary--text"
        name="compounding"
        label="Compounding Percent"
        data-vv-name="compounding"
        prepend-icon="fa-percent"
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
  data: () => ({
    form: new Form({
      compounding: 1,
    }),
  }),
};
</script>