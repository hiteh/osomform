"use strict";

(function ($) {
  $('html').removeClass('no-js'); // Variables

  var form = $("#osomform");
  var button = form.find("#osomform-send");
  var inputs = form.find("input,select").not(":input[type=button], :input[type=submit]");
  var consent = $("#consent");
  var errors = [];
  var payload = {};
  var endpoint = wpApiSettings.root + 'osomform/v1/osomcontact'; // Set errors

  var setErrors = function setErrors(test, element) {
    if (test) {
      element.addClass("invalid");
      element.attr("aria-invalid", true);

      if (!errors.includes(element.attr("name"))) {
        errors.push(element.attr("name"));
      }
    } else {
      element.removeClass("invalid");
      element.attr("aria-invalid", false);
      errors = errors.filter(function (value) {
        return value !== element.attr("name");
      });
    }
  }; // Validate input


  var validateInput = function validateInput(element) {
    var type = element.attr("type");
    var value = element.val();
    var name = element.attr("name");

    switch (type) {
      case "text":
        var pattern_t = "";

        if ("login" === name) {
          pattern_t = new RegExp(/[^a-z0-9]/);
        } else {
          pattern_t = new RegExp(/[^-AaĄąBbCcĆćDdEeĘęFfGgHhIiJjKkLlŁłMmNnŃńOoÓóPpQqRrSsŚśTtUuWwVvXxYyZzŹźŻż]/);
        }

        setErrors(pattern_t.test(value), element);
        break;

      case "email":
        var pattern_e = new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
        setErrors(!pattern_e.test(value), element);
        break;

      default:
        element.removeClass("invalid");
        element.attr("aria-invalid", false);
    }
  }; // Prepare payload data


  var preparePayload = function preparePayload() {
    inputs.each(function (index, input) {
      var element = $(input);
      payload[element.attr("name")] = element.val();
    });
  }; // Send request


  var sendRequest = function sendRequest(method, endpoint, payload) {
    $.ajax({
      url: endpoint,
      method: method,
      dataType: 'json',
      beforeSend: function beforeSend(xhr) {
        xhr.setRequestHeader("X-WP-Nonce", wpApiSettings.nonce);
      },
      data: payload
    }).done(function (response) {
      alert(response.message);
      inputs.each(function (index, input) {
        var $target = $(input);
        !$target.is("select") ? $target.val('') : '';
      });
    }).fail(function (response) {
      alert(response.error);
    });
  }; // Validate form inputs on value change event


  inputs.each(function (index, input) {
    $(input).on("input", function (e) {
      var target = $(e.target);
      validateInput(target);
    });
  }); // Enable/disable button on consent checkbox change event

  consent.on("change", function (e) {
    var checked = $(e.target).prop("checked");
    checked ? button.prop("disabled", false) : button.prop("disabled", true);
  }); // Validate inputs and send request on click

  button.on("click", function (e) {
    e.preventDefault();
    inputs.each(function (index, input) {
      var target = $(input);
      validateInput(target);
      "" === target.val() ? setErrors(true, target) : "";
    });

    if (errors.length > 0) {
      return;
    }

    preparePayload();
    sendRequest("POST", endpoint, payload);
    e.preventDefault();
  });
})(jQuery);