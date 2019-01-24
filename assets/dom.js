setTimeout(function(){
    var loadingElement = document.getElementById('main-loading'),
        mainBodyElement = document.getElementById('main-body');

    mainBodyElement.style.display = 'block';
    loadingElement.style.display = 'none';
}, 1000);

setTimeout(function(){
    var newHeroTitle = document.createElement('h1');
    var newHeroTitleContent = document.createTextNode('Lider rynku o ugruntowanej pozycji');

    newHeroTitle.appendChild(newHeroTitleContent);

    var heroContainer = document.getElementById('hero');
    var heroTitle = heroContainer.getElementsByTagName('h1').namedItem('hero-title-1');

    var tmTitle =  document.createElement('h3');
    tmTitle.style.textAlign = 'center';
    tmTitle.appendChild(
        document.createTextNode(
            'Lider rynku o ugruntowanej pozycji - Klient w centrum uwagi'
        )
    );

    heroContainer.parentNode.insertBefore(tmTitle, heroContainer);
    heroContainer.replaceChild(newHeroTitle, heroTitle);


}, 3000);


setTimeout(function(){
    var newHeroTitle = document.createElement('h1');
    var newHeroTitleContent = document.createTextNode('Klient w centrum uwagi');

    newHeroTitle.appendChild(newHeroTitleContent);

    var heroContainer = document.getElementById('hero');
    var heroTitle = heroContainer.getElementsByTagName('h1').item(0);

    heroContainer.removeChild(heroTitle);
    heroContainer.appendChild(newHeroTitle);

}, 5000);


function inspect()
{
    console.log(document.images);

    var imagesCount = document.images.length,
        linksCount = document.links.length,
        formsCount = document.forms.length,
        anchorCount = document.anchors.length;

    alert(
        'Liczba obrazkow: ' + imagesCount +
        ', linków: ' + linksCount +
        ', form: ' + formsCount +
        ', anchorów: ' + anchorCount
    );
}

function reverseText()
{
    var articleBody = document.getElementById('article-body');
    articleBody.style.fontFamily = '"Times New Roman", Times, serif';
    articleBody.style.backgroundColor = '#f0f0f0';
    articleBody.style.color = '#5f6368';
}


document.addEventListener("DOMContentLoaded", function(event) {
    var heroContainer = document.getElementById('hero');

    heroContainer.onmousemove = function (e) {
        console.log('Uzytkownik przesuwa myszke w pozycji wg. browsera : x:{0},y:{1} oraz wg. ekranu: x:{2},y:{3}'.format(
            e.clientX, e.clientY, e.screenX, e.screenY)
        );
    };

    heroContainer.onmousedown = function (e) {
        console.log('%c Myszka zakończyła przesuwać', 'color: green');
    };

    heroContainer.onmouseover = function (e) {
        console.log('%c Myszka jest nad bannerem', 'color: blue');
    };

    heroContainer.onmouseout = function (e) {
        console.log('%c Myszka jest za granicą banera', 'color: red');
    };

    var cityHelpElement = document.getElementById('city-help'),
        citySelect = document.getElementById('city');

    citySelect.onfocus = function() {
        cityHelpElement.style.display = 'block';
    };

    citySelect.onblur = function() {
        cityHelpElement.style.display = 'none';
    };

    var orderForm = document.getElementById('order-form');

    orderForm.onsubmit = function (e) {
        var isContinue = window.confirm('Chcesz kontynuować?');
        if (!isContinue) {
            e.preventDefault();
        }
    }

    orderForm.onreset = function (e) {
        var isReset = window.confirm('Chcesz wyczyścić formularz?');
        if (!isReset) {
            e.preventDefault();
        }
    }

    var fullNameInput = document.getElementById('full-name');
    fullNameInput.addEventListener("keydown", function(e) {
        if (e.altKey) {
            console.log('%c Klient klika alt-a', 'color: blue');
        } else if (e.ctrlKey) {
            console.log('%c Klient klika ctrl-a', 'color: red');
        }  else if (e.shiftKey) {
            console.log('%c Klient klika shift-a', 'color: green');
        } else {
            console.log('Klient kliknął przycisk z kodem {0}'.format(e.keyCode));
        }
    });

});