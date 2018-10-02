/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';

window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':' + window.App.ECHO_PORT,
    auth: {
        headers: {
            Authorization: 'Bearer ' + window.App.ECHO_KEY,
        },
    },
});