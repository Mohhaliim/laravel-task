window.featureChecked = function (featureLength) {
    let totalFeature = $(".feature:checkbox").length;
    if (featureLength === totalFeature) {
        $("#featureAll").prop("checked", true);
    } else {
        $("#featureAll").prop("checked", false);
    }
};

document.addEventListener("turbo:load", loadPlanCreateEditData);

function loadPlanCreateEditData() {
    let featureLength = $(".feature:checkbox:checked").length;
    featureChecked(featureLength);
}

listenClick("#featureAll", function () {
    if ($("#featureAll").is(":checked")) {
        $(".feature").each(function () {
            $(this).prop("checked", true);
        });
    } else {
        $(".feature").each(function () {
            $(this).prop("checked", false);
        });
    }
});
listenClick(".feature", function () {
    let featureLength = $(".feature:checkbox:checked").length;
    featureChecked(featureLength);
});

listenClick(".screen.image", function () {
    let template = $(this).prev();
    let defaultValue = template[0].defaultValue;

    if (template.is(":checked")) {
        if (defaultValue == 22) {
            template.prop("checked", false);
            $(this).removeClass("template-border");
            $("input[name='dynamic_vcard']").prop("checked", false);
        } else {
            template.prop("checked", false);
            $(this).removeClass("template-border");
        }
    } else {
        template.prop("checked", true);
        $(this).addClass("template-border");

        if (defaultValue == 22) {
            $("input[name='dynamic_vcard']").prop("checked", true);
        }
    }

    let allFeaturesChecked = $(".feature:checkbox").length === $(".feature:checkbox:checked").length;

    if (template.is(":checked") && $("input[name='dynamic_vcard']").prop("checked") && allFeaturesChecked) {
        $("#featureAll").prop("checked", true);
    } else {
        $("#featureAll").prop("checked", false);
    }
});

listenClick("#isTrial", function () {
    if ($(this).is(":checked")) {
        $("#duration_type").val(1).trigger("change");
        $("#price").val(0);
        $("#duration_type, #price").prop("disabled", true);
    } else {
        $("#price").val("");
        $("#duration_type, #price").prop("disabled", false);
    }
});

listenClick("#planFormSubmit", function (e) {
    if (!$(".templateIds").is(":checked")) {
        displayErrorMessage(Lang.get("js.multi_templates"));
        return false;
    } else if (!$(".feature").is(":checked")) {
        displayErrorMessage(
            Lang.get("js.select_one_or_more")
        );
        return false;
    }
});
