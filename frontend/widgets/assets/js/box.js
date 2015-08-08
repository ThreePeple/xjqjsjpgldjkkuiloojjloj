
'use strict';

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
    throw new Error("requires jQuery");
}

/* boxWidget
 *
 * @type Object
 * @description $.boxWidget is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.boxWidget = {};
/* --------------------
 * - boxWidget Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.boxWidget.options = {
     //to allow boxes to be collapsed and/or removed
    enableBoxWidget: true,
    //Box Widget plugin options
    boxWidgetOptions: {
        boxWidgetIcons: {
            //The icon that triggers the collapse event
            collapse: 'fa fa-minus',
            //The icon that trigger the opening event
            open: 'fa fa-plus',
            //The icon that triggers the removing event
            remove: 'fa fa-times'
        },
        boxWidgetSelectors: {
            //Remove button selector
            remove: '[data-widget="remove"]',
            //Collapse button selector
            collapse: '[data-widget="collapse"]'
        }
    }
};
/* ------------------
 * - Implementation -
 * ------------------
 * The next block of code implements boxWidget's
 * functions and plugins as specified by the
 * options above.
 */
$(function () {
    //Easy access to options
    var o = $.boxWidget.options;

    //Activate box widget
    if (o.enableBoxWidget) {
        $.boxWidget.boxWidget.activate();
    }

     /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */
    $('.btn-group[data-toggle="btn-toggle"]').each(function () {
        var group = $(this);
        $(this).find(".btn").click(function (e) {
            group.find(".btn.active").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
        });

    });
});

/* BoxWidget
 * =========
 * BoxWidget is plugin to handle collapsing and
 * removing boxes from the screen.
 *
 * @type Object
 * @usage $.boxWidget.boxWidget.activate()
 *        Set all of your option in the main $.boxWidget.options object
 */
$.boxWidget.boxWidget = {
    activate: function () {
        var o = $.boxWidget.options;
        var _this = this;
        //Listen for collapse event triggers
        $(o.boxWidgetOptions.boxWidgetSelectors.collapse).click(function (e) {
            e.preventDefault();
            _this.collapse($(this));
        });

        //Listen for remove event triggers
        $(o.boxWidgetOptions.boxWidgetSelectors.remove).click(function (e) {
            e.preventDefault();
            _this.remove($(this));
        });
    },
    collapse: function (element) {
        //Find the box parent
        var box = element.parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            //Convert minus into plus
            element.children(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
            bf.slideUp(300, function () {
                box.addClass("collapsed-box");
            });
        } else {
            //Convert plus into minus
            element.children(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
            bf.slideDown(300, function () {
                box.removeClass("collapsed-box");
            });
        }
    },
    remove: function (element) {
        //Find the box parent
        var box = element.parents(".box").first();
        box.slideUp();
    },
    options: $.boxWidget.options.boxWidgetOptions
};

/*
 * BOX REFRESH BUTTON
 * ------------------
 * This is a custom plugin to use with the compenet BOX. It allows you to add
 * a refresh button to the box. It converts the box's state to a loading state.
 *
 * @type plugin
 * @usage $("#box-widget").boxRefresh( options );
 */
(function ($) {

    $.fn.boxRefresh = function (options) {

        // Render options
        var settings = $.extend({
            //Refressh button selector
            trigger: ".refresh-btn",
            //File source to be loaded (e.g: ajax/src.php)
            source: "",
            //Callbacks
            onLoadStart: function (box) {
            }, //Right after the button has been clicked
            onLoadDone: function (box) {
            } //When the source has been loaded

        }, options);

        //The overlay
        var overlay = $('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');

        return this.each(function () {
            //if a source is specified
            if (settings.source === "") {
                if (console) {
                    console.log("Please specify a source first - boxRefresh()");
                }
                return;
            }
            //the box
            var box = $(this);
            //the button
            var rBtn = box.find(settings.trigger).first();

            //On trigger click
            rBtn.click(function (e) {
                e.preventDefault();
                //Add loading overlay
                start(box);

                //Perform ajax call
                box.find(".box-body").load(settings.source, function () {
                    done(box);
                });
            });
            var callRightNow = function(){
                start(box);
                //Perform ajax call
                box.find(".box-body").load(settings.source, function () {
                    done(box);
                });
            }
        });

        function start(box) {
            //Add overlay and loading img
            box.append(overlay);

            settings.onLoadStart.call(box);
        }

        function done(box) {
            return;
            //Remove overlay and loading img
            box.find(overlay).remove();

            settings.onLoadDone.call(box);
        }

    };

})(jQuery);