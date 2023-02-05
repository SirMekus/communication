import { on, registerEventListeners, lazyLoadImages } from "mmuo"
import * as bootstrap from '~bootstrap';
import axios from 'axios';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.addEventListener("DOMContentLoaded", function() {
    registerEventListeners()
    lazyLoadImages()

    document.addEventListener('like', (response) => {
        document.querySelector("#likes").innerHTML = response.detail.data;
    });

    on('#comment', 'click', function(event){
        event.preventDefault();
        const element = document.getElementById("form");
        element.scrollIntoView();
    })
    
}, false);


try {
window.bootstrap =  bootstrap;
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';