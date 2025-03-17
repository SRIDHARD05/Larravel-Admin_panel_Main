import $ from 'jquery';
window.$ = window.jQuery = $;

import Swal from 'sweetalert2';
import _ from 'lodash';

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const css_modules = import.meta.glob('../css/*.css', { query: '?inline' });

for (const path in css_modules) {
    if (!path.includes('app.css')) {
        css_modules[path]().then((module) => {
            // console.log(`CSS Module ${path} loaded successfully`);
        }).catch((error) => {
            console.error(`Error loading CSS Module ${path}:`, error);
        });
    }
}


const js_modules = import.meta.glob('./*.js');
for (const path in js_modules) {
    js_modules[path]().then((module) => {
    //    console.log(`Module ${path} loaded successfully`);
    }).catch((error) => {
        console.error(`Error loading module ${path}:`, error);
    });
}

