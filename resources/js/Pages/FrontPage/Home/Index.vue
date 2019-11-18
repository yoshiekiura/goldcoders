<template>
  <front-layout>
    <banner />
    <good-trader />
    <join-our-team />
    <best-broker />
    <funding />
    <ftmo />
    <feedback />
    <join-our-team />
  </front-layout>
</template>


<script>
import FrontLayout from "@/Layouts/FrontLayout";
import JoinOurTeam from "@/Pages/FrontPage/Home/Join_Our_Team";
import Feedback from "@/Pages/FrontPage/Home/Feedback";
import Ftmo from "@/Pages/FrontPage/Home/Ftmo";
import Funding from "@/Pages/FrontPage/Home/Funding";
import BestBroker from "@/Pages/FrontPage/Home/Best_Broker";
import GoodTrader from "@/Pages/FrontPage/Home/Good_Trader";
import Banner from "@/Pages/FrontPage/Home/Banner";

export default {
  components: {
    FrontLayout,
    JoinOurTeam,
    Feedback,
    Ftmo,
    Funding,
    BestBroker,
    GoodTrader,
    Banner,
  },
};
</script>
