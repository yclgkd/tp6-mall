/* Author: VIPArcher */
// Add new jQuery function

(function ($) {
    // browser info
    "use strict";
    $.browser = (function () {
        var
            rwebkit = /(webkit)\/([\w.]+)/,
            ropera = /(opera)(?:.*version)?[ \/]([\w.]+)/,
            rmsie = /(msie) ([\w.]+)/,
            rmozilla = /(mozilla)(?:.*? rv:([\w.]+))?/,
            browser = {},
            browserMatch = (function (ua) {
                var match = rwebkit.exec(ua) || ropera.exec(ua) || rmsie.exec(ua) || ua.indexOf("compatible") < 0 && rmozilla.exec(ua) || [];
                return {
                    browser: match[1] || "",
                    version: match[2] || "0"
                };
            })(window.navigator.userAgent.toLowerCase());
        if (browserMatch.browser) {
            browser[browserMatch.browser] = true;
            browser.version = browserMatch.version;
            browser.language = (window.navigator.browserLanguage || window.navigator.language).toLowerCase();
        }
        return browser;
    })();
    $.extend({
        /* getUrlParam */
        getUrlParam: function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return decodeURI(r[2]);
            return null;
        },
        /* scrollFloor */
        scrollFloor: function (options) {
            var $body = $(document.body), data = [];
            var defaults = {
                floorClass: '.scroll-floor',
                navClass: '.scroll-nav',
                activeClass: 'active',
                activeTop: 200,
                scrollTop: 0,
                delayTime: 500
            };

            function getItem(_list, newOptions) {
                _list.each(function () {
                    var item = {};
                    item.$obj = $body.find(this);
                    item.$activeTop = $body.find(this).offset().top - newOptions.activeTop;
                    item.$scrollTop = $body.find(this).offset().top + newOptions.scrollTop;
                    data.push(item);
                });
            };

            function scrollActive(_list, newOptions) {
                var nowScrollTop = $(window).scrollTop();
                $.each(data, function (i, item) {
                    if (nowScrollTop > item.$activeTop) {
                        _list.removeClass(newOptions.activeClass).eq(i).addClass(newOptions.activeClass);
                    }
                });
            };
            var newOptions = $.extend({}, defaults, options);
            var floorList = $body.find(newOptions.floorClass), navList = $body.find(newOptions.navClass);
            getItem(floorList, newOptions);
            scrollActive(navList, newOptions);
            $(window).bind('scroll', function () {
                scrollActive(navList, newOptions);
            });
            navList.bind('click', function () {
                var _index = $body.find(this).index();
                $('html,body').animate({'scrollTop': data[_index].$scrollTop}, newOptions.delayTime);
            });
        }
    });
    $.fn.extend({
        /* 绑定input只能输入正则内容 默认为数字（带小数点） */
        onlyReg: function (opt) {
            var reg = opt && opt.reg ? opt.reg : /[^0-9.]/g;
            $(this).bind('input propertychange', function () {
                $(this).val($(this).val().replace(reg, ''));
            });
        },
        /* textarea高度根据内容自适应 */
        txtaAutoHeight: function () {
            return this.each(function () {
                var $this = $(this);
                if (!$this.attr('initAttrH')) {
                    $this.attr('initAttrH', $this.outerHeight());
                }
                setAutoHeight(this).on('input', function () {
                    setAutoHeight(this);
                });
            });

            function setAutoHeight(elem) {
                var $obj = $(elem);
                return $obj.css({height: $obj.attr('initAttrH'), 'overflow-y': 'hidden'}).height(elem.scrollHeight);
            }
        },
        smartFloat: function (top) {
            var top = Number.isInteger(top) ? top : 250;
            var position = function (element) {
                var _top = element.offset().top, pos = element.css("position");
                $(window).scroll(function () {
                    var scrolls = $(this).scrollTop();
                    if (scrolls + top > _top) {
                        if (window.XMLHttpRequest) {
                            element.css({
                                position: "fixed",
                                top: top
                            });
                        } else {
                            element.css({
                                top: scrolls
                            });
                        }
                    } else {
                        element.css({
                            position: pos,
                            top: _top
                        });
                    }
                });
            };
            return $(this).each(function () {
                position($(this));
            });
        },
        /* 返回顶部 */
        toTop: function (opt) {
            var i = this, e = $(window), s = $("html, body"),
                n = $.extend({autohide: !0, offset: 450, speed: 500, position: !0, right: 0, bottom: 52}, opt);
            i.css({cursor: "pointer"}), n.autohide && i.css("display", "none"), n.position && i.css({
                position: "fixed",
                right: n.right,
                bottom: n.bottom
            }), i.click(function () {
                s.animate({scrollTop: 0}, n.speed)
            }), e.scroll(function () {
                var o = e.scrollTop();
                n.autohide && (o > n.offset ? i.fadeIn(n.speed) : i.fadeOut(n.speed))
            })
        }
    });
})(jQuery);
// String#format
String.prototype.format = function (args) {
    if (arguments.length > 0) {
        var result = this;
        if (arguments.length == 1 && typeof (args) == "object") {
            for (var key in args) {
                var reg = new RegExp("({" + key + "})", "g");
                result = result.replace(reg, args[key]);
            }
        } else {
            for (var i = 0; i < arguments.length; i++) {
                if (arguments[i] == undefined) {
                    return "";
                } else {
                    var reg = new RegExp("({[" + i + "]})", "g");
                    result = result.replace(reg, arguments[i]);
                }
            }
        }
        return result;
    } else {
        return this;
    }
};

