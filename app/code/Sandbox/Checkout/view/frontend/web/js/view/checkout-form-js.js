define([
        'ko',
        'uiComponent'
    ], function (ko, Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Sandbox_Checkout/checkout-form'
            },
            isRegisterNewsletter: false,
        });
    }
);
