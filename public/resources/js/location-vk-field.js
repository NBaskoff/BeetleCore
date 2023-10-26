(function (jQuery) {
    jQuery.fn.locationVKField = function () {
        function main(box) {
            let locationVKBox = box;

            jQuery(".country-select", locationVKBox).change(function () {
                let country_text = jQuery(this).find("option:selected").text();
                jQuery(".country-text", locationVKBox).text(country_text);
                jQuery(".city-text", locationVKBox).text("Не выбрано");
                jQuery("input[name=country_title]", locationVKBox).val(country_text);
                jQuery("input[name=city_id]", locationVKBox).val(0);
                jQuery("input[name=city_title]", locationVKBox).val("");
                jQuery(".city-find", locationVKBox).val("");
            });

            jQuery(".city-find", locationVKBox).autocomplete({
                minChars: 3,
                serviceUrl: "/admin/system/location/city",
                type: "POST",
                noCache: true,
                onSearchStart: function (params) {
                    jQuery(".load-progress", locationVKBox).css("display", "block");
                    params.countryId = jQuery("select[name=country_id]", locationVKBox).val();
                },
                onSearchComplete: function (params) {
                    jQuery(".load-progress", locationVKBox).css("display", "none");
                },
                onSelect: function (suggestion) {
                    jQuery(".city-text", locationVKBox).text(suggestion.value);
                    jQuery("input[name=city_id]", locationVKBox).val(suggestion.id);
                    jQuery("input[name=city_title]", locationVKBox).val(suggestion.value);
                }
            });

            jQuery(".admin-field-location-vk-box .clear-select", locationVKBox).click(function () {
                //jQuery(".country-text", locationVKBox).text("");
                jQuery(".city-text", locationVKBox).text("Не выбрано");
                //jQuery("input[name=country_title]", locationVKBox).val(country_text);
                jQuery("input[name=city_id]", locationVKBox).val(0);
                jQuery("input[name=city_title]", locationVKBox).val("");
                jQuery(".city-find", locationVKBox).val("");
            });

            jQuery(".user-find-form .city-find").on("keyup change", function () {
                if (jQuery(this).val() == "") {
                    jQuery("input[name=city_id]", locationVKBox).val(0);
                    jQuery("input[name=city_title]", locationVKBox).val("");
                }
            });
        }

        this.each(function () {
            main(jQuery(this));
        });
        return this;
    };

})(jQuery);

