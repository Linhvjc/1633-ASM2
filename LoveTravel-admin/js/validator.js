// Đối tượng

function Validator(options) {

    var selectorRules = {};

    // Hàm thực hiện validate
    function validate(inputElement, rule) {
        var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
        var errorMessage;
                    
        var rules = selectorRules[rule.selector];

        for (var i =0; i <rules.length ; i++) {
            errorMessage= rules[i](inputElement.value);
            if (errorMessage) break;
        }
        
        if (errorMessage) {
            errorElement.innerText = errorMessage;
            inputElement.classList.add('invalid');
        } else {
            errorElement.innerText = '';
            inputElement.classList.remove('invalid');
        }
    }


    // lấy element của form cần validate
    var formElement = document.querySelector(options.form);

    if (formElement) {
        formElement.onsubmit = function (e) {

            // Lặp qua từng rules và validate
            options.rules.forEach(function (rule) {
                var inputElement = formElement.querySelector(rule.selector);
                validate(inputElement, rule);
            });
        }
        // lặp qua mỗi rule và xử lý
        options.rules.forEach(function (rule) {
            // Lưu lại các rules
            if (Array.isArray(selectorRules[rule.selector])) {
                selectorRules[rule.selector].push(rule.test);
            } else {
                selectorRules[rule.selector] = [rule.test];                
            }
        


            var inputElement = formElement.querySelector(rule.selector);

            if(inputElement) {
                // xử lý trường hợp blur khỏi input
                inputElement.onblur = function() {
                    
                    validate(inputElement, rule);
                    
                }

                // xử lí mỗi khi người dùng nhập vào input

                inputElement.oninput = function() {
                    var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
                    errorElement.innerText = '';
                    inputElement.classList.remove('invalid');   
                }
            }

        });

    }
}




// định nghĩa rules
// Nguyen tac cua rule
// 1. khi co loi => message loi
// 2 hop le => ko cos gi
Validator.isRequired = function(selector, message) {
    return {
        selector: selector,
        test: function(value) {
            return value.trim() ? undefined : message || 'You must fill in this required field';
        }
    }
}

Validator.isEmail = function(selector, message) {
    return {
        selector: selector,
        test: function(value) {
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(value) ? undefined : message || 'This field must be an email'
        }
    }
}

Validator.minLength = function(selector, min, message) {
    return {
        selector: selector,
        test: function(value) {
            return value.length >= min ? undefined : message || `You must enter at least ${min} characters`;
        }
    }
}


Validator.isConfirmed = function (selector, getCofirmValue, message) {
    return {
        selector: selector ,
        test: function(value) {
            return value === getCofirmValue() ? undefined : message || 'The value entered is incorrect';
        }
    }
}

