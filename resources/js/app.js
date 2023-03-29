

require('./bootstrap');

// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();
import Vue from 'vue/dist/vue';
import convertToDay from './filters/convert-to-day-moment'
import timeConversion from './filters/time-conversion'
import unixTimeConversion from './filters/unix-time-conversion'
import ResizeImage from './filters/resize-image'
import Language from './filters/language'
import StarRating from './filters/star-rating'
import Elapsed from './filters/elapsed'
import 'sweetalert2/dist/sweetalert2.min.css';
import VueSweetalert2 from 'vue-sweetalert2';

import trans from './trans';
Vue.prototype.trans = trans;
Vue.use(VueSweetalert2);
window.Vue = new Vue;
window.moment = require('moment');
// import swal from 'sweetalert';
// window.$swal = swal;

//  var languages=window.Laravel.languages;
//  jQuery.each(languages, function(i, field) {
//     console.log(field.short_code);
//     import ar from '../lang/`${field.short_code}.json'

// });
import ar from '../lang/ar.json'
import en from '../lang/en.json'
import ru from '../lang/ru.json'
import ur from '../lang/ur.json'
import hi from '../lang/hi.json'

window.translate = {'ar':ar, 'en':en  , 'ru':ru, 'ur':ur ,'hi':hi};


Vue.filter('convertToDay', convertToDay);
Vue.filter('timeConversion', timeConversion);
Vue.filter('unixTimeConversion', unixTimeConversion);
Vue.filter('resizeImage', ResizeImage);
Vue.filter('language', Language);
Vue.filter('starRating', StarRating);
Vue.filter('elapsed', Elapsed);

Vue.component('chats', require('./components/chats.vue').default);
Vue.component('no-data', require('./components/no-data.vue').default);
Vue.component('messages', require('./components/messages.vue').default);



Vue.component('notifications', require('./components/notification/notifications.vue').default);



const app = new Vue({
    el: '#main-app',
    data: {
        // showBookingBreadCrumbs:true,
        showNotifications:false,
    },
});
