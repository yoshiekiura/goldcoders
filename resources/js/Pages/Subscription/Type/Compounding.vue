<template>
  <div>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        readonly
        class="primary--text"
        name="duration"
        label="Compounding Percent"
        prepend-icon="fa-percent"
        value="5"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        readonly
        class="primary--text"
        name="duration"
        label="Compounding Min Amount"
        prepend-icon="vertical_align_bottom"
        value="1000"
      />
    </v-flex>
    <v-flex xs12 offset-md2 md8>
      <v-text-field
        readonly
        class="primary--text"
        name="duration"
        label="Compounding Max Amount"
        prepend-icon="vertical_align_top"
        value="10000"
      />
    </v-flex>
  </div>
</template>