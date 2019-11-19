<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-model.number="form.fix_value"
        v-validate="'required|min_value:1|max_value:1000'"
        type="number"
        min="1"
        max="1000"
        :error-messages="errorMessages('fix_value')"
        :class="{ 'error--text': hasErrors('fix_value') }"
        class="primary--text"
        name="fix_value"
        label="Fix Value Amount"
        data-vv-name
        counter="255"
        prepend-icon="fa-money"
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
      fix_value: 5,
    }),
  }),
};
</script>