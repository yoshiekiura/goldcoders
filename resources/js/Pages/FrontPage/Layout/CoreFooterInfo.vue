<template>
  <v-footer color="#353535" class="white--text" height="auto">
    <v-container fluid mx-12>
      <v-row>
        <v-col cols="9">
          <div
            class="caption white--text font-weight-light text-justify"
          >All information provided on this site is intended solely for the study purposes of issues related to trading on financial markets and does not serve in any way as a specific investment recommendation, business recommendation, investment opportunity analysis or similar general recommendation regarding the trading of investment instruments. Trading in financial markets is a high-risk activity! FTMO, CSO does not provide any of the investment services listed in the Capital Market Undertakings Act No. 256/2004 Coll. The information on this site is not directed at residents in any country or jurisdiction where such distribution or use would be contrary to local law or regulation.</div>
        </v-col>

        <v-col cols="3" justify-end>
          <v-row justify="center">
            <img class="payment" :src="image_src" />
          </v-row>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12">
          <div class="caption white--text font-weight-light text--justify">
            {{ new Date().getFullYear() }} © Copyright - GoldCoders.Club Made with
            <span
              class="red--text"
            >❤</span> for trading
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>


<script>
import AppLogo from "@/Shared/AppLogo";
export default {
  components: {
    AppLogo
  },
  computed: {},
  data() {
    return {
      image_src: "/images/logo/payment_methods.png"
    };
  }
};
</script>

<style  scoped>
.payment {
  background-color: white;
  border-radius: 4px;
  width: 200px;
}
</style>
