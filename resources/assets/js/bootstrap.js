/**
 * Load the Lodash library
 */
 window._ = require('lodash');

/**
 * Load jQuery and the Bootstrap jQuery 
 */
try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    require('bootstrap');
} catch (e) {}

/**
 * Load the axios HTTP library 
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosDefaults.baseURL = 'http://lrecom.local';

/**
 * Register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. 
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });
