//--------------------------------------------------------------------
//
//                 PAW Material Design Framework
//
//  Another one implementation of Material Design Concept. Uses
//  GSAP as an animation engine.
//
//
//  
// 

//--------------------------------------------------------------------
//                        Jquery Shell 
//--------------------------------------------------------------------
; (function ($) {
    $.fn.pawInk = function (options) {
        for (var i = 0; i < this.length; i++) {
            new Paw.prototype.components.ink(this[i], options);
        }
    }

    $.fn.pawSpinner = function (options) {
        for (var i = 0; i < this.length; i++) {
            new Paw.prototype.components.spinner(this[i], options);
        }
    }

})(jQuery);

//--------------------------------------------------------------------
//                            CORE 
//--------------------------------------------------------------------
; (function (environment) {
    "use strict";

    environment.Paw = function (options) {
        this.init(options);
    };

    Paw.defaults = {
        autoInit: true
    }

    Paw.prototype = {
        //=-= Components
        components: {},

        //=-= Public Methods 
        init: function (options) {
            var options = $.extend(Paw.defaults, options); //TODO: remove $ call

            if (options.autoInit) {
                for (var o in this.components) {
                    new this.components[o]();
                }
            }
        },

        //=-= Service Methods 
        _createSVG: function (tag, attrs) {
            var el = document.createElementNS('http://www.w3.org/2000/svg', tag);
            for (var k in attrs)
                el.setAttribute(k, attrs[k]);
            return el;
        },

        _getProperty: function (e, p) {
            var r;
            if ((r = e.getAttribute(p))) {
                return r;
            } else {
                return undefined;
            }
        },

        _isIE: function () {
            var myNav = navigator.userAgent.toLowerCase();
            return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
        }
    }
}(this));

//--------------------------------------------------------------------
//                     Material Design Spinner 
//--------------------------------------------------------------------
; (function (Paw) {
    'use strict';


    var Spinner = Paw.prototype.components.spinner = function (element, options) {
        if (!element) {
            var o = document.querySelectorAll(['[data-type=', ']'].join(Spinner.type)); //TODO: remove $ call

            if (o) {
                for (var i = 0; i < o.length; i++) {
                    options = {
                        color: Paw.prototype._getProperty(o[i], 'data-color'),
                        speed: Paw.prototype._getProperty(o[i], 'data-speed'),
                    };

                    this.initComponent(o[i], options);
                }
            }
        } else {
            this.initComponent(element, options);
        }
    }

    Spinner.type = 'paw-spinner';

    Spinner.defaults = {
        speed: 1,
        fallbackText: 'Loading...',
        spinCntClass: 'paw-spin-container',
        spinClass: 'paw-spin',
        shapeClass: 'paw-spin_shape',
        dashClass: 'paw-spin_dash',
    }    

    Spinner.prototype = {
        initComponent: function (element, options) {
            options = $.extend({}, Spinner.defaults, options); //TODO: remove $ call

            // Create IE 8 text fallback
            if (Paw.prototype._isIE() && Paw.prototype._isIE() < 9) {
                this._createIE8Fallback(element, options);
                return;
            }

            // Create Firefox SVG spinner version due the issue of FF border-radius animation
            // TODO: checkout FF versions with default animation issue
            if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                this._createSVGSpinner(element, options);
                return;
            }

            // Create default spinner
            this._createSpinner(element, options);
        },

        //Service Methods 

        //=-=-=-=-=-=-=-=- Default Spinner Methods -=-=-=-=-=-=-=-=-=-=

        _createSpinner: function (element, options) {
            this._createDOM(element, options);
            this._applyAnimation(element, options);
        },

        _createDOM: function (element, options) {
            var container = this._createContainerDOM(element, options);
            var spin = this._createSpinDOM(options);
            var shapeLeft = this._createShapeDOM('left', options);
            var shapeRight = this._createShapeDOM('right', options);
            var dash1 = this._createDashDOM(options);
            var dash2 = this._createDashDOM(options);

            shapeLeft.appendChild(dash1);
            shapeRight.appendChild(dash2);
            spin.appendChild(shapeLeft);
            spin.appendChild(shapeRight);
            container.appendChild(spin);
        },

        _createContainerDOM: function (element, options) {
            element.className = options.spinCntClass;
            return element;
        },

        _createSpinDOM: function (options) {
            var o = document.createElement('div');
            o.className = options.spinClass;
            return o;
        },

        _createShapeDOM: function (direction, options) {
            var o = document.createElement('div');
            o.className = [options.shapeClass, direction].join(' ');
            return o;
        },

        _createDashDOM: function (options) {
            var o = document.createElement('div');
            o.className = options.dashClass;
            return o;
        },


        _applyAnimation: function (element, options) {
            this._rotateContainerDOM(element, options);
            this._rotateSpinDOM(element, options);
            this._rotateDashDOM(element, options);
        },

        _rotateContainerDOM: function (element, options) {
            TweenMax.fromTo(
                element, 1.568 / options.speed,

                {
                    rotation: 0,
                    ease: Linear.easeNone
                },
                {
                    rotation: 360,
                    ease: Linear.easeNone
                }
            ).repeat(-1);
        },

        _rotateSpinDOM: function (element, options) {
            var tl = new TimelineMax({ repeat: -1 }),
				t = 5.332 / options.speed,
				$o = $(element).find('.' + options.spinClass); //TODO: remove $ call

            tl.fromTo(
				$o, t / 8,
				{ rotation: 0 }, { rotation: 135, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 270, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 405, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 540, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 675, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 810, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 945, ease: Cubic.easeInOut }
			).to(
				$o, t / 8, { rotation: 1080, ease: Cubic.easeInOut }
			);
        },

        _rotateDashDOM: function (element, options) {
            var tl1 = new TimelineMax({ repeat: -1 }),
			    tl2 = new TimelineMax({ repeat: -1 }),
				t = 1.333 / options.speed,
				$l = $(element).find('.' + options.shapeClass + '.left .' + options.dashClass), //TODO: remove $ call
				$r = $(element).find('.' + options.shapeClass + '.right .' + options.dashClass); //TODO: remove $ call
            tl1.fromTo(
				$l, t / 2, { rotation: 130 }, { rotation: -5, ease: Cubic.easeInOut }
			).to(
				$l, t / 2, { rotation: 130, ease: Cubic.easeInOut }
			);

            tl2.fromTo(
				$r, t / 2, { rotation: -130 }, { rotation: 5, ease: Cubic.easeInOut }
			).to(
				$r, t / 2, { rotation: -130, ease: Cubic.easeInOut }
			);

        },

        //=-=-=-=-=-=-=-=- IE8 Spinner Methods -=-=-=-=-=-=-=-=-=-=

        _createIE8Fallback: function (element, options) {
            element.appendChild(document.createTextNode(options.fallbackText));
            element.className = options.spinCntClass;            
        },

        //=-=-=-=-=-=-=-=- SVG Spinner Methods -=-=-=-=-=-=-=-=-=-=

        _createSVGSpinner: function (element, options) {
            var container = this._createContainerDOM(element, options);
            var svg = this._createSVGDOM(element, options);
            container.appendChild(svg);

            this._applySVGAnimation(element, options);
        },

        _createSVGDOM: function (element, options) {
            var svg = Paw.prototype._createSVG('svg', {
                xmlns: "http://www.w3.org/2000/svg",
                'class': options.spinClass,
                x: 0,
                y: 0,
                viewBox: "0 0 66 66"
            });
            var g = Paw.prototype._createSVG('g', {
                transform: "translate(33, 33)"
            });
            var circle = Paw.prototype._createSVG('circle', {
                'class': options.shapeClass,
                x: -10,
                y: -10,
                r: 30
            });

            svg.appendChild(g);
            g.appendChild(circle);

            return svg;
        },

        // TODO: Synchronize svg and default animation. Animation needs to be redone
        _applySVGAnimation: function (element, options) {
            var $spin = $(element).find('.' + options.spinClass), // TODO: Remove $ call
                $stroke = $(element).find('circle'); // TODO: Remove $ call

            var animStep = 0.8;

            TweenMax.fromTo(
                element, (animStep * 2) / options.speed,
                {
                    rotation: 0,
                    ease: Linear.easeNone
                },
                {
                    rotation: 360,
                    ease: Linear.easeNone
                }
            ).repeat(-1);


            var spinTimeline = new TimelineMax();
            spinTimeline.to($spin, animStep / options.speed, { rotation: 0, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 280, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 280, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 580, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 580, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 820, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 820, ease: Ease.easeInOut })
                .to($spin, animStep / options.speed, { rotation: 1080, ease: Ease.easeInOut })
                .repeat(-1);

            var strokeTimeLine = new TimelineMax(),
                giglet = { i: 190 };
            strokeTimeLine.to(giglet, animStep / options.speed, { i: 20, onUpdate: function () { $stroke[0].style.strokeDashoffset = giglet.i; } })
                .to(giglet, animStep / options.speed, { i: 190, onUpdate: function () { $stroke[0].style.strokeDashoffset = giglet.i; } })
                .repeat(-1);
        }
    }
})(Paw);

//--------------------------------------------------------------------
//                             Navbar
//--------------------------------------------------------------------
; (function (Paw) {
    "use strict";

    var Navbar = Paw.prototype.components.navbar = function (options) {
        Navbar.options = $.extend({}, Navbar.options, options); // TODO: Remove $ call
        this.initComponent();
    }

    Navbar.type = 'paw-navbar';

    Navbar.options = {
        showTitle: true,
        barClass: 'paw-navbar',
        barCntClass: 'paw-navbar-container',
        titleClass: 'paw-navbar-title'
    }

    Navbar.prototype = {
        components: {},

        initComponent: function () {
            var body = document.querySelector('body'),
                barCnt = this._createBarCntDOM(),
                bar = this._createBarDOM(),
                title = this._createTitleDOM();

            title.appendChild(this._getPageTitle());
            bar.appendChild(title);
            barCnt.appendChild(bar);

            body.insertBefore(barCnt, body.firstChild);

            for (var o in this.components) {
                new this.components[o](false, bar);
            }
        },

        _createBarCntDOM: function () {
            var o = document.createElement('div');
            o.className = Navbar.options.barCntClass;
            return o;
        },

        _createBarDOM: function () {
            var o = document.createElement('div');
            o.className = Navbar.options.barClass;
            return o;
        },

        _createTitleDOM: function () {
            var o = document.createElement('div');
            o.className = Navbar.options.titleClass;
            return o;
        },

        _getPageTitle: function () {
            return document.createTextNode(document.title);
        }
    }

})(Paw);

