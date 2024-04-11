/**
 * Load the resources used on all pages
 */

require('./base');

import Vue from 'vue'

/**
 * Default Vue components
 */

Vue.component('primary-navigation', require('./vue/navigation/PrimaryNavigation.vue').default);
Vue.component('login', require('./vue/components/Login.vue').default);

/**
 * Page specific packages
 */

window.datepicker = require('@fengyuanchen/datepicker');
window.timepicker = require('timepicker');

/**
 * Vue components
 */

// Default
Vue.component('sponsorship-map', require('./vue/tournaments/sponsor/SponsorshipMap.vue').default);
Vue.component('tournament-map', require('./vue/tournaments/search/TournamentMap.vue').default);
Vue.component('activity-feed', require('./vue/tournaments/search/ActivityFeed.vue').default);
Vue.component('credit-cards', require('./vue/components/CreditCards.vue').default);
Vue.component('order-sponsorships', require('./vue/checkout/Sponsorships.vue').default);
Vue.component('checkout', require('./vue/checkout/Checkout.vue').default);
Vue.component('approve-claim-request', require('./vue/tournament/ApproveClaimRequest.vue').default);
Vue.component('stripe-accounts', require('./vue/components/StripeAccounts.vue').default);
Vue.component('display-registration', require('./vue/tournament/display/Registration.vue').default);
Vue.component('action-bar', require('./vue/tournament/ActionBar.vue').default);
Vue.component('display-sponsorships', require('./vue/tournament/display/Sponsorships.vue').default);
Vue.component('claim', require('./vue/tournament/Claim.vue').default);
Vue.component('footer-information-small', require('./vue/components/FooterInformationSmall.vue').default);
Vue.component('footer-information-large', require('./vue/components/FooterInformationLarge.vue').default);

// Manage
Vue.component('sponsor-library', require('./vue/components/SponsorLibrary.vue').default);
Vue.component('poster', require('./vue/tournament/Poster.vue').default);
Vue.component('course', require('./vue/tournament/Course.vue').default);
Vue.component('course-nav', require('./vue/tournament/CourseNav.vue').default);
Vue.component('sponsorship-nav', require('./vue/tournament/SponsorshipNav.vue').default);
Vue.component('form-modal', require('./vue/components/FormModal.vue').default);
Vue.component('basic-form', require('./vue/components/BasicForm.vue').default);
Vue.component('form-row', require('./vue/components/FormRow.vue').default);
Vue.component('modal', require('./vue/components/Modal.vue').default);
Vue.component('location', require('./vue/tournament/Location.vue').default);
Vue.component('submit-tournament', require('./vue/manage/SubmitTournament.vue').default);
Vue.component('information', require('./vue/tournament/Information.vue').default);
Vue.component('registration', require('./vue/tournament/Registration.vue').default);
Vue.component('schedule', require('./vue/tournament/Schedule.vue').default);
Vue.component('player-packs', require('./vue/tournament/PlayerPacks.vue').default);
Vue.component('links', require('./vue/tournament/Links.vue').default);
Vue.component('media', require('./vue/tournament/Media.vue').default);
Vue.component('courses', require('./vue/tournament/Courses.vue').default);
Vue.component('sponsorship', require('./vue/tournament/Sponsorship.vue').default);
Vue.component('stripe', require('./vue/tournament/Stripe.vue').default);
Vue.component('refund', require('./vue/manage/order/Refund.vue').default);

// const bugsnag = require('@bugsnag/js');
// const bugsnagVue = require('@bugsnag/plugin-vue');

// window.bugsnagClient = bugsnag({
//     apiKey: 'e6dafe167baecf4f0cd93ba2ac4fc986',
//     appVersion: 'current'
// });
//
// window.bugsnagClient.use(bugsnagVue, Vue);

/**
 * Load the app
 */

require('./vue/app');