// Base64.js
// function Base64() {
// };(function () {
//     _k = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", Base64.encode = function (a) {
//         var c, d, e, f, g, h, i, b = "", j = 0;
//         for (a = _ue(a); j < a.length;) c = a.charCodeAt(j++), d = a.charCodeAt(j++), e = a.charCodeAt(j++), f = c >> 2, g = (3 & c) << 4 | d >> 4, h = (15 & d) << 2 | e >> 6, i = 63 & e, isNaN(d) ? h = i = 64 : isNaN(e) && (i = 64), b = b + _k.charAt(f) + _k.charAt(g) + _k.charAt(h) + _k.charAt(i);
//         return b
//     }, Base64.decode = function (a) {
//         var c, d, e, f, g, h, i, b = "", j = 0;
//         for (a = a.replace(/[^A-Za-z0-9\+\/\=]/g, ""); j < a.length;) f = _k.indexOf(a.charAt(j++)), g = _k.indexOf(a.charAt(j++)), h = _k.indexOf(a.charAt(j++)), i = _k.indexOf(a.charAt(j++)), c = f << 2 | g >> 4, d = (15 & g) << 4 | h >> 2, e = (3 & h) << 6 | i, b += String.fromCharCode(c), 64 != h && (b += String.fromCharCode(d)), 64 != i && (b += String.fromCharCode(e));
//         return b = _ud(b)
//     }, _ue = function (a) {
//         var b, c, d;
//         for (a = a.replace(/\r\n/g, "\n"), b = "", c = 0; c < a.length; c++) d = a.charCodeAt(c), 128 > d ? b += String.fromCharCode(d) : d > 127 && 2048 > d ? (b += String.fromCharCode(192 | d >> 6), b += String.fromCharCode(128 | 63 & d)) : (b += String.fromCharCode(224 | d >> 12), b += String.fromCharCode(128 | 63 & d >> 6), b += String.fromCharCode(128 | 63 & d));
//         return b
//     }, _ud = function (a) {
//         for (var b = "", c = 0, d = c1 = c2 = 0; c < a.length;) d = a.charCodeAt(c), 128 > d ? (b += String.fromCharCode(d), c++) : d > 191 && 224 > d ? (c2 = a.charCodeAt(c + 1), b += String.fromCharCode((31 & d) << 6 | 63 & c2), c += 2) : (c2 = a.charCodeAt(c + 1), c3 = a.charCodeAt(c + 2), b += String.fromCharCode((15 & d) << 12 | (63 & c2) << 6 | 63 & c3), c += 3);
//         return b
//     }
// })();
