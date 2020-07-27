let appLoader = {

    init: function(){
        var displayBtn = document.querySelector('#displayLoaderBtn');
        var loaderBox = document.querySelector('#loaderBox');
        
        displayBtn.onclick = function(){
            loaderBox.removeAttribute('hidden');
        }
    },
}

document.addEventListener('DOMContentLoaded', appLoader.init);