//--------------------------------------------------------------------
//                       Navbar Search Form
//--------------------------------------------------------------------
; (function (Paw) {
    "use strict";

    var SearchForm = Paw.prototype.components.navbar.prototype.components.searchForm = function (element, parent, options) {
        if (!element) {
            var o = document.querySelector(['[data-type=', ']'].join(SearchForm.type));
            if (o) {
                this.initComponent(o, parent);
            }
        } else {
            this.initComponent(element, parent, options);
        }
    }

    SearchForm.type = 'paw-search-form';

    SearchForm.defaults = {
        iconClass: 'fa fa-search',
        iconActiveClass: 'fa fa-times',
        searchClass: 'paw-navbar-search',
        toggleClass: 'paw-navbar-search_toggle',
        inputClass: 'paw-navbar-search_input',
        inputPlaceholder: 'Search...',
    }

    SearchForm.prototype = {
        initComponent: function (element, parent, options) {
            options = $.extend({}, SearchForm.defaults, options); // TODO: Remove $ call

            var form = this._createSearchDOM(element, options),
                toggle = this._createSearchToggleDOM(form, options);

            parent.appendChild(toggle);
            parent.appendChild(form);
        },

        _createSearchToggleDOM: function (form, options) {
            var o = document.createElement('button');
            o.className = [options.toggleClass, options.iconClass].join(' ');

            this._addToggleListener(form, o, options);

            return o;
        },

        _createSearchDOM: function (element, options) {
            var i = document.createElement('input');
            i.className = options.inputClass;
            i.type = 'text';
            i.value = options.inputPlaceholder; // TODO: Remove $ call
            i.name = $(element).find('input').attr('name'); // TODO: Remove $ call

            this._addInputBlurListener(i, options);
            this._addInputFocusListener(i, options);

            var o = document.createElement('form');
            o.className = options.searchClass;
            o.action = element.action;
            o.appendChild(i);
            return o;
        },

        _addToggleListener: function (form, element, options) {
            var handler = function () {
                var exp = this.className.split(/\s+/);
                exp = exp.join(' ');

                if (exp === [options.toggleClass, options.iconClass].join(' ')) {
                    this.className = [options.toggleClass, options.iconActiveClass].join(' ');
                    form.className = [form.className, 'active'].join(' ');
                } else {
                    this.className = [options.toggleClass, options.iconClass].join(' ');
                    form.className = options.searchClass;
                }
            }

            if (element.addEventListener) {
                element.addEventListener("click", handler);
            }
            else {
                element.attachEvent("onclick", handler);
            }
        },

        _addInputBlurListener: function (element, options) {
            var handler = function () {
                if (this.value == '') { this.value = options.inputPlaceholder }
            }

            if (element.addEventListener) {
                element.addEventListener("blur", handler);
            }
            else {
                element.attachEvent("onblur", handler);
            }
        },

        _addInputFocusListener: function (element, options) {
            var handler = function () {
                if (this.value == options.inputPlaceholder) { this.value = '' }
            }

            if (element.addEventListener) {
                element.addEventListener("focus", handler);
            }
            else {
                element.attachEvent("onfocus", handler);
            }

        }

    }

})(Paw);

