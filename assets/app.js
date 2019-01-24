var feedbackPromptContent = 'Jaką masz opinję o "Laptop Asus"?',
    feedbacks = [];

String.prototype.format = function() {
    var formatted = this;
    for( var arg in arguments ) {
        formatted = formatted.replace("{" + arg + "}", arguments[arg]);
    }

    return formatted;
};


document.addEventListener("DOMContentLoaded", function(event) {
    var errors = document.getElementById('alert-error');
    if (errors.childNodes.length < 2) {
        errors.innerHTML = '';
    }


    var generateDiscountBtn = document.getElementById('generate-discount');

    generateDiscountBtn.onclick = function() {
        var priceNode = document.getElementById('item-price');
        var price = parseInt(priceNode.innerHTML);
        var discount = Math.floor(Math.random() * price) + 1;

        if(discount > 0) {
            alert('Gratulacje! Dostałesz {0}zł rabatu!'.format(discount));
            priceNode.innerHTML = price - discount;
            this.style.display = 'none';
        }
    };

    var addFeedback = document.getElementById('add-feedback');

    addFeedback.onclick = function() {
        var answer = window.prompt(feedbackPromptContent);
        feedbacks.push(answer);
        window.alert('Twoja opinja "{0}" została zapisana'.format(answer));
        renderFeedbacks();
    };

});


function renderFeedbacks()
{
    var feedbacksCount = document.getElementById('feedback-count');
    feedbacksCount.innerHTML = feedbacks.length.toString();

    var feedbacksContainer = document.getElementById('feedback-container');
    feedbacksContainer.innerHTML = '';

    for (var i = feedbacks.length - 1; i >= 0; i--) {
        var feedbackElement = document.createElement('p');
        feedbackElement.appendChild(document.createTextNode(feedbacks[i]));
        feedbacksContainer.appendChild(feedbackElement);
    }
}

