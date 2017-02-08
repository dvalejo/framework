
function setInputHandlers(data) {
    for (var i = 0, len = data.length; i < len; i++) {
        var input = document.querySelector(data[i].input),
            output = document.querySelector(data[i].output),
            error = data[i].error;

        (function (output, error) {
            input.addEventListener('blur', function () {
                validate(event, output, error);
            }, false);
        })(output, error);
    }
}

function validate(event, output, error) {
    if ( ! event.target.value) {
        event.target.classList.add('form__input_type_error');
        output.innerHTML = error;
    } else {
        event.target.classList.remove('form__input_type_error');
        output.innerHTML = '';
    }
}

var obj = [
    {
        input: '.js-banner-project-input',
        output: '.js-banner-project-output',
        error: 'Please enter a banner project'
    },
    {
        input: '.js-banner-type-input',
        output: '.js-banner-type-output',
        error: 'Please select a banner type'
    },
    {
        input: '.js-banner-width-input',
        output: '.js-banner-width-output',
        error: 'Please enter a banner width'
    },
    {
        input: '.js-banner-height-input',
        output: '.js-banner-height-output',
        error: 'Please enter a banner height'
    }
];
setInputHandlers(obj);