//--------------------------------------------------------------------
//                            Side Nav
//--------------------------------------------------------------------
; (function (Paw) {
    "use strict";

    var SideNav = Paw.prototype.components.navbar.prototype.components.sideNav = function (element, parent, options) {
        if (!element) {
            var o = document.querySelector(['[data-type=', ']'].join(SideNav.type));
            if (o) {
                this.initComponent(o, parent);
            }
        } else {
            this.initComponent(element, parent, options);
        }
    }

    SideNav.type = 'paw-sidenav';

    SideNav.defaults = {
        iconClass: 'fa fa-bars',
        iconActiveClass: 'fa  fa-chevron-left',
        displayBreakPoint: 767,
        navClass: 'paw-sidenav',
        navSubClass: 'paw-sidenav-submenu',
        navCntClass: 'paw-sidenav-container',
        toggleClass: 'paw-sidenav_toggle',
    }

    SideNav.prototype = {
        initComponent: function (element, parent, options) {
            options = $.extend({}, SideNav.defaults, options); // TODO: Remove $ call

            var body = document.querySelector('body'),
                cnt = this._createNavCntDOM(options),
                nav = this._createNavDOM(element, options),
                toggle = this._createNavToggleDOM(cnt, options);

            parent.appendChild(toggle);
            cnt.appendChild(nav);
            body.insertBefore(cnt, body.firstChild);

            this._addResizeListener(cnt, toggle, options);
            this._addTouchListener(cnt, nav, toggle, options);
            this._addClickListener(cnt, nav, toggle, options);
        },

        _createNavToggleDOM: function (form, options) {
            var o = document.createElement('button');
            o.className = [options.toggleClass, options.iconClass].join(' ');

            this._addToggleListener(form, o, options);

            return o;
        },

        _createNavDOM: function (ul, options) {
            var nav = document.createElement('ul');
            nav.className = options.navClass;

            this._createNavItems(ul, nav);

            return nav;
        },

        _createNavCntDOM: function (options) {
            var o = document.createElement('div');
            o.className = options.navCntClass;
            return o;
        },

        _createNavItems: function (ul, nav) {
            var li = ul.children;
            for (var i = 0; i < li.length; i++) {
                var o = li[i].children,
                    item = null;
                for (var j = 0; j < o.length; j++) {
                    if (o[j].tagName) {
                        if (!item) {
                            item = document.createElement('li');
                            if (li[i].className.indexOf('active') > -1) {
                                item.className = 'active';
                            }
                        }

                        switch (o[j].tagName.toLowerCase()) {
                            case 'a':
                                item.appendChild(o[j].cloneNode(true));
                                break;
                            case 'ul':
                                var subnav = document.createElement('ul');
                                item.appendChild(o[j].cloneNode(true));
                                break;
                            default:
                                break;
                        }
                    }
                }

                if (item) {
                    nav.appendChild(item);
                }
            }

            return nav;
        },

        _createNavItem: function (a) {
            var li = document.createElement('li');
            li.appendChild(a);
            return li;
        },

        _addToggleListener: function (navCnt, element, options) {
            var handler = function () {
                var exp = this.className.split(/\s+/);
                exp = exp.join(' ');

                if (exp === [options.toggleClass, options.iconClass].join(' ')) {
                    this.className = [options.toggleClass, options.iconActiveClass].join(' ');
                    navCnt.className = [navCnt.className, 'active'].join(' ');
                    document.body.style.position = 'fixed';
                    document.querySelector('.paw-navbar-title').innerHTML = 'Navigation';
                } else {
                    this.className = [options.toggleClass, options.iconClass].join(' ');
                    navCnt.className = options.navCntClass;
                    document.body.style.position = 'static';
                    document.querySelector('.paw-navbar-title').innerHTML = document.title;
                }
            }

            if (element.addEventListener) {
                element.addEventListener("click", handler);
            }
            else {
                element.attachEvent("onclick", handler);
            }
        },

        _addResizeListener: function (navCnt, toggle, options) {
            var handler = function () {
                if ($('html').hasClass('desktop')) {
                    if (window.innerWidth) { //TODO: Remove $ call
                        if (window.innerWidth > options.displayBreakPoint) {
                            toggle.className = [options.toggleClass, options.iconClass].join(' ');
                            navCnt.className = options.navCntClass;
                            document.body.style.position = 'static';
                            document.querySelector('.paw-navbar-title').innerHTML = document.title;
                        }
                    } else {
                        if (document.body.clientWidth > options.displayBreakPoint) {
                            toggle.className = [options.toggleClass, options.iconClass].join(' ');
                            navCnt.className = options.navCntClass;
                            document.body.style.position = 'static';
                            document.querySelector('.paw-navbar-title').innerHTML = document.title;
                        }
                    }
                }
            }

            if (window.addEventListener) {
                window.addEventListener('resize', handler);
            }
            else {
                window.attachEvent('onresize', handler);
            }
        },

        _addClickListener: function (cnt, nav, toggle, options) {
            var handler = function (e) {
                if (e.clientX > nav.offsetWidth && e.clientY > nav.offsetTop) {
                    toggle.className = [options.toggleClass, options.iconClass].join(' ');
                    cnt.className = options.navCntClass;
                    document.body.style.position = 'static';
                    document.querySelector('.paw-navbar-title').innerHTML = document.title;
                }
            }

            if (window.addEventListener) {
                window.addEventListener("click", handler);
            }
            else {
                window.attachEvent("onclick", handler);
            }
        },

        _addTouchListener: function (cnt, nav, toggle, options) {
            var startY;
            if (window.addEventListener) {
                window.addEventListener('touchstart', function (e) {
                    var t = e.changedTouches[0];
                    startY = t.clientY;
                    if (e.clientX > nav.offsetWidth && e.clientY > nav.offsetTop) {
                        toggle.className = [options.toggleClass, options.iconClass].join(' ');
                        cnt.className = options.navCntClass;
                        document.body.style.position = 'static';
                        document.querySelector('.paw-navbar-title').innerHTML = document.title;
                    }
                });
            }
        }
    }

})(Paw);

