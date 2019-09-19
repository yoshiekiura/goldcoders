<template>
  <modal-layout class="white" title="Logout">
    <v-card :flat="true" color="grey lighten-5">
      <v-toolbar class="accent">
        <v-btn text icon color="primary" @click.native="redirectBack()">
          <v-icon>arrow_back</v-icon>
        </v-btn>
        <v-spacer />
        <v-toolbar-title class="text-xs-center primary--text">Are You Sure You Want To Log Out?</v-toolbar-title>
        <v-spacer />
        <v-toolbar-items>
          <!-- If There is no User Account Login Yet Redirect to Authentication Page -->
          <v-btn text color="primary" @click.native="logout()">
            <v-icon right>fa-power-off</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-container fluid>
          <form @submit.prevent="logout()">
            <v-layout v-if="$page.auth.user" row>
              <v-flex x12 sm12 md4 offset-md4 lg4 offset-lg4 xl4 offset-xl4>
                <v-card flat class="text-center grey lighten-5">
                  <v-container fill-height fluid>
                    <v-layout fill-height>
                      <v-flex xs12>
                        <v-avatar
                          :tile="tile"
                          :size="avatarSize"
                          class="grey lighten-4"
                          fill-height
                          fluid
                        >
                          <img :src="$page.auth.user.avatar" :alt="$page.auth.user.name" />
                        </v-avatar>
                      </v-flex>
                    </v-layout>
                  </v-container>
                  <v-layout>
                    <v-flex xs12 text-center flexbox>
                      <h5 class="primary--text title">{{ $page.auth.user.fname }} {{$page.auth.user.lname }}</h5>
                    </v-flex>
                  </v-layout>
                </v-card>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs12 sm12 md4 offset-md4 lg4 offset-lg4 xl4 offset-xl4>
                  <v-btn
                    block
                    text
                    class="white--text"
                    color="info"
                    @click.native="redirectBack()"
                  >No, I Want To Stay</v-btn>
                  <v-btn
                    :loading="form.busy"
                    :disabled="form.busy"
                    block
                    text
                    color="red lighten-2"
                    class="white--text"
                    type="submit"
                  >Yes, Log Me Out</v-btn>
              </v-flex>
            </v-layout>
          </form>
        </v-container>
      </v-card-text>
    </v-card>
  </modal-layout>
</template>

<script>
import ModalLayout from "../Layouts/ModalLayout";
import validationError from "../mixins/validation-error";
import Form from "vform";

export default {
  components: {
    ModalLayout
  },
  mixins: [validationError],
  data: () => ({
    tile: false,
    avatarSize: "200px",
    form: new Form({
      submit: true
    }),
  }),
  methods: {
    redirectBack() {
      let self = this;
      this.$inertia.visit(this.route("dashboard"), {
        method: "get",
        data: {},
        replace: false,
        preserveScroll: false,
        preserveState: false
      });
    },
    logout() {
      let self = this;
      self.form.busy = true;
      self.$inertia.post(this.route("logout.attempt").url(), self.form);
    }
  }
};
</script>
