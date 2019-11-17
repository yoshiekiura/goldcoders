<template>
  <!-- <v-container fluid color="#F8F8F9" height="auto" class="py-12 my-12"> -->
  <v-container  color="#F8F8F9" height="auto" class="py-12 my-12">
    <p
      class="text-center headline font-weight-medium pd-12"
    >FTMO Is the Best Proprietary Firm You Can Find. Here’s Why.</p>



    <v-row justify="center" align="center" >
      <v-col cols="4" v-for="(item , index) in items" :key="index" justify="center" align="center">
        <v-row justify="start" align="center" >
          <v-icon large>{{ item.icon }}</v-icon>
          <v-col justify="start" align="start" class="pa-5">
            <p class="subtitle-1 font-weight-medium">{{ item.title }}</p>
            <p class="subtitle-1 font-weight-light">{{ item.description }}</p>
          </v-col>
        </v-row>
      </v-col>
    </v-row>


  </v-container>
</template>

<script>
export default {
  data() {
    return {
      items: [
        {
          icon: "fa-desktop",
          title: "Several platforms to trade on",
          description: "MT4, MT5, or cTrader. Choose yourself!"
        },
        {
          icon: "fa-times-circle",
          title: "No limits on trading style!",
          description:
            "Trade your own trading strategy with no limits or restrictions. You can use EAs, hedging or trade discretionary."
        },
        {
          icon: "fa-comments-o",
          title: "Dedicated Customer Support",
          description:
            "Reach us via Live Chat, E-Mail or arrange a call with us."
        },
        {
          icon: "fa-users",
          title: "Choose your broker!",
          description:
            "A wide selection of regulated brokers with a choice of account types."
        },
        {
          icon: "fa-arrow-up",
          title: "Leverage 1:100",
          description:
            "Use professional trader's leverage to your advantage with no limits on position size."
        },
        {
          icon: "fa-graduation-cap",
          title: "Trading Applications & Psychologist",
          description:
            "Access to in-house developed trading applications and support from our performance psychologist."
        },
        {
          icon: "fa-university",
          title: "Trade every instrument you want",
          description:
            "Forex, Commodities, Indices, Crypto, Stocks, Bonds, Energies..."
        },
        {
          icon: "fa-money",
          title: "One-time fee only",
          description:
            "No recurrent charges, no membership or other hidden fees. Moreover, the fee is automatically reimbursed to you with the first profit withdrawal."
        },
        {
          icon: "fa-area-chart",
          title: "Account Analysis",
          description:
            "A thorough analysis of your trading account with constructive feedback from our company."
        }
      ]
    };
  }
};
</script>

