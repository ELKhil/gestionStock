/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import 'bootstrap/dist/js/bootstrap.min.js'

import  'jquery/dist/jquery.min.js';

import 'select2/dist/js/select2.min.js';


// start the Stimulus application
import './bootstrap';



const mainNav = document.getElementById('main-nav');
const menuBtn = document.querySelector(".left");
const toggleNav = e => {
    mainNav.classList.toggle('open');
}

$('.select2').select2()

menuBtn.addEventListener('click', toggleNav);








