(function(_exportName_) {
    var console = ZSYFCEditorUtil.console;
    // Object-collector factory
    var objectCollector_ = window["FCObjectCollector"]; 

    var which_ = function ( originRect, destRect ){ 
        var which = ['l', 'b'];

        /**
         *      target location:
         *
         *                   |
         *      top-left     |     top-right
         *                   |
         *     ---------------------------------
         *                   |
         *      bottom-left  |     bottom-right
         *                   |
         *
         *
         */

        // Fixed locatioin
        // -- source >>
        if (originRect[0] > destRect[0]) {
            which[0] = 'l';
        } else {
            if (originRect[0] <= destRect[0] + destRect[2] && originRect[0] >= destRect[0] - destRect[2]) {
                which[0] = 't';
                if (originRect[1] < destRect[1]) {
                    which[0] = 'b';
                }
            } else {
                which[0] = 'r';
            }
        }

        // -- target >>
        if (originRect[1] > destRect[1]) {
            which[1] = 'b';
        } else {
            if (originRect[1] <= destRect[1] + destRect[3] && originRect[1] >= destRect[1] - destRect[3]) {
                which[1] = 'l';
                if (originRect[0] > destRect[0]) {
                    which[1] = 'r';
                }
            } else {
                which[1] = 't';
            }
        }
        console.log('|> Link Points: ', which);
        return which;
    };





    var linePathPosition_ = {
        "findShapeHelper": function(sourceD, targetD) {
            var sourceShape = objectCollector_.get(sourceD),
                targetShape = objectCollector_.get(targetD); 

            var which = ['l', 'b']; 

            which = which_( 
                            [ sourceShape.cx(), sourceShape.cy(), sourceShape.rx(), sourceShape.ry() ], 
                            [ targetShape.cx(), targetShape.cy(), targetShape.rx(), targetShape.ry() ] );

            console.log('|> Link Points(Shape): ', which);
            return which;
        },
        "findHelper": function ( originRect, destRect  ){
          var which = ['l', 'b']; 

            which = which_( originRect, 
                            destRect );

            console.log('|> Link Points: ', which);
            return which;
        }
    };
    window[_exportName_] = linePathPosition_;
})("FCLinePathPosition");