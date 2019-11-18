<template>
  <v-container fluid>
<v-carousel>
      <v-carousel-item v-for="(item,i) in items" :key="i" :src="platforms_src">
        <v-row class="fill-height" align="center" justify="start">
          <v-col align="start" justify="center" md="6">
            <v-row>
              <v-col align="start" justify="center" cols="1" />
              <v-col align="center" justify="center" cols="10" align-self="center">
                <div class="display-1 white--text">{{ item.title }}</div>
                <div class="headline white--text">{{ item.description }}</div>
                <v-btn class="mt-5" large color="#164596">{{ item.quicklink }}</v-btn>
              </v-col>
            </v-row>
          </v-col>

          <v-col align="center" justify="center" md="6" class="hidden-sm-and-down">
            <img class="sideimage" :src="item.src">
          </v-col>
        </v-row>

        <v-sheet height="100%" />
      </v-carousel-item>
    </v-carousel>
    <!-- </div> -->
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      platforms_src: "/images/banner/banner_background.jpg",
      items: [
        {
          src: "/images/banner/laptop-mt4.png",
          title: "FTMO PERFORMANCE PSYCHOLOGIST",
          description: "Our psychologist will help you perform better.",
          quicklink: "Learn More",
        },
        {
          src: "/images/banner/app-metrix.png",
          title: "FOREX TRADERS WANTED",
          description:
            "Trade our company's capital. Receive 70% of profits, we cover the losses.",
          quicklink: "Trading Psychologist",
        },
        {
          src: "/images/banner/team_png-2.png",
          title: "TRADE UP TO $100,000",
          description: "Join our successful traders.",
          quicklink: "Become The FTMO Trader",
        },
      ],
    };
  },
};
</script>


<style scoped>
.sideimage {
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center center;
}

.fakeimage {
  height: 100%;
  width: 100%;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>
