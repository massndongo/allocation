/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
var $ = require('jquery');
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
$(document).ready(function(){


  
    $('#selection').change(function(){
      if ($('#selection').val()==='Non Loger') {
      $( ".adresse" ).append( '<input type="text" class="form-control input" name="adresse" id="adresse" placeholder="Adresse"><span id="adresse_error" class="font-weight-bold"></span>' );
    }else if ($('#selection').val()==='Loger' || $('#selection').val()==='Boursier'){
          $( ".adresse" ).append( '<input type="text" class="form-control input" name="montant" id="montant" placeholder="Montant Bourse"><span id="montant_error" class="font-weight-bold"></span>' );
        }
  });
          });
    