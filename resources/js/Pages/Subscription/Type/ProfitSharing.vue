<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-model.number="form.user_share"
        v-validate="'required|min_value:1'"
        type="number"
        min="1"
        :error-messages="errorMessages('user_share')"
        :class="{ 'error--text': hasErrors('user_share') }"
        class="primary--text"
        name="user_share"
        label="User Share"
        data-vv-name="percent"
        prepend-icon="fa-percent"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        v-model.number="form.company_share"
        v-validate="'required|min_value:1'"
        type="number"
        min="1"
        :error-messages="errorMessages('company_share')"
        :class="{ 'error--text': hasErrors('company_share') }"
        class="primary--text"
        name="company_share"
        label="Company Share"
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
      user_share: 50,
      company_share: 50,
    }),
  }),
};
</script>