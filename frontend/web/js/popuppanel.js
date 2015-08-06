/**
 * PopupPanel Class
 * @Author 		jimmypan
 * @Date 		2012-11-23
 * @Description a widget of PopupPanel.
 * @require
 * 		removeSWFSafe.js
 * @log
 * 		2013/6/25 ADD 支持智能边界定位功能
 */

;
(function(_namespace_, WIN, undefined) {




    // selectors
    function focusable(element, isTabIndexNotNaN) {
        var map, mapName, img,
            nodeName = element.nodeName.toLowerCase();
        if ("area" === nodeName) {
            map = element.parentNode;
            mapName = map.name;
            if (!element.href || !mapName || map.nodeName.toLowerCase() !== "map") {
                return false;
            }
            img = $("img[usemap=#" + mapName + "]")[0];
            return !!img && visible(img);
        }
        return (/input|select|textarea|button|object/.test(nodeName) ?
                !element.disabled :
                "a" === nodeName ?
                element.href || isTabIndexNotNaN :
                isTabIndexNotNaN) &&
            // the element and all of its ancestors must be visible
            visible(element);
    }

    function visible(element) {
        return $.expr.filters.visible(element) &&
            !$(element).parents().addBack().filter(function() {
                return $.css(this, "visibility") === "hidden";
            }).length;
    }

    $.extend($.expr[":"], {
        data: $.expr.createPseudo ?
            $.expr.createPseudo(function(dataName) {
                return function(elem) {
                    return !!$.data(elem, dataName);
                };
            }) :
        // support: jQuery <1.8
        function(elem, i, match) {
            return !!$.data(elem, match[3]);
        },

        focusable: function(element) {
            return focusable(element, !isNaN($.attr(element, "tabindex")));
        },

        tabbable: function(element) {
            var tabIndex = $.attr(element, "tabindex"),
                isTabIndexNaN = isNaN(tabIndex);
            return (isTabIndexNaN || tabIndex >= 0) && focusable(element, !isTabIndexNaN);
        }
    });

    // Remove swf safely.
    var removeSWFSafe;

    ;
    (function(undefined) {
        /**
         * removeSWFSafe function
         * @description remove flash safe( special for IE ).
         */

        var UNDEF = "undefined",
            OBJECT = "object",
            SHOCKWAVE_FLASH = "Shockwave Flash",
            SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
            FLASH_MIME_TYPE = "application/x-shockwave-flash",
            EXPRESS_INSTALL_ID = "SWFObjectExprInst",
            ON_READY_STATE_CHANGE = "onreadystatechange",

            win = window,
            doc = document,
            nav = navigator,

            /* Centralized function for browser feature detection
			- User agent string detection is only used when no good alternative is possible
			- Is executed directly for optimal performance
		*/
            ua = function() {
                var w3cdom = typeof doc.getElementById != UNDEF && typeof doc.getElementsByTagName != UNDEF && typeof doc.createElement != UNDEF,
                    u = nav.userAgent.toLowerCase(),
                    p = nav.platform.toLowerCase(),
                    windows = p ? /win/.test(p) : /win/.test(u),
                    mac = p ? /mac/.test(p) : /mac/.test(u),
                    webkit = /webkit/.test(u) ? parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, // returns either the webkit version or false if not webkit
                    ie = !+"\v1", // feature detection based on Andrea Giammarchi's solution: http://webreflection.blogspot.com/2009/01/32-bytes-to-know-if-your-browser-is-ie.html
                    playerVersion = [0, 0, 0],
                    d = null;
                if (typeof nav.plugins != UNDEF && typeof nav.plugins[SHOCKWAVE_FLASH] == OBJECT) {
                    d = nav.plugins[SHOCKWAVE_FLASH].description;
                    if (d && !(typeof nav.mimeTypes != UNDEF && nav.mimeTypes[FLASH_MIME_TYPE] && !nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)) { // navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin indicates whether plug-ins are enabled or disabled in Safari 3+
                        plugin = true;
                        ie = false; // cascaded feature detection for Internet Explorer
                        d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
                        playerVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
                        playerVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
                        playerVersion[2] = /[a-zA-Z]/.test(d) ? parseInt(d.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0;
                    }
                } else if (typeof win.ActiveXObject != UNDEF) {
                    try {
                        var a = new ActiveXObject(SHOCKWAVE_FLASH_AX);
                        if (a) { // a will return null when ActiveX is disabled
                            d = a.GetVariable("$version");
                            if (d) {
                                ie = true; // cascaded feature detection for Internet Explorer
                                d = d.split(" ")[1].split(",");
                                playerVersion = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
                            }
                        }
                    } catch (e) {}
                }
                return {
                    w3: w3cdom,
                    pv: playerVersion,
                    wk: webkit,
                    ie: ie,
                    win: windows,
                    mac: mac
                };
            }();

        function removeSWF(obj) {
            if (obj && obj.nodeName == "OBJECT") {
                // window IE.
                if (ua.ie && ua.win) {
                    // remove flash safe ( IE )
                    obj.style.display = "none";
                    (function() {
                        if (obj.readyState == 4) {
                            removeObjectInIE(obj);
                        } else {
                            setTimeout(arguments.callee, 10);
                        }
                    })();

                } else {
                    // remove obj
                    obj.parentNode.removeChild(obj);

                }
            }
        }

        function removeObjectInIE(obj) {
            if (obj) {
                for (var i in obj) {
                    if (typeof obj[i] == "function") {
                        obj[i] = null;
                    }
                }
                obj.parentNode.removeChild(obj);
            }
        }
        // Fixed IE : remove flash before window:close / panel:hide / dilaog:close , etc.
        var __removeFlashs = function($iframe) { // iframe or object.
            $iframe.each(function() {
                var $_elem = $(this);
                if ($_elem.is('object')) { // object.
                    removeSWF(this);
                } else { // iframe.
                    $_elem.contents().find('object').each(function() {
                        removeSWF(this);
                    });
                }
            });
        };

        /**
         * @param { jQuery_object | DOM_object } obj
         * obj = $('iframe') | flashObj.
         */

        removeSWFSafe = function(obj) {
            if (obj && obj.jquery) { // is jQuery Object.
                __removeFlashs(obj);
            } else // is DOM , flash object.
                removeSWF(obj);
        };

    })();

    // Get page active element.
    var _activeElement = function(doc) {
        try {
            return doc.activeElement;
        } catch (e) {

        }
    };

    // Exclude current popwin case.
    var _retrieveValidActiveElement = function(popwinInstance) {
        var ele = _activeElement(popwinInstance.DOC_);
        if (!$.contains(popwinInstance._$['PopupPanel'][0], ele)) {
            ele = popwinInstance.DOC_;
        }
        return $(ele);
    };

    //******* common functions OR  vars.

    var UNDF = void 0;
    var emptyFn = function() {};
    var isFunc = function(f) {
        return typeof f == 'function';
    };

    var console = window.console ? window.console : {
        log: function() {}
    };

    // only register once.(For all PopupPanel insts)
    var bindOneEvent = function() {
        var popAllInst = function() {
            var insts = PopupPanel._instances;
            //console.log(insts.length);
            if (insts.length == 0)
                return;
            try {
                var i = 0;
                while (insts.length) {
                    ++i;
                    //console.log(++i);
                    insts.pop().close(); //trigger close event.
                }
                // Fixed: IE strange problem 
                // 	Apply Case: Removing parent elements from iframe window will happen some weird result . )
                if (typeof AllYesFactory != 'undefined' && AllYesFactory.elemHandlerProxy) {
                    AllYesFactory.elemHandlerProxy(emptyFn);
                }

                // console.log('Close popuppanel(s) count:', i);
            } catch (e) {
                console.log('Close popuppanel(s) exception:', e);
            }
        };

        $(window).bind("handler.popuppanel", function(e) {
            popAllInst();
        });

        //document mousedown
        $(document).bind('mousedown.popuppanel', function(e) {
            $(window).trigger("handler.popuppanel");
        });
        //window resize
        $(window).bind('resize.popuppanel', function(e) {
            $(window).trigger("handler.popuppanel");
        });
    };

    // Opt position handler
    // Date 2013/6/24, by jimmypan fixed: make popup-win inside window-viewport.
    // NOTE: 处理window viewport不足够大时，优先显示的边界（left, top, right, bottom)
    //		 !left : 优先显示左边界（先处理右边界定位，然后再左边界ensure，以此达到优先定位左边界）
    var _optPosition = (function() {
        // get document scroll left/top and width/height now. 
        var _getViewportData = function() {
            var $doc = $(document),
                $win = $(window);
            return {
                left: $doc.scrollLeft(),
                top: $doc.scrollTop(),
                width: $win.width(),
                height: $win.height()
            };
        };

        // ensure value.
        var _ensureForceOptPositionValue = function(obj, name, defaultValue) {
            if (typeof obj[name] != 'string' || obj[name] === "") {
                obj[name] = defaultValue;
            }
        };

        var _factor = {
            'left': function(_obj, _base) {
                var x = _obj['x'];
                _obj['x'] = x < _base.left ? _base.left : x;
            },
            'right': function(_obj, _base) {
                var x = _obj['x'],
                    w = _obj['width'];
                _obj['x'] = _base.left + _base.width < x + w ? _base.left + _base.width - w : x;
            },
            'top': function(_obj, _base) {
                var y = _obj['y'];
                _obj['y'] = y < _base.top ? _base.top : y;
            },
            'bottom': function(_obj, _base) {
                var y = _obj['y'],
                    h = _obj['height'];
                _obj['y'] = _base.top + _base.height < y + h ? _base.top + _base.height - h : y;
            }
        };

        var _handle = {
            '!left': function(_objData) {
                var _base = _getViewportData();
                _factor['right'](_objData, _base);
                _factor['left'](_objData, _base);
            },
            '!right': function(_objData) {
                var _base = _getViewportData();
                _factor['left'](_objData, _base);
                _factor['right'](_objData, _base);
            },
            '!top': function(_objData) {
                var _base = _getViewportData();
                _factor['bottom'](_objData, _base);
                _factor['top'](_objData, _base);
            },
            '!bottom': function(_objData) {
                var _base = _getViewportData();
                _factor['top'](_objData, _base);
                _factor['bottom'](_objData, _base);
            }
        };

        return {
            optXY: function(_objData, config) {
                forceOptPosition = config.forceOptPosition;
                var _optParams = {
                    'x': forceOptPosition[0],
                    'y': forceOptPosition[1]
                };
                // ensure value, if not set, then using default.
                _ensureForceOptPositionValue(_optParams, 'x', '!left');
                _ensureForceOptPositionValue(_optParams, 'y', '!top');
                _handle[_optParams['x']](_objData);
                _handle[_optParams['y']](_objData);
                return {
                    x: _objData['x'],
                    y: _objData['y']
                };
            }

        };

    })();

    // PopupPanel inst bind
    var bindEvent = function() {
        this._$['PopupPanel'].mousedown({
            inst: this
        }, function(e) {
            //PopupPanel.clearExcludeLast(e.data.inst);
            e.stopPropagation();
        });
    };

    var addMethod = function(name, handler) {
        PopupPanel.prototype[name] = handler;
    };

    var TPL = '<div class="jppopuppanel">{content}</div>';

    var hasBuildPopupPanel = false;

    /**
     * PopupPanel Class
     */
    var PopupPanel = function(config) {
        this.DOC_ = WIN["document"];
        this.$activeElement = this.DOC_;
        this.$container = 'body'; //config.container || 'body';
        this.content = config.content || '';
        this._destroy = config.destroy || false;
        this.className = config.className || '';
        this.initInterface = config.initInterface;
        this.onOpen = config.onOpen || function() {};
        this.closeHandler = config.closeHandler;
        this.animateOn = config.animate === false ? false : true;
        this.offsetX = config.offsetX == UNDF ? 15 : config.offsetX;
        this.offsetY = config.offsetY == UNDF ? 10 : config.offsetY;
        // 强制优化 Popup Panel, 
        // 建议非特殊情况勿设置
        // 默认为：
        //			左对齐: 在window viewport不足够大时，优先显示的边界
        //			上对齐：｛如上｝
        // 值形式：
        // 			[ '!left', '!top' ], [ '!left', '!bottom' ], [ '!right', '!top' ], [ '!right', '!bottom' ]
        this.forceOptPosition = config.forceOptPosition || [];
        this._$ = {};
        this._inited = false;

        /************************************
         *	仅在PopupPanel实例化，才初始化的events.
         ***********************************/
        if (hasBuildPopupPanel === false) {
            bindOneEvent();
            hasBuildPopupPanel = true;
        }
    };

    //### add methods
    //init
    addMethod('init', function() {
        if (this._inited === true) //avoid re-inited.
            return this;

        try {

            this._inited = true;
            var tpl = TPL.replace('{content}', this.content);
            var $elem = $(tpl);

            if (this.className) {
                $elem.addClass(this.className);
            }

            this._$['PopupPanel'] = $elem;

            this._$['PopupPanel'].hide().appendTo(this.$container);

            if (isFunc(this.initInterface)) {
                this.initInterface.call(this, this._$['PopupPanel']);
            }

            bindEvent.call(this);

            this.onOpen.call(this, this._$['PopupPanel']);

        } catch (e) {
            console.log('PopupPanel init:', e);
            this._inited = false;
        }

        PopupPanel.addInstance(this);
        return this;
    });
    //show 
    addMethod('show', function(x, y) {
        if (!this._inited) {
            console.log('show:init first.');
            return this;
        }

        this.$activeElement = _retrieveValidActiveElement(this);
        if (x != UNDF && y != UNDF) {
            this._x = x;
            this._y = y;
            var docW = $(document).width();
            var docH = $(document).height();
            var $popup = this._$['PopupPanel'];
            var ox = this.offsetX;
            var oy = this.offsetY;

            if (x + ox + $popup.width() > docW) {
                x -= $popup.width() + ox;
                if (x < 0) {
                    x = 0;
                }
            } else {
                x += ox;
            }
            if (y + oy + $popup.height() > docH) {
                y -= $popup.height() + oy;
                if (y < 0) {
                    y = 0;
                }
            } else {
                y += oy;
            }
            // opt position.
            var _optxy = _optPosition.optXY({
                x: x,
                y: y,
                width: $popup.outerWidth(),
                height: $popup.outerHeight()

            }, {
                forceOptPosition: this.forceOptPosition
            });

            x = _optxy.x;
            y = _optxy.y;

            $popup.css({
                left: x,
                top: y
            });

            if (this.animateOn) {
                $popup.fadeIn('fast');
            } else {
                $popup.show();
            }
        } else {
            console.log('PopupPanel show:invalid arguments.');
        }
        return this;
    });

    // refresh position

    addMethod('refresh', function(x, y) {
        if (!this._inited) {
            console.log('refresh:init first.');
            return this;
        }
        if (x != UNDF && y != UNDF) {
            this.show(x, y);
        } else
        if (this._x != UNDF && this._y != UNDF) {
            this.show(this._x, this._y);
        }
        return this;
    });

    //close 
    addMethod('close', function() {
        if (!this._inited) {
            console.log('close:init first.');
            return this;
        }
        var self = this;
        var _returnFocusEle = function() {
            // console.log(self.$activeElement, self.$activeElement.filter(":focusable").length);
            if (!self.$activeElement.filter(":focusable").focus().length) {
                // Hiding a focused element doesn't trigger blur in WebKit
                // so in case we have nothing to focus on, explicitly blur the active element
                // https://bugs.webkit.org/show_bug.cgi?id=47182
                $(_activeElement(self.DOC_)).blur();
            }
        };
        // Custom close handler.
        if (isFunc(this.closeHandler)) {
            var r = this.closeHandler( /*_returnFocusEle*/ ); // Refocus element( which is focused before popup panel ) handler.
            if (r === false) //cancel close.
                return this;
        }

        var clearSome = function() {
            var $this = self._$['PopupPanel'];
            // remove iframe and object first ( fixed IE bug. )
            try {

                $this.css('visibility', 'hidden');
                removeSWFSafe($this.find('iframe, object'));
                $this.remove();

                // Focus page element.
                setTimeout(_returnFocusEle, 0);
            } catch (e) {

            }
            console.log('close method: destroy PopupPanel( DO NOT call again ).');
        };
        if (this._destroy !== true) {
            if (!self.animateOn) {
                self._$['PopupPanel'].hide();
            } else {
                self._$['PopupPanel'].fadeOut('fast'); //hide ,not remove. NOTE: avoid reflow( css ). 
            }
            // Focus page element.
            setTimeout(_returnFocusEle, 0);
        } else {
            PopupPanel.delInstance(self); //remove inst from global instances. 
            if (!self.animateOn) {
                clearSome();
            } else {
                self._$['PopupPanel'].fadeOut('fast', function() {
                    clearSome();
                }); //hide ,not remove. NOTE: avoid reflow( css ). 
            }
        }
        return self;
    });

    /////////////////////////////////////
    //static methods.
    PopupPanel._instances = [];
    PopupPanel.dealInstance = function(inst, type) {
        if (inst == UNDF || inst == null) return this;
        var _inst = null;
        var _index = -1;
        var filterInstance = function(instances, inst) {
            for (var i = 0, len = instances.length; i < len; i++) {
                if (instances[i] == inst) {
                    _inst = inst;
                    _index = i;
                    break;
                }
            }
        };
        switch (type) {
            case 'add':
                filterInstance(this._instances, inst);
                if (_inst === null) {
                    this._instances.push(inst);
                }
                break;
            case 'delete':
                filterInstance(this._instances, inst);

                if (_inst != null) {
                    //console.log('delete');
                    this._instances.splice(_index, 1);
                }
                break;
            case 'clear':
                var insts = this._instances;
                while (insts.length) {
                    insts.pop().close();
                }
                // insts.length = 0; //ensure empty array.
        }
        return this;
    };

    PopupPanel.addInstance = function(inst) {
        this.dealInstance(inst, 'add');
    };
    PopupPanel.delInstance = function(inst) {
        this.dealInstance(inst, 'delete');
    };
    PopupPanel.clearExcludeLast = function(inst) {
        this.dealInstance(inst, 'clear');
    };

    PopupPanel.clearAll = function() {
        $(window).trigger("handler.popuppanel");
    };

    //////////////////////////////////////////////////	
    //register
    _namespace_['PopupPanel'] = PopupPanel;

})(window, window);