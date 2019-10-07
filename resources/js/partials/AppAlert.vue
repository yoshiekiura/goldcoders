<template>
  <div>
    <v-alert text prominent dismissible v-if="$page.flash.success" type="success">{{ $page.flash.success }}</v-alert>
    <v-alert text prominent dismissible v-if="$page.flash.info" type="info">{{ $page.flash.info }}</v-alert>
    <v-alert text prominent dismissible v-if="$page.flash.error" type="error">{{ $page.flash.error }}</v-alert>
    <v-alert text prominent dismissible v-if="$page.flash.warning" type="warning">{{ $page.flash.warning }}</v-alert>
  </div>
</template>