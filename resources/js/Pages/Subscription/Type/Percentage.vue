<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-model.number="form.percent"
        v-validate="'required|min_value:1'"
        type="number"
        min="1"
        :error-messages="errorMessages('percent')"
        :class="{ 'error--text': hasErrors('percent') }"
        class="primary--text"
        name="percent"
        label="Percent"
        data-vv-name="percent"
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
      percent: 1,
    }),
  }),
};
</script>