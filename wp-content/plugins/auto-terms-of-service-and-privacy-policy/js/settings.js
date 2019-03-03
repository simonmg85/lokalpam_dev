jQuery(document).ready(function () {
    var COUNTRIES = jQuery("[data-type='country-selector']");
    var LOCALES = [COUNTRIES.data('locale').split("_")[0]];
    var savedOptions = {};
    var selectedCountry = COUNTRIES.val();

    function sortSelect(selector, languages) {
        var el = jQuery(selector);
        var selected = el.val();
        var options = el.find("option");
        var arr = options.map(function (idx, x) {
            return [[x.innerText, x.value]];
        }).get();
        arr.sort(function (x, y) {
            return x[0].localeCompare(y[0], languages);
        });

        options.each(function (idx, x) {
            x.value = arr[idx][1];
            x.innerText = arr[idx][0];
        });
        el.val(selected);
    }

    var stateInput = jQuery("[data-type='state-selector']");
    var STATE_ROW = stateInput.parent().parent();
    savedOptions[selectedCountry] = stateInput.val();
    stateInput.parent().html(wp.template("wpautoterms-state-selector")({
        name: stateInput.attr("name"),
        id: stateInput.attr("id")
    }));
    stateInput = jQuery("[data-type='state-selector']");

    function updateStates() {
        var states = wpautotermsStates.states[COUNTRIES.val()];
        var state = stateInput.val();
        if (state !== null) {
            savedOptions[selectedCountry] = stateInput.val();
        }
        if (states.length < 1) {
            STATE_ROW.hide();
            stateInput.html("");
            stateInput.val("");
            return;
        }
        STATE_ROW.show();
        var options = states.map(function (x) {
            return '<option value="' + x + '">' + wpautotermsStates.translations[x] + '</option>';
        });
        selectedCountry = COUNTRIES.val();
        stateInput.html(options.join("\n"));
        sortSelect(stateInput, LOCALES);
        if (Object.keys(savedOptions).indexOf(selectedCountry) >= 0) {
            stateInput.val(savedOptions[selectedCountry]);
        } else {
            stateInput.val(stateInput.find("option:first").val());
        }
    }


    sortSelect(COUNTRIES, LOCALES);
    COUNTRIES.change(updateStates).trigger("change");
});
