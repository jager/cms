/*!
 * Copyright (c) 2009 Simo Kinnunen.
 * Licensed under the MIT license.
 *
 * @version ${Version}
 */

var Cufon = (function() {

	var api = function() {
		return api.replace.apply(null, arguments);
	};

	var DOM = api.DOM = {

		ready: (function() {

			var complete = false, readyStatus = { loaded: 1, complete: 1 };

			var queue = [], perform = function() {
				if (complete) return;
				complete = true;
				for (var fn; fn = queue.shift(); fn());
			};

			// Gecko, Opera, WebKit r26101+

			if (document.addEventListener) {
				document.addEventListener('DOMContentLoaded', perform, false);
				window.addEventListener('pageshow', perform, false); // For cached Gecko pages
			}

			// Old WebKit, Internet Explorer

			if (!window.opera && document.readyState) (function() {
				readyStatus[document.readyState] ? perform() : setTimeout(arguments.callee, 10);
			})();

			// Internet Explorer

			if (document.readyState && document.createStyleSheet) (function() {
				try {
					document.body.doScroll('left');
					perform();
				}
				catch (e) {
					setTimeout(arguments.callee, 1);
				}
			})();

			addEvent(window, 'load', perform); // Fallback

			return function(listener) {
				if (!arguments.length) perform();
				else complete ? listener() : queue.push(listener);
			};

		})(),

		root: function() {
			return document.documentElement || document.body;
		}

	};

	var CSS = api.CSS = {

		Size: function(value, base) {

			this.value = parseFloat(value);
			this.unit = String(value).match(/[a-z%]*$/)[0] || 'px';

			this.convert = function(value) {
				return value / base * this.value;
			};

			this.convertFrom = function(value) {
				return value / this.value * base;
			};

			this.toString = function() {
				return this.value + this.unit;
			};

		},

		addClass: function(el, className) {
			var current = el.className;
			el.className = current + (current && ' ') + className;
			return el;
		},

		color: cached(function(value) {
			var parsed = {};
			parsed.color = value.replace(/^rgba\((.*?),\s*([\d.]+)\)/, function($0, $1, $2) {
				parsed.opacity = parseFloat($2);
				return 'rgb(' + $1 + ')';
			});
			return parsed;
		}),

		// has no direct CSS equivalent.
		// @see http://msdn.microsoft.com/en-us/library/system.windows.fontstretches.aspx
		fontStretch: cached(function(value) {
			if (typeof value == 'number') return value;
			if (/%$/.test(value)) return parseFloat(value) / 100;
			return {
				'ultra-condensed': 0.5,
				'extra-condensed': 0.625,
				condensed: 0.75,
				'semi-condensed': 0.875,
				'semi-expanded': 1.125,
				expanded: 1.25,
				'extra-expanded': 1.5,
				'ultra-expanded': 2
			}[value] || 1;
		}),

		getStyle: function(el) {
			var view = document.defaultView;
			if (view && view.getComputedStyle) return new Style(view.getComputedStyle(el, null));
			if (el.currentStyle) return new Style(el.currentStyle);
			return new Style(el.style);
		},

		gradient: cached(function(value) {
			var gradient = {
				id: value,
				type: value.match(/^-([a-z]+)-gradient\(/)[1],
				stops: []
			}, colors = value.substr(value.indexOf('(')).match(/([\d.]+=)?(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)/ig);
			for (var i = 0, l = colors.length, stop; i < l; ++i) {
				stop = colors[i].split('=', 2).reverse();
				gradient.stops.push([ stop[1] || i / (l - 1), stop[0] ]);
			}
			return gradient;
		}),

		quotedList: cached(function(value) {
			// doesn't work properly with empty quoted strings (""), but
			// it's not worth the extra code.
			var list = [], re = /\s*((["'])([\s\S]*?[^\\])\2|[^,]+)\s*/g, match;
			while (match = re.exec(value)) list.push(match[3] || match[1]);
			return list;
		}),

		recognizesMedia: cached(function(media) {
			var el = document.createElement('style'), sheet, container, supported;
			el.type = 'text/css';
			el.media = media;
			try { // this is cached anyway
				el.appendChild(document.createTextNode('/**/'));
			} catch (e) {}
			container = elementsByTagName('head')[0];
			container.insertBefore(el, container.firstChild);
			sheet = (el.sheet || el.styleSheet);
			supported = sheet && !sheet.disabled;
			container.removeChild(el);
			return supported;
		}),

		removeClass: function(el, className) {
			var re = RegExp('(?:^|\\s+)' + className +  '(?=\\s|$)', 'g');
			el.className = el.className.replace(re, '');
			return el;
		},

		supports: function(property, value) {
			var checker = document.createElement('span').style;
			if (checker[property] === undefined) return false;
			checker[property] = value;
			return checker[property] === value;
		},

		textAlign: function(word, style, position, wordCount) {
			if (style.get('textAlign') == 'right') {
				if (position > 0) word = ' ' + word;
			}
			else if (position < wordCount - 1) word += ' ';
			return word;
		},

		textShadow: cached(function(value) {
			if (value == 'none') return null;
			var shadows = [], currentShadow = {}, result, offCount = 0;
			var re = /(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)|(-?[\d.]+[a-z%]*)|,/ig;
			while (result = re.exec(value)) {
				if (result[0] == ',') {
					shadows.push(currentShadow);
					currentShadow = {};
					offCount = 0;
				}
				else if (result[1]) {
					currentShadow.color = result[1];
				}
				else {
					currentShadow[[ 'offX', 'offY', 'blur' ][offCount++]] = result[2];
				}
			}
			shadows.push(currentShadow);
			return shadows;
		}),

		textTransform: (function() {
			var map = {
				uppercase: function(s) {
					return s.toUpperCase();
				},
				lowercase: function(s) {
					return s.toLowerCase();
				},
				capitalize: function(s) {
					return s.replace(/\b./g, function($0) {
						return $0.toUpperCase();
					});
				}
			};
			return function(text, style) {
				var transform = map[style.get('textTransform')];
				return transform ? transform(text) : text;
			};
		})(),

		whiteSpace: (function() {
			var ignore = {
				inline: 1,
				'inline-block': 1,
				'run-in': 1
			};
			var wsStart = /^\s+/, wsEnd = /\s+$/;
			return function(text, style, node, previousElement) {
				if (previousElement) {
					if (previousElement.nodeName.toLowerCase() == 'br') {
						text = text.replace(wsStart, '');
					}
				}
				if (ignore[style.get('display')]) return text;
				if (!node.previousSibling) text = text.replace(wsStart, '');
				if (!node.nextSibling) text = text.replace(wsEnd, '');
				return text;
			};
		})()

	};

	CSS.ready = (function() {

		// don't do anything in Safari 2 (it doesn't recognize any media type)
		var complete = !CSS.recognizesMedia('all'), hasLayout = false;

		var queue = [], perform = function() {
			complete = true;
			for (var fn; fn = queue.shift(); fn());
		};

		var links = elementsByTagName('link'), styles = elementsByTagName('style');

		function isContainerReady(el) {
			return el.disabled || isSheetReady(el.sheet, el.media || 'screen');
		}

		function isSheetReady(sheet, media) {
			// in Opera sheet.disabled is true when it's still loading,
			// even though link.disabled is false. they stay in sync if
			// set manually.
			if (!CSS.recognizesMedia(media || 'all')) return true;
			if (!sheet || sheet.disabled) return false;
			try {
				var rules = sheet.cssRules, rule;
				if (rules) {
					// needed for Safari 3 and Chrome 1.0.
					// in standards-conforming browsers cssRules contains @-rules.
					// Chrome 1.0 weirdness: rules[<number larger than .length - 1>]
					// returns the last rule, so a for loop is the only option.
					search: for (var i = 0, l = rules.length; rule = rules[i], i < l; ++i) {
						switch (rule.type) {
							case 2: // @charset
								break;
							case 3: // @import
								if (!isSheetReady(rule.styleSheet, rule.media.mediaText)) return false;
								break;
							default:
								// only @charset can precede @import
								break search;
						}
					}
				}
			}
			catch (e) {} // probably a style sheet from another domain
			return true;
		}

		function allStylesLoaded() {
			// Internet Explorer's style sheet model, there's no need to do anything
			if (document.createStyleSheet) return true;
			// standards-compliant browsers
			var el, i;
			for (i = 0; el = links[i]; ++i) {
				if (el.rel.toLowerCase() == 'stylesheet' && !isContainerReady(el)) return false;
			}
			for (i = 0; el = styles[i]; ++i) {
				if (!isContainerReady(el)) return false;
			}
			return true;
		}

		DOM.ready(function() {
			// getComputedStyle returns null in Gecko if used in an iframe with display: none
			if (!hasLayout) hasLayout = CSS.getStyle(document.body).isUsable();
			if (complete || (hasLayout && allStylesLoaded())) perform();
			else setTimeout(arguments.callee, 10);
		});

		return function(listener) {
			if (complete) listener();
			else queue.push(listener);
		};

	})();

	function Font(data) {

		var face = this.face = data.face, wordSeparators = {
			'\u0020': 1,
			'\u00a0': 1,
			'\u3000': 1
		};

		this.glyphs = data.glyphs;
		this.w = data.w;
		this.baseSize = parseInt(face['units-per-em'], 10);

		this.family = face['font-family'].toLowerCase();
		this.weight = face['font-weight'];
		this.style = face['font-style'] || 'normal';

		this.viewBox = (function () {
			var parts = face.bbox.split(/\s+/);
			var box = {
				minX: parseInt(parts[0], 10),
				minY: parseInt(parts[1], 10),
				maxX: parseInt(parts[2], 10),
				maxY: parseInt(parts[3], 10)
			};
			box.width = box.maxX - box.minX;
			box.height = box.maxY - box.minY;
			box.toString = function() {
				return [ this.minX, this.minY, this.width, this.height ].join(' ');
			};
			return box;
		})();

		this.ascent = -parseInt(face.ascent, 10);
		this.descent = -parseInt(face.descent, 10);

		this.height = -this.ascent + this.descent;

		this.spacing = function(chars, letterSpacing, wordSpacing) {
			var glyphs = this.glyphs, glyph,
				kerning, k,
				jumps = [],
				width = 0, w,
				i = -1, j = -1, chr;
			while (chr = chars[++i]) {
				glyph = glyphs[chr] || this.missingGlyph;
				if (!glyph) continue;
				if (kerning) {
					width -= k = kerning[chr] || 0;
					jumps[j] -= k;
				}
				w = glyph.w;
				if (isNaN(w)) w = +this.w; // may have been a String in old fonts
				if (w > 0) {
					w += letterSpacing;
					if (wordSeparators[chr]) w += wordSpacing;
				}
				width += jumps[++j] = ~~w; // get rid of decimals
				kerning = glyph.k;
			}
			jumps.total = width;
			return jumps;
		};

	}

	function FontFamily() {

		var styles = {}, mapping = {
			oblique: 'italic',
			italic: 'oblique'
		};

		this.add = function(font) {
			(styles[font.style] || (styles[font.style] = {}))[font.weight] = font;
		};

		this.get = function(style, weight) {
			var weights = styles[style] || styles[mapping[style]]
				|| styles.normal || styles.italic || styles.oblique;
			if (!weights) return null;
			// we don't have to worry about "bolder" and "lighter"
			// because IE's currentStyle returns a numeric value for it,
			// and other browsers use the computed value anyway
			weight = {
				normal: 400,
				bold: 700
			}[weight] || parseInt(weight, 10);
			if (weights[weight]) return weights[weight];
			// http://www.w3.org/TR/CSS21/fonts.html#propdef-font-weight
			// Gecko uses x99/x01 for lighter/bolder
			var up = {
				1: 1,
				99: 0
			}[weight % 100], alts = [], min, max;
			if (up === undefined) up = weight > 400;
			if (weight == 500) weight = 400;
			for (var alt in weights) {
				if (!hasOwnProperty(weights, alt)) continue;
				alt = parseInt(alt, 10);
				if (!min || alt < min) min = alt;
				if (!max || alt > max) max = alt;
				alts.push(alt);
			}
			if (weight < min) weight = min;
			if (weight > max) weight = max;
			alts.sort(function(a, b) {
				return (up
					? (a >= weight && b >= weight) ? a < b : a > b
					: (a <= weight && b <= weight) ? a > b : a < b) ? -1 : 1;
			});
			return weights[alts[0]];
		};

	}

	function HoverHandler() {

		function contains(node, anotherNode) {
			try {
				if (node.contains) return node.contains(anotherNode);
				return node.compareDocumentPosition(anotherNode) & 16;
			}
			catch(e) {} // probably a XUL element such as a scrollbar
			return false;
		}

		function onOverOut(e) {
			var related = e.relatedTarget;
			// there might be no relatedTarget if the element is right next
			// to the window frame
			if (related && contains(this, related)) return;
			trigger(this, e.type == 'mouseover');
		}

		function onEnterLeave(e) {
			trigger(this, e.type == 'mouseenter');
		}

		function trigger(el, hoverState) {
			// A timeout is needed so that the event can actually "happen"
			// before replace is triggered. This ensures that styles are up
			// to date.
			setTimeout(function() {
				var options = sharedStorage.get(el).options;
				api.replace(el, hoverState ? merge(options, options.hover) : options, true);
			}, 10);
		}

		this.attach = function(el) {
			if (el.onmouseenter === undefined) {
				addEvent(el, 'mouseover', onOverOut);
				addEvent(el, 'mouseout', onOverOut);
			}
			else {
				addEvent(el, 'mouseenter', onEnterLeave);
				addEvent(el, 'mouseleave', onEnterLeave);
			}
		};

	}

	function ReplaceHistory() {

		var list = [], map = {};

		function filter(keys) {
			var values = [], key;
			for (var i = 0; key = keys[i]; ++i) values[i] = list[map[key]];
			return values;
		}

		this.add = function(key, args) {
			map[key] = list.push(args) - 1;
		};

		this.repeat = function() {
			var snapshot = arguments.length ? filter(arguments) : list, args;
			for (var i = 0; args = snapshot[i++];) api.replace(args[0], args[1], true);
		};

	}

	function Storage() {

		var map = {}, at = 0;

		function identify(el) {
			return el.cufid || (el.cufid = ++at);
		}

		this.get = function(el) {
			var id = identify(el);
			return map[id] || (map[id] = {});
		};

	}

	function Style(style) {

		var custom = {}, sizes = {};

		this.extend = function(styles) {
			for (var property in styles) {
				if (hasOwnProperty(styles, property)) custom[property] = styles[property];
			}
			return this;
		};

		this.get = function(property) {
			return custom[property] != undefined ? custom[property] : style[property];
		};

		this.getSize = function(property, base) {
			return sizes[property] || (sizes[property] = new CSS.Size(this.get(property), base));
		};

		this.isUsable = function() {
			return !!style;
		};

	}

	function addEvent(el, type, listener) {
		if (el.addEventListener) {
			el.addEventListener(type, listener, false);
		}
		else if (el.attachEvent) {
			el.attachEvent('on' + type, function() {
				return listener.call(el, window.event);
			});
		}
	}

	function attach(el, options) {
		var storage = sharedStorage.get(el);
		if (storage.options) return el;
		if (options.hover && options.hoverables[el.nodeName.toLowerCase()]) {
			hoverHandler.attach(el);
		}
		storage.options = options;
		return el;
	}

	function cached(fun) {
		var cache = {};
		return function(key) {
			if (!hasOwnProperty(cache, key)) cache[key] = fun.apply(null, arguments);
			return cache[key];
		};
	}

	function getFont(el, style) {
		var families = CSS.quotedList(style.get('fontFamily').toLowerCase()), family;
		for (var i = 0; family = families[i]; ++i) {
			if (fonts[family]) return fonts[family].get(style.get('fontStyle'), style.get('fontWeight'));
		}
		return null;
	}

	function elementsByTagName(query) {
		return document.getElementsByTagName(query);
	}

	function hasOwnProperty(obj, property) {
		return obj.hasOwnProperty(property);
	}

	function merge() {
		var merged = {}, arg, key;
		for (var i = 0, l = arguments.length; arg = arguments[i], i < l; ++i) {
			for (key in arg) {
				if (hasOwnProperty(arg, key)) merged[key] = arg[key];
			}
		}
		return merged;
	}

	function process(font, text, style, options, node, el) {
		var fragment = document.createDocumentFragment(), processed;
		if (text === '') return fragment;
		var separate = options.separate;
		var parts = text.split(separators[separate]), needsAligning = (separate == 'words');
		if (needsAligning && HAS_BROKEN_REGEXP) {
			// @todo figure out a better way to do this
			if (/^\s/.test(text)) parts.unshift('');
			if (/\s$/.test(text)) parts.push('');
		}
		for (var i = 0, l = parts.length; i < l; ++i) {
			processed = engines[options.engine](font,
				needsAligning ? CSS.textAlign(parts[i], style, i, l) : parts[i],
				style, options, node, el, i < l - 1);
			if (processed) fragment.appendChild(processed);
		}
		return fragment;
	}

	function replaceElement(el, options) {
		var name = el.nodeName.toLowerCase();
		if (options.ignore[name]) return;
		var replace = !options.textless[name];
		var style = CSS.getStyle(attach(el, options)).extend(options);
		var font = getFont(el, style), node, type, next, anchor, text, lastElement;
		if (!font) return;
		for (node = el.firstChild; node; node = next) {
			type = node.nodeType;
			next = node.nextSibling;
			if (replace && type == 3) {
				// Node.normalize() is broken in IE 6, 7, 8
				if (anchor) {
					anchor.appendData(node.data);
					el.removeChild(node);
				}
				else anchor = node;
				if (next) continue;
			}
			if (anchor) {
				el.replaceChild(process(font,
					CSS.whiteSpace(anchor.data, style, anchor, lastElement),
					style, options, node, el), anchor);
				anchor = null;
			}
			if (type == 1) {
				if (node.firstChild) {
					if (node.nodeName.toLowerCase() == 'cufon') {
						engines[options.engine](font, null, style, options, node, el);
					}
					else arguments.callee(node, options);
				}
				lastElement = node;
			}
		}
	}

	var HAS_BROKEN_REGEXP = ' '.split(/\s+/).length == 0;

	var sharedStorage = new Storage();
	var hoverHandler = new HoverHandler();
	var replaceHistory = new ReplaceHistory();
	var initialized = false;

	var engines = {}, fonts = {}, defaultOptions = {
		autoDetect: false,
		engine: null,
		//fontScale: 1,
		//fontScaling: false,
		forceHitArea: false,
		hover: false,
		hoverables: {
			a: true
		},
		ignore: {
			applet: 1,
			canvas: 1,
			col: 1,
			colgroup: 1,
			head: 1,
			iframe: 1,
			map: 1,
			noscript: 1,
			optgroup: 1,
			option: 1,
			script: 1,
			select: 1,
			style: 1,
			textarea: 1,
			title: 1,
			pre: 1
		},
		printable: true,
		//rotation: 0,
		//selectable: false,
		selector: (
				window.Sizzle
			||	(window.jQuery && function(query) { return jQuery(query); }) // avoid noConflict issues
			||	(window.dojo && dojo.query)
			||	(window.glow && glow.dom && glow.dom.get)
			||	(window.Ext && Ext.query)
			||	(window.YAHOO && YAHOO.util && YAHOO.util.Selector && YAHOO.util.Selector.query)
			||	(window.$$ && function(query) { return $$(query); })
			||	(window.$ && function(query) { return $(query); })
			||	(document.querySelectorAll && function(query) { return document.querySelectorAll(query); })
			||	elementsByTagName
		),
		separate: 'words', // 'none' and 'characters' are also accepted
		textless: {
			dl: 1,
			html: 1,
			ol: 1,
			table: 1,
			tbody: 1,
			thead: 1,
			tfoot: 1,
			tr: 1,
			ul: 1
		},
		textShadow: 'none'
	};

	var separators = {
		// The first pattern may cause unicode characters above
		// code point 255 to be removed in Safari 3.0. Luckily enough
		// Safari 3.0 does not include non-breaking spaces in \s, so
		// we can just use a simple alternative pattern.
		words: /\s/.test('\u00a0') ? /[^\S\u00a0]+/ : /\s+/,
		characters: '',
		none: /^/
	};

	api.now = function() {
		DOM.ready();
		return api;
	};

	api.refresh = function() {
		replaceHistory.repeat.apply(replaceHistory, arguments);
		return api;
	};

	api.registerEngine = function(id, engine) {
		if (!engine) return api;
		engines[id] = engine;
		return api.set('engine', id);
	};

	api.registerFont = function(data) {
		if (!data) return api;
		var font = new Font(data), family = font.family;
		if (!fonts[family]) fonts[family] = new FontFamily();
		fonts[family].add(font);
		return api.set('fontFamily', '"' + family + '"');
	};

	api.replace = function(elements, options, ignoreHistory) {
		options = merge(defaultOptions, options);
		if (!options.engine) return api; // there's no browser support so we'll just stop here
		if (!initialized) {
			CSS.addClass(DOM.root(), 'cufon-active cufon-loading');
			CSS.ready(function() {
				// fires before any replace() calls, but it doesn't really matter
				CSS.addClass(CSS.removeClass(DOM.root(), 'cufon-loading'), 'cufon-ready');
			});
			initialized = true;
		}
		if (options.hover) options.forceHitArea = true;
		if (options.autoDetect) delete options.fontFamily;
		if (typeof options.textShadow == 'string') {
			options.textShadow = CSS.textShadow(options.textShadow);
		}
		if (typeof options.color == 'string' && /^-/.test(options.color)) {
			options.textGradient = CSS.gradient(options.color);
		}
		else delete options.textGradient;
		if (!ignoreHistory) replaceHistory.add(elements, arguments);
		if (elements.nodeType || typeof elements == 'string') elements = [ elements ];
		CSS.ready(function() {
			for (var i = 0, l = elements.length; i < l; ++i) {
				var el = elements[i];
				if (typeof el == 'string') api.replace(options.selector(el), options, true);
				else replaceElement(el, options);
			}
		});
		return api;
	};

	api.set = function(option, value) {
		defaultOptions[option] = value;
		return api;
	};

	return api;

})();

Cufon.registerEngine('canvas', (function() {

	// Safari 2 doesn't support .apply() on native methods

	var check = document.createElement('canvas');
	if (!check || !check.getContext || !check.getContext.apply) return;
	check = null;

	var HAS_INLINE_BLOCK = Cufon.CSS.supports('display', 'inline-block');

	// Firefox 2 w/ non-strict doctype (almost standards mode)
	var HAS_BROKEN_LINEHEIGHT = !HAS_INLINE_BLOCK && (document.compatMode == 'BackCompat' || /frameset|transitional/i.test(document.doctype.publicId));

	var styleSheet = document.createElement('style');
	styleSheet.type = 'text/css';
	styleSheet.appendChild(document.createTextNode((
		'cufon{text-indent:0;}' +
		'@media screen,projection{' +
			'cufon{display:inline;display:inline-block;position:relative;vertical-align:middle;' +
			(HAS_BROKEN_LINEHEIGHT
				? ''
				: 'font-size:1px;line-height:1px;') +
			'}cufon cufontext{display:-moz-inline-box;display:inline-block;width:0;height:0;text-indent:-10000in;}' +
			(HAS_INLINE_BLOCK
				? 'cufon canvas{position:relative;}'
				: 'cufon canvas{position:absolute;}') +
		'}' +
		'@media print{' +
			'cufon{padding:0;}' + // Firefox 2
			'cufon canvas{display:none;}' +
		'}'
	).replace(/;/g, '!important;')));
	document.getElementsByTagName('head')[0].appendChild(styleSheet);

	function generateFromVML(path, context) {
		var atX = 0, atY = 0;
		var code = [], re = /([mrvxe])([^a-z]*)/g, match;
		generate: for (var i = 0; match = re.exec(path); ++i) {
			var c = match[2].split(',');
			switch (match[1]) {
				case 'v':
					code[i] = { m: 'bezierCurveTo', a: [ atX + ~~c[0], atY + ~~c[1], atX + ~~c[2], atY + ~~c[3], atX += ~~c[4], atY += ~~c[5] ] };
					break;
				case 'r':
					code[i] = { m: 'lineTo', a: [ atX += ~~c[0], atY += ~~c[1] ] };
					break;
				case 'm':
					code[i] = { m: 'moveTo', a: [ atX = ~~c[0], atY = ~~c[1] ] };
					break;
				case 'x':
					code[i] = { m: 'closePath' };
					break;
				case 'e':
					break generate;
			}
			context[code[i].m].apply(context, code[i].a);
		}
		return code;
	}

	function interpret(code, context) {
		for (var i = 0, l = code.length; i < l; ++i) {
			var line = code[i];
			context[line.m].apply(context, line.a);
		}
	}

	return function(font, text, style, options, node, el) {

		var redraw = (text === null);

		if (redraw) text = node.getAttribute('alt');

		var viewBox = font.viewBox;

		var size = style.getSize('fontSize', font.baseSize);

		var expandTop = 0, expandRight = 0, expandBottom = 0, expandLeft = 0;
		var shadows = options.textShadow, shadowOffsets = [];
		if (shadows) {
			for (var i = shadows.length; i--;) {
				var shadow = shadows[i];
				var x = size.convertFrom(parseFloat(shadow.offX));
				var y = size.convertFrom(parseFloat(shadow.offY));
				shadowOffsets[i] = [ x, y ];
				if (y < expandTop) expandTop = y;
				if (x > expandRight) expandRight = x;
				if (y > expandBottom) expandBottom = y;
				if (x < expandLeft) expandLeft = x;
			}
		}

		var chars = Cufon.CSS.textTransform(text, style).split('');

		var jumps = font.spacing(chars,
			~~size.convertFrom(parseFloat(style.get('letterSpacing')) || 0),
			~~size.convertFrom(parseFloat(style.get('wordSpacing')) || 0)
		);

		if (!jumps.length) return null; // there's nothing to render

		var width = jumps.total;

		expandRight += viewBox.width - jumps[jumps.length - 1];
		expandLeft += viewBox.minX;

		var wrapper, canvas;

		if (redraw) {
			wrapper = node;
			canvas = node.firstChild;
		}
		else {
			wrapper = document.createElement('cufon');
			wrapper.className = 'cufon cufon-canvas';
			wrapper.setAttribute('alt', text);

			canvas = document.createElement('canvas');
			wrapper.appendChild(canvas);

			if (options.printable) {
				var print = document.createElement('cufontext');
				print.appendChild(document.createTextNode(text));
				wrapper.appendChild(print);
			}
		}

		var wStyle = wrapper.style;
		var cStyle = canvas.style;

		var height = size.convert(viewBox.height);
		var roundedHeight = Math.ceil(height);
		var roundingFactor = roundedHeight / height;
		var stretchFactor = roundingFactor * Cufon.CSS.fontStretch(style.get('fontStretch'));
		var stretchedWidth = width * stretchFactor;

		var canvasWidth = Math.ceil(size.convert(stretchedWidth + expandRight - expandLeft));
		var canvasHeight = Math.ceil(size.convert(viewBox.height - expandTop + expandBottom));

		canvas.width = canvasWidth;
		canvas.height = canvasHeight;

		// needed for WebKit and full page zoom
		cStyle.width = canvasWidth + 'px';
		cStyle.height = canvasHeight + 'px';

		// minY has no part in canvas.height
		expandTop += viewBox.minY;

		cStyle.top = Math.round(size.convert(expandTop - font.ascent)) + 'px';
		cStyle.left = Math.round(size.convert(expandLeft)) + 'px';

		var wrapperWidth = Math.max(Math.ceil(size.convert(stretchedWidth)), 0) + 'px';

		if (HAS_INLINE_BLOCK) {
			wStyle.width = wrapperWidth;
			wStyle.height = size.convert(font.height) + 'px';
		}
		else {
			wStyle.paddingLeft = wrapperWidth;
			wStyle.paddingBottom = (size.convert(font.height) - 1) + 'px';
		}

		var g = canvas.getContext('2d'), scale = height / viewBox.height;

		// proper horizontal scaling is performed later
		g.scale(scale, scale * roundingFactor);
		g.translate(-expandLeft, -expandTop);
		g.save();

		function renderText() {
			var glyphs = font.glyphs, glyph, i = -1, j = -1, chr;
			g.scale(stretchFactor, 1);
			while (chr = chars[++i]) {
				var glyph = glyphs[chars[i]] || font.missingGlyph;
				if (!glyph) continue;
				if (glyph.d) {
					g.beginPath();
					if (glyph.code) interpret(glyph.code, g);
					else glyph.code = generateFromVML('m' + glyph.d, g);
					g.fill();
				}
				g.translate(jumps[++j], 0);
			}
			g.restore();
		}

		if (shadows) {
			for (var i = shadows.length; i--;) {
				var shadow = shadows[i];
				g.save();
				g.fillStyle = shadow.color;
				g.translate.apply(g, shadowOffsets[i]);
				renderText();
			}
		}

		var gradient = options.textGradient;
		if (gradient) {
			var stops = gradient.stops, fill = g.createLinearGradient(0, viewBox.minY, 0, viewBox.maxY);
			for (var i = 0, l = stops.length; i < l; ++i) {
				fill.addColorStop.apply(fill, stops[i]);
			}
			g.fillStyle = fill;
		}
		else g.fillStyle = style.get('color');

		renderText();

		return wrapper;

	};

})());

Cufon.registerEngine('vml', (function() {

	var ns = document.namespaces;
	if (!ns) return;
	ns.add('cvml', 'urn:schemas-microsoft-com:vml');
	ns = null;

	var check = document.createElement('cvml:shape');
	check.style.behavior = 'url(#default#VML)';
	if (!check.coordsize) return; // VML isn't supported
	check = null;

	var HAS_BROKEN_LINEHEIGHT = (document.documentMode || 0) < 8;

	document.write(('<style type="text/css">' +
		'cufoncanvas{text-indent:0;}' +
		'@media screen{' +
			'cvml\\:shape,cvml\\:rect,cvml\\:fill,cvml\\:shadow{behavior:url(#default#VML);display:block;antialias:true;position:absolute;}' +
			'cufoncanvas{position:absolute;text-align:left;}' +
			'cufon{display:inline-block;position:relative;vertical-align:' +
			(HAS_BROKEN_LINEHEIGHT
				? 'middle'
				: 'text-bottom') +
			';}' +
			'cufon cufontext{position:absolute;left:-10000in;font-size:1px;}' +
			'a cufon{cursor:pointer}' + // ignore !important here
		'}' +
		'@media print{' +
			'cufon cufoncanvas{display:none;}' +
		'}' +
	'</style>').replace(/;/g, '!important;'));

	function getFontSizeInPixels(el, value) {
		return getSizeInPixels(el, /(?:em|ex|%)$|^[a-z-]+$/i.test(value) ? '1em' : value);
	}

	// Original by Dead Edwards.
	// Combined with getFontSizeInPixels it also works with relative units.
	function getSizeInPixels(el, value) {
		if (!isNaN(value) || /px$/i.test(value)) return parseFloat(value);
		var style = el.style.left, runtimeStyle = el.runtimeStyle.left;
		el.runtimeStyle.left = el.currentStyle.left;
		el.style.left = value.replace('%', 'em');
		var result = el.style.pixelLeft;
		el.style.left = style;
		el.runtimeStyle.left = runtimeStyle;
		return result;
	}

	function getSpacingValue(el, style, size, property) {
		var key = 'computed' + property, value = style[key];
		if (isNaN(value)) {
			value = style.get(property);
			style[key] = value = (value == 'normal') ? 0 : ~~size.convertFrom(getSizeInPixels(el, value));
		}
		return value;
	}

	var fills = {};

	function gradientFill(gradient) {
		var id = gradient.id;
		if (!fills[id]) {
			var stops = gradient.stops, fill = document.createElement('cvml:fill'), colors = [];
			fill.type = 'gradient';
			fill.angle = 180;
			fill.focus = '0';
			fill.method = 'none';
			fill.color = stops[0][1];
			for (var j = 1, k = stops.length - 1; j < k; ++j) {
				colors.push(stops[j][0] * 100 + '% ' + stops[j][1]);
			}
			fill.colors = colors.join(',');
			fill.color2 = stops[k][1];
			fills[id] = fill;
		}
		return fills[id];
	}

	return function(font, text, style, options, node, el, hasNext) {

		var redraw = (text === null);

		if (redraw) text = node.alt;

		var viewBox = font.viewBox;

		var size = style.computedFontSize || (style.computedFontSize = new Cufon.CSS.Size(getFontSizeInPixels(el, style.get('fontSize')) + 'px', font.baseSize));

		var wrapper, canvas;

		if (redraw) {
			wrapper = node;
			canvas = node.firstChild;
		}
		else {
			wrapper = document.createElement('cufon');
			wrapper.className = 'cufon cufon-vml';
			wrapper.alt = text;

			canvas = document.createElement('cufoncanvas');
			wrapper.appendChild(canvas);

			if (options.printable) {
				var print = document.createElement('cufontext');
				print.appendChild(document.createTextNode(text));
				wrapper.appendChild(print);
			}

			// ie6, for some reason, has trouble rendering the last VML element in the document.
			// we can work around this by injecting a dummy element where needed.
			// @todo find a better solution
			if (!hasNext) wrapper.appendChild(document.createElement('cvml:shape'));
		}

		var wStyle = wrapper.style;
		var cStyle = canvas.style;

		var height = size.convert(viewBox.height), roundedHeight = Math.ceil(height);
		var roundingFactor = roundedHeight / height;
		var stretchFactor = roundingFactor * Cufon.CSS.fontStretch(style.get('fontStretch'));
		var minX = viewBox.minX, minY = viewBox.minY;

		cStyle.height = roundedHeight;
		cStyle.top = Math.round(size.convert(minY - font.ascent));
		cStyle.left = Math.round(size.convert(minX));

		wStyle.height = size.convert(font.height) + 'px';

		var color = style.get('color');
		var chars = Cufon.CSS.textTransform(text, style).split('');

		var jumps = font.spacing(chars,
			getSpacingValue(el, style, size, 'letterSpacing'),
			getSpacingValue(el, style, size, 'wordSpacing')
		);

		if (!jumps.length) return null;

		var width = jumps.total;
		var fullWidth = -minX + width + (viewBox.width - jumps[jumps.length - 1]);

		var shapeWidth = size.convert(fullWidth * stretchFactor), roundedShapeWidth = Math.round(shapeWidth);

		var coordSize = fullWidth + ',' + viewBox.height, coordOrigin;
		var stretch = 'r' + coordSize + 'ns';

		var fill = options.textGradient && gradientFill(options.textGradient);

		var glyphs = font.glyphs, offsetX = 0;
		var shadows = options.textShadow;
		var i = -1, j = 0, chr;

		while (chr = chars[++i]) {

			var glyph = glyphs[chars[i]] || font.missingGlyph, shape;
			if (!glyph) continue;

			if (redraw) {
				// some glyphs may be missing so we can't use i
				shape = canvas.childNodes[j];
				while (shape.firstChild) shape.removeChild(shape.firstChild); // shadow, fill
			}
			else {
				shape = document.createElement('cvml:shape');
				canvas.appendChild(shape);
			}

			shape.stroked = 'f';
			shape.coordsize = coordSize;
			shape.coordorigin = coordOrigin = (minX - offsetX) + ',' + minY;
			shape.path = (glyph.d ? 'm' + glyph.d + 'xe' : '') + 'm' + coordOrigin + stretch;
			shape.fillcolor = color;

			if (fill) shape.appendChild(fill.cloneNode(false));

			// it's important to not set top/left or IE8 will grind to a halt
			var sStyle = shape.style;
			sStyle.width = roundedShapeWidth;
			sStyle.height = roundedHeight;

			if (shadows) {
				// due to the limitations of the VML shadow element there
				// can only be two visible shadows. opacity is shared
				// for all shadows.
				var shadow1 = shadows[0], shadow2 = shadows[1];
				var color1 = Cufon.CSS.color(shadow1.color), color2;
				var shadow = document.createElement('cvml:shadow');
				shadow.on = 't';
				shadow.color = color1.color;
				shadow.offset = shadow1.offX + ',' + shadow1.offY;
				if (shadow2) {
					color2 = Cufon.CSS.color(shadow2.color);
					shadow.type = 'double';
					shadow.color2 = color2.color;
					shadow.offset2 = shadow2.offX + ',' + shadow2.offY;
				}
				shadow.opacity = color1.opacity || (color2 && color2.opacity) || 1;
				shape.appendChild(shadow);
			}

			offsetX += jumps[j++];
		}

		// addresses flickering issues on :hover

		var cover = shape.nextSibling, coverFill, vStyle;

		if (options.forceHitArea) {

			if (!cover) {
				cover = document.createElement('cvml:rect');
				cover.stroked = 'f';
				cover.className = 'cufon-vml-cover';
				coverFill = document.createElement('cvml:fill');
				coverFill.opacity = 0;
				cover.appendChild(coverFill);
				canvas.appendChild(cover);
			}

			vStyle = cover.style;

			vStyle.width = roundedShapeWidth;
			vStyle.height = roundedHeight;

		}
		else if (cover) canvas.removeChild(cover);

		wStyle.width = Math.max(Math.ceil(size.convert(width * stretchFactor)), 0);

		if (HAS_BROKEN_LINEHEIGHT) {

			var yAdjust = style.computedYAdjust;

			if (yAdjust === undefined) {
				var lineHeight = style.get('lineHeight');
				if (lineHeight == 'normal') lineHeight = '1em';
				else if (!isNaN(lineHeight)) lineHeight += 'em'; // no unit
				style.computedYAdjust = yAdjust = 0.5 * (getSizeInPixels(el, lineHeight) - parseFloat(wStyle.height));
			}

			if (yAdjust) {
				wStyle.marginTop = Math.ceil(yAdjust) + 'px';
				wStyle.marginBottom = yAdjust + 'px';
			}

		}

		return wrapper;

	};

})());

/*!
 * The following copyright notice may not be removed under any circumstances.
 * 
 * Copyright:
 * Copyright (c) 2003 by This Font is designed by Ralph Oliver du Carrois. All
 * rights reserved.
 * 
 * Trademark:
 * Colaborate Light is a trademark of This Font is designed by Ralph Oliver du
 * Carrois.
 * 
 * Description:
 * Copyright (c) 2003 by This Font is designed by Ralph Oliver du Carrois. All
 * rights reserved.
 * 
 * Manufacturer:
 * This Font is designed by Ralph Oliver du Carrois
 */
Cufon.registerFont({"w":488,"face":{"font-family":"ColaborateLight","font-weight":400,"font-stretch":"normal","units-per-em":"1000","panose-1":"2 0 5 3 4 0 0 2 0 4","ascent":"800","descent":"-200","x-height":"11","bbox":"-26 -746 1001 209","underline-thickness":"50","underline-position":"-50","stemh":"54","stemv":"65","unicode-range":"U+0020-U+2122"},"glyphs":{" ":{"w":244},"\u00d7":{"d":"440,-74r-44,44r-151,-152r-152,152r-44,-44r152,-152r-152,-151r44,-44r152,152r151,-152r44,44r-152,151"},"!":{"d":"155,-170r-66,0r0,-477r66,0r0,477xm162,0r-80,0r0,-84r80,0r0,84","w":244},"\"":{"d":"282,-647r-8,217r-50,0r-8,-217r66,0xm145,-647r-8,217r-51,0r-8,-217r67,0","w":360},"#":{"d":"475,-396r-106,0r-27,153r94,0r0,52r-103,0r-33,191r-61,0r33,-191r-111,0r-33,191r-61,0r33,-191r-87,0r0,-52r97,0r26,-153r-84,0r0,-52r94,0r35,-199r61,0r-35,199r111,0r35,-199r61,0r-35,199r96,0r0,52xm308,-396r-111,0r-26,153r110,0"},"$":{"d":"437,-168v0,119,-74,168,-167,181r0,85r-59,0r0,-81v-58,0,-110,-14,-166,-29r25,-64v50,19,87,35,141,36r0,-267v-82,-31,-167,-67,-167,-182v0,-107,73,-156,167,-167r0,-90r59,0r0,88v43,2,93,10,140,26r-25,64v-33,-14,-63,-29,-115,-32r0,238v82,31,167,71,167,194xm212,-385r0,-212v-58,10,-94,44,-94,108v0,57,42,83,94,104xm363,-166v0,-64,-42,-94,-93,-117r0,235v48,-13,93,-46,93,-118"},"%":{"d":"684,-167v0,89,-17,178,-128,178v-110,0,-125,-89,-125,-178v0,-85,24,-171,126,-171v110,0,127,82,127,171xm583,-629r-363,629r-63,0r362,-629r64,0xm307,-487v0,89,-17,178,-128,178v-110,0,-125,-89,-125,-178v0,-85,24,-171,126,-171v110,0,127,82,127,171xm635,-167v0,-73,-6,-134,-78,-134v-68,0,-76,73,-76,134v0,74,7,141,75,141v72,0,79,-66,79,-141xm258,-487v0,-73,-6,-134,-78,-134v-68,0,-76,73,-76,134v0,74,7,141,75,141v72,0,79,-66,79,-141","w":738},"&":{"d":"442,0r-58,0r-14,-54v-26,38,-70,68,-125,68v-110,0,-199,-58,-199,-187v0,-76,30,-144,119,-187v-34,-26,-99,-60,-99,-135v0,-91,41,-166,159,-166v100,0,159,48,159,157v0,80,-58,125,-150,164v-72,31,-120,70,-120,165v0,62,35,138,135,138v46,0,90,-36,116,-78r0,-122r-103,0r0,-49r168,0r0,146v0,54,10,112,12,140xm317,-505v0,-62,-20,-105,-94,-105v-66,0,-89,47,-89,114v0,56,54,88,81,109v48,-20,102,-50,102,-118"},"'":{"d":"155,-647r-8,217r-50,0r-8,-217r66,0","w":244},"(":{"d":"223,128r-60,0v-85,-147,-106,-232,-106,-382v0,-183,31,-267,101,-393r60,0v-71,131,-91,224,-91,393v0,139,15,234,96,382","w":275},")":{"d":"219,-254v0,150,-21,235,-106,382r-60,0v81,-148,96,-243,96,-382v0,-169,-20,-262,-91,-393r60,0v70,126,101,210,101,393","w":275},"*":{"d":"377,-494r-143,35r-1,6r93,119r-45,32r-80,-124r-7,0r-83,124r-45,-33r94,-118r-3,-6r-144,-36r19,-55r138,52r6,-5r-7,-145r56,0r-8,147r6,4r137,-52","w":390},"+":{"d":"452,-187r-177,0r0,187r-63,0r0,-187r-176,0r0,-55r176,0r0,-182r63,0r0,182r177,0r0,55"},",":{"d":"161,-75r-81,178r-52,0r56,-178r77,0","w":244},"-":{"d":"298,-214r-269,0r0,-58r269,0r0,58","w":327},".":{"d":"161,0r-78,0r0,-83r78,0r0,83","w":244,"k":{"y":62,"w":86,"v":62,"Y":62,"W":62,"V":62}},"\/":{"d":"264,-658r-213,668r-62,0r214,-668r61,0","w":254},"0":{"d":"450,-308v0,163,-23,323,-208,323v-183,0,-205,-162,-205,-323v0,-155,36,-311,206,-311v183,0,207,149,207,311xm375,-308v0,-139,-8,-255,-132,-255v-118,0,-131,137,-131,255v0,141,9,267,130,267v129,0,133,-133,133,-267"},"1":{"d":"325,1r-73,0r0,-528r-115,99r-25,-59r144,-120r69,0r0,608"},"2":{"d":"437,0r-375,0r-24,-61v92,-86,311,-253,311,-375v0,-93,-45,-128,-125,-128v-52,0,-90,18,-147,46r-25,-63v74,-30,119,-39,174,-39v110,0,197,49,197,180v0,143,-195,295,-291,382r305,0r0,58"},"3":{"d":"413,-158v0,132,-106,173,-214,173v-68,0,-106,-4,-164,-24r25,-63v38,14,76,31,142,31v71,0,136,-33,136,-118v0,-112,-81,-133,-191,-133r0,-54v102,0,176,-17,176,-114v0,-82,-49,-104,-112,-104v-48,0,-95,22,-140,44r-25,-63v44,-22,116,-37,166,-37v114,0,186,50,186,158v0,92,-63,133,-134,142v70,11,149,52,149,162"},"4":{"d":"467,-168r-96,0r0,168r-73,0r0,-168r-242,0r-26,-60r269,-379r72,0r0,383r96,0r0,56xm298,-224r0,-296r-208,296r208,0"},"5":{"d":"438,-191v0,131,-87,206,-217,206v-61,0,-112,-4,-167,-22r24,-63v45,18,96,29,144,29v98,0,143,-59,143,-152v0,-92,-46,-139,-116,-139v-51,0,-92,22,-125,39r-55,-22r0,-292r344,0r0,56r-271,0r0,184v31,-8,59,-21,109,-21v121,0,187,73,187,197"},"6":{"d":"443,-192v0,112,-77,207,-192,207v-173,0,-206,-150,-206,-298v0,-160,72,-337,241,-337v37,0,85,6,126,17r-24,63v-33,-13,-59,-24,-97,-24v-114,0,-178,113,-178,266v28,-59,84,-100,142,-100v124,0,188,82,188,206xm368,-192v0,-81,-24,-151,-115,-151v-81,0,-117,64,-131,100v0,155,46,202,130,202v69,0,116,-57,116,-151"},"7":{"d":"425,-552r-228,552r-81,0r243,-550r-315,0r0,-57r355,0"},"8":{"d":"451,-148v0,137,-114,163,-210,163v-94,0,-204,-30,-204,-163v0,-89,58,-146,146,-172v-28,-13,-125,-48,-125,-143v0,-104,71,-157,188,-157v120,0,190,43,190,156v0,93,-97,137,-133,145v95,30,148,83,148,171xm364,-462v0,-74,-41,-103,-118,-103v-74,0,-117,30,-117,104v0,65,68,102,113,116v49,-11,122,-53,122,-117xm378,-149v0,-87,-74,-124,-134,-143v-62,19,-135,52,-135,143v0,72,51,109,132,109v79,0,137,-33,137,-109"},"9":{"d":"442,-322v0,160,-72,337,-241,337v-37,0,-85,-6,-126,-17r25,-63v33,13,58,24,96,24v114,0,178,-113,178,-266v-28,59,-84,100,-142,100v-124,0,-187,-82,-187,-206v0,-112,78,-207,191,-207v174,0,206,150,206,298xm365,-362v0,-155,-46,-202,-130,-202v-69,0,-116,57,-116,151v0,81,24,151,115,151v81,0,117,-64,131,-100"},":":{"d":"161,-369r-78,0r0,-83r78,0r0,83xm161,0r-78,0r0,-83r78,0r0,83","w":244},";":{"d":"158,-369r-78,0r0,-83r78,0r0,83xm161,-75r-81,178r-52,0r52,-178r81,0","w":244},"<":{"d":"452,-21r-417,-168r0,-79r417,-169r0,70r-350,139r350,138r0,69"},"=":{"d":"452,-270r-417,0r0,-58r417,0r0,58xm452,-97r-417,0r0,-58r417,0r0,58"},">":{"d":"452,-189r-417,168r0,-69r350,-140r-350,-137r0,-70r417,169r0,79"},"?":{"d":"380,-503v0,119,-162,141,-162,247r0,92r-69,0r0,-97v0,-136,159,-147,159,-242v0,-70,-33,-97,-107,-97v-37,0,-96,17,-132,35r-18,-62v43,-15,102,-30,150,-30v92,0,179,28,179,154xm224,0r-80,0r0,-84r80,0r0,84","w":410},"@":{"d":"759,-382v0,183,-134,257,-297,257v-124,0,-213,-68,-213,-195v0,-104,71,-192,195,-192v40,0,71,9,86,15r0,193r35,-5r20,52r-114,14r0,-213v-6,-2,-18,-5,-29,-5v-70,0,-126,44,-126,139v0,109,72,147,148,147v133,0,227,-52,227,-206v0,-164,-118,-226,-241,-226v-149,0,-301,78,-301,287v0,212,153,286,300,286v79,0,131,-9,212,-36r24,55v-82,25,-165,32,-239,32v-219,0,-364,-121,-364,-337v0,-221,160,-338,368,-338v146,0,309,84,309,276","w":841},"A":{"d":"600,0r-82,0r-69,-193r-266,0r-73,193r-77,0r263,-647r60,0xm430,-248r-108,-307r-118,307r226,0","w":632,"k":{"y":52,"w":52,"v":52,"u":12,"t":12,"q":12,"o":12,"e":12,"d":12,"c":12,"a":12,"Y":52,"W":52,"V":52,"T":52,"Q":12,"O":12,"G":12,"C":12,"A":-1,"@":24,"&":24}},"B":{"d":"522,-184v0,148,-97,184,-215,184r-209,0r0,-647r176,0v126,0,218,30,218,169v0,68,-43,118,-103,139v80,16,133,66,133,155xm417,-477v0,-90,-45,-113,-143,-113r-103,0r0,229r117,0v71,0,129,-34,129,-116xm446,-184v0,-101,-71,-121,-156,-121r-119,0r0,248r130,0v85,0,145,-20,145,-127","w":580,"k":{"V":8}},"C":{"d":"503,-12v-57,20,-107,29,-170,29v-198,0,-270,-143,-270,-340v0,-180,65,-335,276,-335v56,0,108,8,157,24r-25,64v-42,-18,-84,-31,-132,-31v-157,0,-200,127,-200,277v0,159,45,284,194,284v50,0,93,-15,145,-36","w":543},"D":{"d":"565,-326v0,235,-90,326,-309,326r-158,0r0,-647r158,0v224,0,309,88,309,321xm489,-325v0,-202,-65,-265,-233,-265r-85,0r0,533r94,0v152,0,224,-81,224,-268","w":628,"k":{"V":8,"J":20}},"E":{"d":"465,0r-367,0r0,-647r358,0r0,57r-285,0r0,227r264,0r0,57r-264,0r0,249r294,0r0,57","w":536},"F":{"d":"456,-589r-285,0r0,230r273,0r0,56r-273,0r0,303r-73,0r0,-647r358,0r0,58","w":512},"G":{"d":"533,-39v-67,34,-117,56,-198,56v-216,0,-272,-166,-272,-341v0,-199,79,-334,281,-334v45,0,103,12,149,24r-25,64v-39,-17,-79,-31,-123,-31v-140,0,-206,89,-206,277v0,156,39,284,199,284v48,0,91,-19,129,-40r0,-182r-143,0r0,-58r209,0r0,281","w":596},"H":{"d":"549,0r-73,0r0,-305r-305,0r0,305r-73,0r0,-647r73,0r0,284r305,0r0,-284r73,0r0,647","w":647},"I":{"d":"159,0r-73,0r0,-647r73,0r0,647","w":245},"J":{"d":"300,-204v0,212,-152,242,-262,268r-20,-64v90,-18,209,-24,209,-194r0,-453r73,0r0,443","w":398},"K":{"d":"573,0r-96,0r-306,-312r0,312r-73,0r0,-647r73,0r0,294r287,-294r80,0r-298,307","w":589,"k":{"y":52,"w":52,"v":52,"u":24,"q":24,"o":24,"e":24,"d":24,"c":24,"a":24,"U":12,"Q":24,"O":24,"G":24,"C":24,"@":24,"&":12}},"L":{"d":"467,0r-369,0r0,-647r73,0r0,587r296,0r0,60","w":475,"k":{"Y":96,"W":64,"V":72,"T":64,"O":20}},"M":{"d":"740,0r-71,0r0,-568r-221,568r-60,0r-223,-568r0,568r-67,0r0,-647r112,0r211,545r213,-545r106,0r0,647","w":838},"N":{"d":"576,0r-106,0r-305,-561r0,561r-67,0r0,-647r104,0r303,561r0,-561r71,0r0,647","w":674},"O":{"d":"617,-321v0,192,-70,338,-275,338v-215,0,-279,-145,-279,-338v0,-191,73,-337,280,-337v210,0,274,143,274,337xm541,-321v0,-172,-46,-280,-199,-280v-154,0,-203,109,-203,280v0,171,49,281,203,281v156,0,199,-115,199,-281","w":680,"k":{"Z":12,"Y":24,"X":24,"W":24,"V":24,"J":20,"A":12}},"P":{"d":"501,-463v0,134,-75,190,-205,190r-125,0r0,273r-73,0r0,-647r187,0v132,0,216,48,216,184xm426,-463v0,-104,-56,-127,-143,-127r-112,0r0,260r117,0v88,0,138,-29,138,-133","w":555,"k":{"J":80,"A":48}},"Q":{"d":"617,-321v0,192,-70,338,-275,338v-215,0,-279,-145,-279,-338v0,-191,72,-337,280,-337v210,0,274,143,274,337xm556,57r-26,57r-213,-31r27,-44xm541,-321v0,-172,-46,-280,-199,-280v-154,0,-203,109,-203,280v0,171,49,281,203,281v156,0,199,-115,199,-281","w":680},"R":{"d":"542,0r-90,0r-213,-289r-68,0r0,289r-73,0r0,-647r202,0v103,0,206,39,206,174v0,94,-43,176,-182,182xm431,-473v0,-76,-45,-117,-126,-117r-134,0r0,244r135,0v94,0,125,-55,125,-127","w":587},"S":{"d":"478,-168v0,144,-109,185,-236,185v-56,0,-119,-14,-174,-29r25,-64v48,18,97,36,150,36v77,0,160,-26,160,-126v0,-87,-80,-112,-163,-142v-86,-31,-172,-68,-172,-181v0,-122,109,-169,228,-169v44,0,107,8,160,26r-25,64v-37,-16,-74,-33,-136,-33v-92,0,-152,36,-152,112v0,64,59,89,127,114v96,34,208,68,208,207","w":549},"T":{"d":"482,-589r-192,0r0,589r-73,0r0,-589r-191,0r0,-58r456,0r0,58","w":508,"k":{"z":86,"y":86,"x":86,"w":86,"v":86,"u":86,"s":86,"r":86,"q":86,"p":86,"o":86,"n":86,"m":86,"j":24,"i":24,"g":86,"e":86,"d":86,"c":86,"a":86,"Q":24,"O":24,"J":52,"G":24,"C":24,"A":52,"@":24,";":86,":":86,".":86,",":86}},"U":{"d":"580,-237v0,172,-75,254,-234,254v-176,0,-248,-83,-248,-256r0,-408r73,0r0,398v0,165,56,209,175,209v111,0,161,-55,161,-209r0,-398r73,0r0,410","w":678},"V":{"d":"575,-647r-236,647r-64,0r-245,-647r81,0r198,548r188,-548r78,0","w":604,"k":{"z":24,"y":24,"x":24,"w":24,"v":24,"u":52,"s":52,"r":52,"q":52,"p":24,"o":52,"n":52,"m":52,"j":24,"i":24,"g":52,"e":52,"d":52,"c":52,"a":52,"Q":24,"O":24,"J":52,"G":24,"C":24,"A":86,";":24,":":24,".":52,",":52}},"W":{"d":"843,-647r-172,647r-85,0r-146,-514r-154,514r-87,0r-163,-647r77,0r138,550r152,-523r85,0r143,524r142,-551r70,0","w":879,"k":{"z":24,"y":24,"x":24,"w":12,"v":12,"u":24,"s":24,"r":24,"q":24,"p":24,"o":24,"n":24,"m":24,"j":8,"i":8,"g":24,"e":24,"d":24,"c":24,"a":24,"Q":24,"O":24,"J":52,"G":24,"C":24,"A":86,";":52,":":52,".":52,",":52}},"X":{"d":"541,0r-89,0r-165,-278r-176,278r-79,0r216,-334r-189,-313r85,0r148,249r156,-249r79,0r-198,307","w":579,"k":{"y":24,"w":24,"v":24,"Q":24,"O":24,"G":24,"C":24}},"Y":{"d":"546,-647r-225,356r0,291r-73,0r0,-287r-232,-360r83,0r189,292r181,-292r77,0","w":562,"k":{"s":24,"q":24,"o":24,"g":24,"e":24,"d":24,"c":24,"a":24,"O":24,"J":52,"G":24,"C":24,"A":52,".":52,",":52}},"Z":{"d":"494,-585r-370,527r362,0r0,58r-418,0r-23,-62r369,-527r-332,0r0,-58r388,0","w":539,"k":{"O":12}},"[":{"d":"226,127r-142,0r0,-803r142,0r0,50r-79,0r0,700r79,0r0,53","w":272},"\\":{"d":"264,10r-62,0r-213,-668r62,0","w":254},"]":{"d":"192,126r-142,0r0,-53r79,0r0,-701r-79,0r0,-49r142,0r0,803","w":272},"^":{"d":"454,-269r-69,0r-142,-299r-142,299r-66,0r181,-378r53,0"},"_":{"d":"501,102r-502,0r0,-51r502,0r0,51","w":500},"`":{"d":"189,-530r-52,0r-118,-117r74,0","w":208},"a":{"d":"416,0r-58,0v-1,-7,-16,-44,-17,-54v-23,33,-70,65,-128,65v-92,0,-166,-39,-166,-131v0,-93,51,-158,245,-158r44,0r0,-35v0,-61,-21,-104,-91,-104v-63,0,-113,19,-156,40r-23,-56v53,-20,111,-35,180,-35v94,0,156,47,156,147r0,181v0,36,8,84,14,140xm337,-101r0,-128r-31,0v-144,0,-190,33,-190,107v0,51,38,82,104,82v53,0,96,-24,117,-61","w":479},"b":{"d":"444,-231v0,131,-57,242,-193,242v-56,0,-98,-33,-119,-65r-14,54r-57,0v6,-57,9,-82,9,-140r0,-517r65,0r0,268v21,-35,73,-79,133,-79v129,0,176,110,176,237xm376,-229v0,-137,-52,-188,-120,-188v-75,0,-109,68,-123,98r0,209v27,47,65,70,112,70v89,0,131,-68,131,-189","w":491},"c":{"d":"395,-19v-35,17,-111,30,-146,30v-140,0,-202,-96,-202,-236v0,-148,61,-243,205,-243v41,0,108,17,141,30r-23,55v-34,-17,-85,-34,-119,-34v-101,0,-136,75,-136,192v0,107,35,185,135,185v31,0,83,-14,122,-34","w":433},"d":{"d":"431,0r-57,0r-15,-54v-21,32,-63,65,-119,65v-144,0,-193,-111,-193,-242v0,-128,63,-237,183,-237v61,0,105,42,126,77r0,-266r65,0r0,517v0,58,4,83,10,140xm358,-110r0,-209v-15,-32,-46,-98,-119,-98v-67,0,-124,54,-124,188v0,121,38,189,131,189v47,0,85,-23,112,-70","w":491},"e":{"d":"432,-206r-315,0v3,97,38,167,133,167v50,0,95,-14,142,-39r20,54v-53,25,-113,35,-170,35v-138,0,-195,-108,-195,-235v0,-106,42,-244,191,-244v151,0,194,107,194,262xm367,-257v-2,-109,-42,-160,-128,-160v-71,0,-118,55,-123,160r251,0","w":481},"f":{"d":"279,-614v-82,5,-130,42,-130,103r0,54r104,0r0,51r-104,0r0,406r-65,0r0,-406r-69,0r0,-51r69,0r0,-48v0,-106,98,-159,178,-165","w":279},"g":{"d":"463,68v0,91,-99,130,-210,130v-160,0,-214,-49,-214,-126v0,-51,54,-86,90,-95v-35,-15,-61,-40,-61,-77v0,-33,22,-55,44,-74v-14,-16,-50,-53,-50,-125v0,-53,34,-169,183,-169v34,0,57,5,76,12v37,-3,93,-9,141,-11r-20,50r-65,0v24,19,54,63,54,116v0,85,-52,175,-184,175v-26,0,-77,-10,-96,-21v-12,16,-24,25,-24,43v0,23,20,41,136,51v167,14,200,57,200,121xm363,-300v0,-74,-39,-117,-116,-117v-80,0,-117,53,-117,120v0,70,38,120,118,120v86,0,115,-64,115,-123xm395,68v0,-40,-57,-57,-215,-72v-48,11,-73,48,-73,75v0,46,47,77,146,77v101,0,142,-30,142,-80","w":496},"h":{"d":"419,0r-65,0r0,-280v0,-78,-14,-137,-100,-137v-63,0,-106,59,-119,97r0,320r-65,0r0,-657r65,0r0,268v19,-33,65,-79,129,-79v123,0,155,82,155,175r0,293","w":489},"i":{"d":"140,-569r-72,0r0,-78r72,0r0,78xm137,0r-65,0r0,-457r65,0r0,457","w":208},"j":{"d":"136,-569r-73,0r0,-78r73,0r0,78xm132,-6v0,92,-47,139,-137,165r-21,-56v70,-15,93,-41,93,-100r0,-460r65,0r0,451","w":204},"k":{"d":"426,0r-79,0r-212,-239r0,239r-65,0r0,-657r65,0r0,388r194,-188r73,0r-207,198","w":441,"k":{"o":24}},"l":{"d":"135,0r-65,0r0,-657r65,0r0,657","w":205},"m":{"d":"700,0r-65,0r0,-290v0,-68,-16,-127,-100,-127v-58,0,-103,55,-120,102r0,315r-65,0r0,-290v0,-83,-32,-127,-99,-127v-56,0,-101,56,-116,96r0,321r-65,0r0,-352v0,-38,-6,-71,-9,-105r57,0r15,68v19,-28,67,-79,128,-79v82,0,116,38,140,91v26,-42,75,-91,141,-91v105,0,158,54,158,176r0,292","w":770},"n":{"d":"419,0r-65,0r0,-284v0,-70,-12,-133,-101,-133v-60,0,-102,55,-118,97r0,320r-65,0r0,-360v0,-38,-6,-61,-9,-97r57,0r14,68v18,-21,58,-79,130,-79v122,0,157,75,157,180r0,288","w":489},"o":{"d":"450,-231v0,132,-49,242,-201,242v-152,0,-202,-109,-202,-242v0,-126,50,-237,202,-237v153,0,201,105,201,237xm382,-231v0,-112,-31,-186,-133,-186v-96,0,-134,74,-134,186v0,109,31,191,134,191v104,0,133,-79,133,-191","w":497,"k":{"v":24}},"p":{"d":"444,-226v0,128,-57,237,-184,237v-59,0,-100,-29,-125,-63r0,232r-65,0r0,-500v0,-50,-3,-88,-9,-137r57,0r16,69v22,-35,70,-80,127,-80v139,0,183,112,183,242xm376,-228v0,-118,-35,-189,-128,-189v-55,0,-98,52,-114,97r0,211v23,31,51,69,122,69v69,0,120,-54,120,-188","w":491},"q":{"d":"431,-457v-6,49,-10,87,-10,137r0,500r-65,0r0,-232v-25,34,-66,63,-125,63v-130,0,-184,-109,-184,-237v0,-130,53,-242,187,-242v57,0,101,45,123,80r17,-69r57,0xm357,-109r0,-211v-16,-45,-58,-97,-113,-97v-87,0,-129,71,-129,189v0,134,52,188,121,188v71,0,98,-38,121,-69","w":491},"r":{"d":"330,-446r-23,55v-16,-14,-45,-26,-72,-26v-55,0,-86,91,-100,120r0,297r-65,0r0,-355v0,-45,-7,-79,-9,-102r57,0r14,93v17,-33,61,-104,116,-104v38,0,66,12,82,22","w":343,"k":{".":52}},"s":{"d":"370,-123v0,94,-82,134,-170,134v-53,0,-114,-10,-157,-29r23,-55v56,23,81,33,136,33v65,0,99,-30,99,-82v0,-50,-51,-65,-107,-83v-70,-23,-149,-50,-149,-134v0,-97,84,-129,168,-129v45,0,80,8,142,31r-23,55v-46,-21,-66,-35,-118,-35v-57,0,-100,20,-100,75v0,40,45,55,97,71v72,22,159,47,159,148","w":415},"t":{"d":"272,0r-21,59v-111,-22,-167,-83,-167,-170r0,-295r-69,0r0,-51r69,0r0,-117r65,0r0,117r105,0r0,51r-105,0r0,296v0,70,41,98,123,110","w":254},"u":{"d":"422,0r-57,0r-15,-68v-18,21,-54,79,-126,79v-117,0,-154,-75,-154,-180r0,-288r65,0r0,284v0,70,12,133,98,133v60,0,98,-55,114,-97r0,-320r65,0r0,360v0,38,7,61,10,97","w":483},"v":{"d":"450,-457r-176,457r-57,0r-177,-457r70,0r138,372r135,-372r67,0","w":489,"k":{"s":12,"q":12,"o":12,"g":12,"e":12,"d":12,"c":12,"a":12,"Y":24,"T":24,"J":24,"A":24,".":52,",":52}},"w":{"d":"674,-457r-156,457r-65,0r-98,-322r-106,322r-67,0r-144,-457r69,0r114,374r107,-330r60,0r100,328r121,-372r65,0","w":712,"k":{"s":12,"q":12,"o":12,"g":12,"e":12,"d":12,"c":12,"a":12,"Y":24,"T":24,"J":24,"A":24,".":86,",":86}},"x":{"d":"425,0r-79,0r-121,-186r-129,186r-71,0r164,-231r-153,-226r78,0r115,175r119,-175r69,0r-155,219","w":450},"y":{"d":"446,-457r-191,530v-26,71,-57,107,-139,136r-21,-57v55,-15,78,-38,88,-65r40,-106r-183,-438r70,0r146,363r124,-363r66,0","w":486,"k":{"s":12,"q":12,"o":12,"g":12,"e":12,"d":12,"c":12,"a":12,"T":24,"J":24,"A":24,".":52,",":52}},"z":{"d":"373,-402r-262,351r250,0r0,51r-301,0r-23,-55r263,-351r-239,0r0,-51r289,0","w":410},"{":{"d":"303,118v-275,-7,-99,-345,-255,-356r0,-55v152,-5,-24,-345,255,-354r0,54v-201,0,-56,267,-193,329v140,51,-4,328,193,328r0,54","w":357},"|":{"d":"151,166r-59,0r0,-868r59,0r0,868","w":244},"}":{"d":"309,-238v-156,11,20,349,-255,356r0,-54v197,0,53,-277,193,-328v-137,-62,8,-329,-193,-329r0,-54v279,9,103,349,255,354r0,55","w":357},"~":{"d":"462,-256v0,66,-54,105,-119,105v-80,0,-144,-78,-194,-78v-44,0,-67,21,-67,72r-56,-28v0,-67,49,-105,116,-105v79,0,142,77,194,77v44,0,70,-24,70,-71"},"\u2122":{"d":"796,-292r-45,0r0,-308r-133,308r-36,0r-133,-308r0,308r-43,0r0,-355r69,0r127,295r128,-295r66,0r0,355xm356,-611r-114,0r0,320r-47,0r0,-320r-112,0r0,-36r273,0r0,36","w":902},"\u2026":{"d":"648,0r-78,0r0,-83r78,0r0,83xm404,0r-77,0r0,-83r77,0r0,83xm161,0r-78,0r0,-83r78,0r0,83","w":731},"\u2013":{"d":"501,-210r-502,0r0,-58r502,0r0,58","w":500},"\u2014":{"d":"1001,-207r-1002,0r0,-61r1002,0r0,61","w":1000},"\u201c":{"d":"324,-648r-85,188r-64,0r98,-188r51,0xm189,-648r-85,188r-64,0r99,-188r50,0","w":364},"\u201d":{"d":"324,-647r-99,188r-51,0r85,-188r65,0xm189,-647r-98,188r-51,0r85,-188r64,0","w":364},"\u2018":{"d":"194,-648r-85,188r-64,0r99,-188r50,0","w":244},"\u2019":{"d":"197,-647r-97,188r-52,0r84,-188r65,0","w":244},"\u00a0":{"w":244}}});