//--------------------------------------------------------------------
//                            Ink Effect 
//--------------------------------------------------------------------
; (function (Paw) {
    "use strict";

    var Ink = Paw.prototype.components.ink = function (element, options) {
        if (!element) {
            var o = document.querySelectorAll(['[data-type=', ']'].join(Ink.type));
            for (var i = 0; i < o.length; i++) {
                options = {
                    color: Paw.prototype._getProperty(o[i], 'data-color'),
                    speed: Paw.prototype._getProperty(o[i], 'data-duration'),
                };

                this.initComponent(o[i], options);
            }
        } else {
            this.initComponent(element, options);
        }

    }

    Ink.type = 'paw-ink';

    Ink.defaults = {
        color: 'rgba(200,200,200,.5)',
        duration: 0.65,
        elClass: 'paw-ink',
        inkClass: 'paw-ink_effect',
        cntClass: 'paw-ink_content',

        // TODO: set callback to FALSE when Button element will be done
        onStart: function (element, event) {
            event.preventDefault();
        },
        // TODO: set callback to FALSE when Button element will be done
        onComplete: function (e) {
            var $this = $(e),
                $tag = $this.prop("tagName");
            switch ($tag) {
                case 'A':
                    var href = $this.attr('href');
                    if (typeof href !== typeof undefined && href !== false) {
                        window.location.href = href;
                    }
                    break
                default:
                    $.noop;
            }
        }
    }

    Ink.prototype = {
        initComponent: function (element, options) {
            options = $.extend({}, Ink.defaults, options); // TODO: Remove $ call

            this._createDOM(element, options);
            this._addClickListener(element, options);
        },

        //Service Methods
        _createDOM: function (element, options) {
            element.className = [element.className, options.elClass].join(' ');
            var cntWrap = this._createCntDOM(options);
            cntWrap.innerHTML = element.innerHTML;
            element.innerHTML = '';
            element.appendChild(this._createInkDOM(options));
            element.appendChild(cntWrap);
        },

        _createInkDOM: function (options) {
            var o = document.createElement('div');
            o.className = options.inkClass;
            return o;
        },

        _createCntDOM: function (options) {
            var o = document.createElement('div');
            o.className = options.cntClass;
            return o;
        },

        //TODO: needs tobe redone without jQuery
        _addClickListener: function (element, options) {
            $(element).click(function (e) {
                if (options.onStart) {
                    options.onStart(element, e);
                }

                var $this = $(this),
                    $ink, x, y, d;

                $ink = $this.find('.' + options.inkClass);

                // Set the ink size to parent size
                if (!$ink.height() && !$ink.width()) {
                    d = Math.max($this.outerWidth(), $this.outerHeight());

                    $ink.css({ height: d, width: d });
                }

                // Calc ink creating coords
                x = e.pageX - $this.offset().left - $ink.width() / 2;
                y = e.pageY - $this.offset().top - $ink.height() / 2;

                $ink.css({ top: y + 'px', left: x + 'px' });

                // Play ink animation
                TweenMax.fromTo(
                    $ink,
                    options.duration,
                    {
                        css: { opacity: 1, scale: 0 }
                    },
                    {
                        css: { opacity: 0, scale: 2.5 }
                    }).eventCallback("onComplete", function () {
                        if (options.onComplete) {
                            options.onComplete(element);
                        }
                    });
            });
        }
    }
})(Paw);



