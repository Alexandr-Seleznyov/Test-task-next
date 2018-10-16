// Прелоадер
var startPreloader,
    stopPreloader;

$(document).ready(function() {
    var preload = document.createElement('div');
        preload.className = "preloader";
        preload.innerHTML = '<div class="b-ico-preloader"></div><div class="spinner"></div>';
        document.body.appendChild(preload);

    var preloaderElem = document.querySelector('.preloader');

    startPreloader = function(){
        preloaderElem.style.display = '';
        preloaderElem.classList.remove('fade');
    };

    stopPreloader = function(){
        // preload.className +=  ' fade';
        preloaderElem.classList.add('fade');
        setTimeout(function(){
            preloaderElem.style.display = 'none';
        },100);
    };

    stopPreloader();
});