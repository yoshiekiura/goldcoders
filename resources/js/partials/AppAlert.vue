<template>
  <div>
    <v-alert v-if="$page.flash.success" text prominent dismissible type="success">{{ $page.flash.success }}</v-alert>
    <v-alert v-if="$page.flash.info" text prominent dismissible type="info">{{ $page.flash.info }}</v-alert>
    <v-alert v-if="$page.flash.error" text prominent dismissible type="error">{{ $page.flash.error }}</v-alert>
    <v-alert v-if="$page.flash.warning" text prominent dismissible type="warning">{{ $page.flash.warning }}</v-alert>
  </div>
</template>