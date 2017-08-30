webpackJsonp([1],[
/* 0 */,
/* 1 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate
    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */,
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(49),
  /* template */
  __webpack_require__(50),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/Rank.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Rank.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-dbfa799e", Component.options)
  } else {
    hotAPI.reload("data-v-dbfa799e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(27);
__webpack_require__(88);
__webpack_require__(89);
module.exports = __webpack_require__(90);


/***/ }),
/* 27 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button__);
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(28);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('rank', __webpack_require__(21));
Vue.component('flash', __webpack_require__(51));
Vue.component('avatar', __webpack_require__(59));
// Vue.component('user-avatar', require('./components/UserAvatar.vue'));
Vue.component('media-manager', __webpack_require__(62));
// Vue.component('character-avatar', require('./components/CharacterAvatar.vue'));
Vue.component('position-available', __webpack_require__(67));

Vue.component('rank-picker', __webpack_require__(70));
Vue.component('user-picker', __webpack_require__(73));
Vue.component('position-picker', __webpack_require__(79));
Vue.component('character-picker', __webpack_require__(82));


Vue.use(__WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button___default.a);

Vue.component('desktop', {
  template: '<div class="d-none d-md-block" v-cloak><slot></slot></div>'
});

Vue.component('mobile', {
  template: '<div class="d-xs-block d-md-none" v-cloak><slot></slot></div>'
});

/***/ }),
/* 28 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_popper_js_dist_umd_popper_js__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_popper_js_dist_umd_popper_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_popper_js_dist_umd_popper_js__);


window._ = __webpack_require__(9);

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.$ = window.jQuery = __webpack_require__(2);

	window.Popper = __WEBPACK_IMPORTED_MODULE_0_popper_js_dist_umd_popper_js___default.a;

	__webpack_require__(10);
	window.jconfirm = __webpack_require__(11);
} catch (e) {}

window.Vue = __webpack_require__(6);
window.md5 = __webpack_require__(4);
window.Sortable = __webpack_require__(13);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(14);
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.events = new Vue();

window.flash = function (message, title) {
	var level = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'success';

	window.events.$emit('flash', message, title, level);
};

// window.route = function (name, args = {}) {
// 	// Grab the URI from the list of routes
// 	let uri = window.Nova.routes[name]

// 	// Loop through the arguments and replace the variable with its value
// 	Object.keys(args).map((a) => uri = uri.replace(`{${a}}`, args[a]))

// 	// Put the full URL back together
// 	return [window.Nova.system.baseUrl, uri].join('/')
// };

window.icon = function (name) {
	var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

	// Grab the template
	var template = window.Nova.iconTemplate;
	var icon = window.Nova.icons[name];

	template = template.replace('%2$s', attributes);

	return template.replace('%1$s', icon);
};

window._m = function (key) {
	var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

	// Get the string
	var string = window.Nova.lang[key];

	// TODO: Add the gender to the variables
	// variables.push({1: window.Nova.user.gender})

	// TODO: handle PLURAL

	// TODO: handle GENDER

	// Loop through the variables and replace the variable with its value
	Object.keys(variables).map(function (v) {
		return string = string.replace('$' + v, variables[v]);
	});

	return string;
};

/***/ }),
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		item: { type: Object },
		base: { type: String },
		overlay: { type: String }
	},

	methods: {
		baseStyle: function baseStyle() {
			var image = this.item ? this.item.base : this.base;
			var imagePath = void 0;

			if (image) {
				imagePath = [window.Nova.system.baseUrl, 'ranks', window.Nova.settings.rank, 'base', image].join('/');
			} else {
				imagePath = [window.Nova.system.baseUrl, 'ranks', window.Nova.settings.rank, 'blank.png'].join('/');
			}

			return 'background-image:url(' + imagePath + ')';
		},
		overlayStyle: function overlayStyle() {
			var image = this.item ? this.item.overlay : this.overlay;
			var imagePath = [].join('/');

			if (image) {
				imagePath = [window.Nova.system.baseUrl, 'ranks', window.Nova.settings.rank, 'overlay', image].join('/');
			}

			return 'background-image:url(' + imagePath + ')';
		}
	}
});

/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "rank-container"
  }, [_c('div', {
    staticClass: "rank-overlay",
    style: (_vm.overlayStyle())
  }), _vm._v(" "), _c('div', {
    staticClass: "rank-base",
    style: (_vm.baseStyle())
  })])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-dbfa799e", module.exports)
  }
}

/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(52)
}
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(57),
  /* template */
  __webpack_require__(58),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/Flash.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Flash.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-da58848a", Component.options)
  } else {
    hotAPI.reload("data-v-da58848a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(53);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(55)("1c1a2c3e", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-da58848a\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-da58848a\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(54)(undefined);
// imports


// module
exports.push([module.i, "\n.fade-enter-active, .fade-leave-active {\n  transition: opacity .5s;\n}\n.fade-enter, .fade-leave-to {\n  opacity: 0;\n}\n", ""]);

// exports


/***/ }),
/* 54 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(56)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 56 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 57 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
	props: ['message', 'title', 'level'],

	data: function data() {
		return {
			body: '',
			show: false,
			type: '',
			heading: '',
			startTransition: false
		};
	},


	computed: {
		classes: function classes() {
			return ['alert', 'alert-flash', 'alert-' + this.type];
		}
	},

	methods: {
		flash: function flash(message, title, level) {
			this.body = message;
			this.type = level;
			this.heading = title;
			this.show = true;

			this.hide();
		},
		hide: function hide() {
			var self = this;

			setTimeout(function () {
				self.startTransition = true;
			}, 4000);
		}
	},

	watch: {
		startTransition: function startTransition(newValue, oldValue) {
			if (newValue) {
				var self = this;

				$('.alert-flash').fadeOut(function () {
					self.show = false;
					self.startTransition = false;
				});
			}
		}
	},

	mounted: function mounted() {
		var self = this;

		if (this.message) {
			this.flash(this.message, this.title, this.level);
		}

		window.events.$on('flash', function (message, title, level) {
			return self.flash(message, title, level);
		});
	}
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('transition', {
    attrs: {
      "name": "fade"
    }
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show),
      expression: "show"
    }],
    class: _vm.classes,
    attrs: {
      "role": "alert"
    }
  }, [(_vm.heading != '') ? _c('h4', {
    staticClass: "alert-heading"
  }, [_vm._v(_vm._s(_vm.heading))]) : _vm._e(), _vm._v(" "), (_vm.heading != '') ? _c('p', [_vm._v(_vm._s(_vm.body))]) : _vm._e(), _vm._v(" "), (_vm.heading == '') ? _c('p', [_vm._v(_vm._s(_vm.body))]) : _vm._e()])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-da58848a", module.exports)
  }
}

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(60),
  /* template */
  __webpack_require__(61),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/Avatar.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Avatar.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0d1a1ac4", Component.options)
  } else {
    hotAPI.reload("data-v-0d1a1ac4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 60 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		item: { type: Object, required: true },
		layout: { type: String, default: 'spread' },
		showContent: { type: Boolean, default: true },
		showName: { type: Boolean, default: true },
		showMetadata: { type: Boolean, default: true },
		showStatus: { type: Boolean, default: true },
		size: { type: String, default: '' },
		type: { type: String, default: 'link' }
	},

	computed: {
		containerClasses: function containerClasses() {
			return ['avatar-container', 'avatar-' + this.layout, 'avatar-' + this.size];
		},
		displayName: function displayName() {
			var pieces = [];

			if (this.isCharacter && this.item.rank != null) {
				pieces.push(this.item.rank.info.name);
			}

			pieces.push(this.item.name);

			return pieces.join(' ');
		},
		imageClasses: function imageClasses() {
			return ['avatar', this.size];
		},
		imageUrl: function imageUrl() {
			return this.item.avatarImage;
		},
		isCharacter: function isCharacter() {
			return _.has(this.item, 'rank_id');
		},
		isUser: function isUser() {
			return _.has(this.item, 'primary_character');
		},
		link: function link() {
			if (this.isUser) {
				return route('profile.show', { user: this.item.id });
			}

			return route('characters.bio', { character: this.item.id });
		},
		positionName: function positionName() {
			if (this.isCharacter) {
				if (this.position) {
					return this.position.name;
				}

				if (this.item.primaryPosition) {
					return this.item.primaryPosition.name;
				}
			}

			return null;
		},
		statusClasses: function statusClasses() {
			var classes = ['avatar-status'];

			if (this.item.user && !this.item.isPrimaryCharacter) {
				classes.push('secondary');
			}

			if (this.item.user && this.item.isPrimaryCharacter) {
				classes.push('primary');
			}

			return classes;
		},
		statusTooltip: function statusTooltip() {
			if (window.Nova.user == null) {
				return null;
			}

			if (this.isCharacter) {
				if (this.item.user) {
					if (this.item.isPrimaryCharacter) {
						return this._m('characters-primary-of', { 2: this.item.user.displayName });
					} else {
						return this._m('characters-pnpc-of', { 2: this.item.user.displayName });
					}
				}

				return this._m('characters-npc');
			}

			return null;
		}
	},

	methods: {
		_m: function _m(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, variables);
		}
	}
});

/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    class: _vm.containerClasses
  }, [_c('div', {
    staticClass: "avatar-image"
  }, [(_vm.type == 'link') ? _c('a', {
    class: _vm.imageClasses,
    style: ('background-image:url(' + _vm.imageUrl + ')'),
    attrs: {
      "href": _vm.link
    }
  }) : _vm._e(), _vm._v(" "), (_vm.type == 'image') ? _c('div', {
    class: _vm.imageClasses,
    style: ('background-image:url(' + _vm.imageUrl + ')')
  }) : _vm._e(), _vm._v(" "), (_vm.showStatus) ? _c('span', {
    class: _vm.statusClasses,
    attrs: {
      "title": _vm.statusTooltip,
      "data-toggle": "tooltip"
    }
  }) : _vm._e()]), _vm._v(" "), (_vm.showContent) ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "avatar-title",
    domProps: {
      "textContent": _vm._s(_vm.displayName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "avatar-meta"
  }, [_vm._t("default", [_vm._v(_vm._s(_vm.positionName))])], 2) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-0d1a1ac4", module.exports)
  }
}

/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(63),
  /* template */
  __webpack_require__(66),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/MediaManager.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MediaManager.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69a642ae", Component.options)
  } else {
    hotAPI.reload("data-v-69a642ae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 63 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_croppie__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_pluralize__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_pluralize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_pluralize__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		allowMultiple: { type: Boolean, default: true },
		item: { type: Object, required: true },
		type: { type: String, required: true }
	},

	data: function data() {
		return {
			crop: {},
			files: this.item.media,
			uploadedFile: ''
		};
	},


	methods: {
		_m: function _m(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, variables);
		},
		createCropper: function createCropper() {
			this.crop = new __WEBPACK_IMPORTED_MODULE_0_croppie___default.a(document.getElementById('crop'), {
				boundary: {
					width: Math.min(500, window.innerWidth - 10),
					height: Math.min(500, window.innerHeight - 10)
				},
				customClass: 'crop-container',
				viewport: {
					width: Math.min(500, window.innerWidth - 10),
					height: Math.min(500, window.innerHeight - 10)
				}
			});
		},
		createFile: function createFile(file) {
			var reader = new FileReader();
			var self = this;

			reader.onload = function (event) {
				self.uploadedFile = event.target.result;

				self.crop.bind({
					url: self.uploadedFile
				});
			};

			reader.readAsDataURL(file);
		},
		deleteFile: function deleteFile(id) {
			var self = this;

			$.confirm({
				title: self._m('media-confirm-delete-title'),
				content: self._m('media-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: self._m('delete'),
						btnClass: "btn-danger",
						action: function action() {
							axios.delete(route('media.destroy', { media: id })).then(function (response) {
								var index = _.findIndex(self.files, function (f) {
									return f.id == id;
								});

								self.files.splice(index, 1);

								flash(self._m('media-flash-deleted-message'), self._m('media-flash-deleted-title'));
							});
						}
					},
					cancel: {
						text: self._m('cancel')
					}
				}
			});
		},
		isPrimary: function isPrimary(file) {
			return file.primary === 1;
		},
		processFile: function processFile(event) {
			var files = event.target.files || event.dataTransfer.files;

			if (!files.length) {
				return;
			}

			this.createFile(files[0]);
		},
		getFile: function getFile(file) {
			return [window.Nova.baseUrl, 'storage', 'app', 'public', __WEBPACK_IMPORTED_MODULE_1_pluralize___default()(this.type), file.filename].join('/');
		},
		makePrimary: function makePrimary(id) {
			axios.patch(route('media.update', { media: id })).catch(function (error) {
				flash(self._m('error-unauthorized-explain'), self._m('error-unauthorized'), 'error');
			});

			_.each(this.files, function (file) {
				if (file.id != id) {
					file.primary = 0;
				} else {
					file.primary = 1;
				}
			});

			flash(self._m('media-flash-primary-image-updated-message'), self._m('media-flash-primary-image-updated-title'));
		},
		reset: function reset() {
			document.getElementById('file-upload').value = '';
			this.uploadedFile = '';
		},
		saveFile: function saveFile() {
			var self = this;

			this.crop.result('canvas').then(function (canvas) {
				axios.post(route('media.store'), {
					image: canvas,
					location: __WEBPACK_IMPORTED_MODULE_1_pluralize___default()(self.type),
					id: self.item.id,
					type: self.type
				}).then(function (response) {
					self.files.push(response.data);

					flash(self._m('media-flash-saved-message'), self._m('media-flash-saved-title'), 'success');
				}).catch(function (error) {
					flash(self._m('error-unauthorized-explain'), self._m('error-unauthorized'), 'error');
				});
			});

			this.reset();
		},
		showIcon: function showIcon(icon) {
			return window.icon(icon);
		}
	},

	mounted: function mounted() {
		this.createCropper();

		if (this.allowMultiple) {
			Sortable.create(document.getElementById('sortable'), {
				draggable: '.draggable-item',
				handle: '.sortable-handle',
				onEnd: function onEnd(event) {
					var _this = this;

					var order = new Array();

					$(event.from).children().each(function () {
						var id = $(_this).data('id');

						if (id) {
							order.push(id);
						}
					});

					axios.patch(route('media.reorder'), {
						media: order
					});
				}
			});
		}
	}
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),
/* 64 */,
/* 65 */,
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (!_vm.uploadedFile),
      expression: "!uploadedFile"
    }]
  }, [(_vm.allowMultiple || (!_vm.allowMultiple && _vm.files.length == 0)) ? _c('div', [_c('label', {
    staticClass: "btn btn-secondary",
    attrs: {
      "for": "file-upload"
    },
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('add'))
    }
  }), _vm._v(" "), _c('input', {
    staticClass: "hidden",
    attrs: {
      "type": "file",
      "id": "file-upload",
      "name": "file"
    },
    on: {
      "change": _vm.processFile
    }
  })]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "row mt-3",
    attrs: {
      "id": "sortable"
    }
  }, _vm._l((_vm.files), function(file) {
    return _c('div', {
      staticClass: "col-sm-6 col-lg-3 draggable-item",
      attrs: {
        "data-id": file.id
      }
    }, [_c('div', {
      staticClass: "card"
    }, [_c('img', {
      staticClass: "card-img-top",
      attrs: {
        "src": _vm.getFile(file)
      }
    }), _vm._v(" "), _c('div', {
      staticClass: "card-footer d-flex justify-content-between"
    }, [_c('div', [(_vm.allowMultiple) ? _c('span', [(!_vm.isPrimary(file)) ? _c('a', {
      staticClass: "card-link mr-2",
      attrs: {
        "href": "#"
      },
      domProps: {
        "innerHTML": _vm._s(_vm.showIcon('star'))
      },
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.makePrimary(file.id)
        }
      }
    }) : _vm._e(), _vm._v(" "), (_vm.isPrimary(file)) ? _c('span', {
      staticClass: "card-link text-warning mr-2",
      domProps: {
        "innerHTML": _vm._s(_vm.showIcon('star'))
      }
    }) : _vm._e()]) : _vm._e(), _vm._v(" "), _c('a', {
      staticClass: "card-link text-danger",
      attrs: {
        "href": "#"
      },
      domProps: {
        "innerHTML": _vm._s(_vm.showIcon('delete'))
      },
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.deleteFile(file.id)
        }
      }
    })]), _vm._v(" "), (_vm.allowMultiple) ? _c('div', [_c('div', {
      staticClass: "card-link text-subtle sortable-handle",
      domProps: {
        "innerHTML": _vm._s(_vm.showIcon('bars'))
      }
    })]) : _vm._e()])])])
  }))]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.uploadedFile),
      expression: "uploadedFile"
    }]
  }, [_c('div', {
    attrs: {
      "id": "crop"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "d-flex justify-content-around"
  }, [_c('span', [_c('button', {
    staticClass: "btn btn-success",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('upload'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.saveFile($event)
      }
    }
  }), _vm._v(" "), _c('button', {
    staticClass: "btn btn-secondary ml-2",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('close'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.reset($event)
      }
    }
  })])])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-69a642ae", module.exports)
  }
}

/***/ }),
/* 67 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(68),
  /* template */
  __webpack_require__(69),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/PositionAvailable.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] PositionAvailable.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-edfade2a", Component.options)
  } else {
    hotAPI.reload("data-v-edfade2a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 68 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_md5__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		position: { type: Object, required: true },
		hasContent: { type: Boolean, default: true },
		showName: { type: Boolean, default: true },
		showMetadata: { type: Boolean, default: true },
		size: { type: String, default: '' },
		type: { type: String, default: 'link' }
	},

	computed: {
		classes: function classes() {
			return ['avatar', this.size];
		},
		joinLink: function joinLink() {
			return route('join');
		},
		positionName: function positionName() {
			return this.position.name;
		},
		url: function url() {
			return [window.Nova.system.baseUrl, 'nova', 'resources', 'assets', 'svg', 'no-avatar.svg'].join('/');
		}
	},

	methods: {
		_m: function _m(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, variables);
		}
	}
});

/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "avatar-container"
  }, [_c('div', {
    staticClass: "avatar-image"
  }, [(_vm.type == 'link') ? _c('a', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')'),
    attrs: {
      "href": _vm.joinLink
    }
  }) : _vm._e(), _vm._v(" "), (_vm.type == 'image') ? _c('div', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')')
  }) : _vm._e()]), _vm._v(" "), (_vm.hasContent) ? _c('div', [(_vm.size == 'lg') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h1",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('a', {
    staticClass: "text-muted",
    attrs: {
      "href": _vm.joinLink
    }
  }, [_vm._v("Apply Now")]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'md') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h4",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('a', {
    staticClass: "text-muted",
    attrs: {
      "href": _vm.joinLink
    }
  }, [_vm._v("Apply Now")]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'sm') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h5 mb-0",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'xs') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h6 mb-0",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == '') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h6 mb-1",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('small', {
    staticClass: "text-muted"
  }, [_c('a', {
    staticClass: "text-muted",
    attrs: {
      "href": _vm.joinLink
    }
  }, [_vm._v("Apply Now")])]) : _vm._e()]) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-edfade2a", module.exports)
  }
}

/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(71),
  /* template */
  __webpack_require__(72),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/RankPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] RankPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d777cbc2", Component.options)
  } else {
    hotAPI.reload("data-v-d777cbc2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Rank_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
	components: { Rank: __WEBPACK_IMPORTED_MODULE_0__Rank_vue___default.a },

	props: {
		selected: { type: Object }
	},

	mixins: [__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__["mixin"]],

	data: function data() {
		return {
			ranks: [],
			search: '',
			selectedRank: false,
			show: false
		};
	},


	computed: {
		filteredRanks: function filteredRanks() {
			var self = this;

			return this.ranks.filter(function (rank) {
				var searchRegex = new RegExp(self.search, 'i');

				return searchRegex.test(rank.info.name) || searchRegex.test(rank.group.name);
			});
		}
	},

	methods: {
		_m: function _m(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, attributes);
		},
		away: function away() {
			this.show = false;
		},
		selectRank: function selectRank(rank) {
			this.selectedRank = rank;
			this.show = false;
			this.search = '';
		},
		showIcon: function showIcon(icon) {
			return window.icon(icon);
		}
	},

	created: function created() {
		var self = this;

		if (this.selected) {
			this.selectedRank = this.selected;
		}

		axios.get(route('api.ranks')).then(function (response) {
			self.ranks = response.data;
		});
	}
});

/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "on-clickaway",
      rawName: "v-on-clickaway",
      value: (_vm.away),
      expression: "away"
    }],
    staticClass: "item-picker"
  }, [_c('div', {
    staticClass: "item-picker-selector"
  }, [(_vm.selectedRank) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('div', {
    staticClass: "spread"
  }, [_c('rank', {
    attrs: {
      "item": _vm.selectedRank
    }
  }), _vm._v(" "), _c('small', {
    staticClass: "meta",
    domProps: {
      "textContent": _vm._s(_vm.selectedRank.info.name)
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.selectedRank.id),
      expression: "selectedRank.id"
    }],
    attrs: {
      "type": "hidden",
      "name": "rank_id"
    },
    domProps: {
      "value": (_vm.selectedRank.id)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.selectedRank.id = $event.target.value
      }
    }
  })]) : _vm._e(), _vm._v(" "), (!_vm.selectedRank) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('rank'), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })], 1)]) : _vm._e(), _vm._v(" "), _vm._t("default")], 2), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show),
      expression: "show"
    }],
    staticClass: "items-menu"
  }, [_c('div', {
    staticClass: "search-group"
  }, [_c('span', {
    staticClass: "search-field"
  }, [_c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('search'))
    }
  }), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.search),
      expression: "search"
    }],
    attrs: {
      "type": "text",
      "placeholder": _vm._m('genre-ranks-find')
    },
    domProps: {
      "value": (_vm.search)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.search = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('a', {
    staticClass: "clear-search ml-2",
    attrs: {
      "href": "#"
    },
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('close-alt'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.search = ''
      }
    }
  })]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.filteredRanks.length == 0),
      expression: "filteredRanks.length == 0"
    }],
    staticClass: "items-menu-alert"
  }, [_c('div', {
    staticClass: "alert alert-warning",
    domProps: {
      "textContent": _vm._s(_vm._m('genre-ranks-error-not-found'))
    }
  })]), _vm._v(" "), (_vm.selectedRank != false) ? _c('div', {
    staticClass: "items-menu-item",
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.selectRank(false)
      }
    }
  }, [_c('rank'), _vm._v(" "), _c('small', {
    staticClass: "meta",
    domProps: {
      "textContent": _vm._s(_vm._m('genre-ranks-none'))
    }
  })], 1) : _vm._e(), _vm._v(" "), _vm._l((_vm.filteredRanks), function(rank) {
    return _c('div', {
      staticClass: "items-menu-item",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectRank(rank)
        }
      }
    }, [_c('rank', {
      attrs: {
        "item": rank
      }
    }), _vm._v(" "), _c('small', {
      staticClass: "meta"
    }, [_vm._v(_vm._s(rank.info.name))])], 1)
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-d777cbc2", module.exports)
  }
}

/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(74),
  /* template */
  __webpack_require__(78),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/UserPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-67d40204", Component.options)
  } else {
    hotAPI.reload("data-v-67d40204", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 74 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue__ = __webpack_require__(75);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		selected: { type: Object }
	},

	components: { UserAvatar: __WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue___default.a },

	mixins: [__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__["mixin"]],

	data: function data() {
		return {
			users: [],
			search: '',
			selectedUser: false,
			show: false
		};
	},


	computed: {
		filteredUsers: function filteredUsers() {
			var self = this;

			return this.users.filter(function (user) {
				var searchRegex = new RegExp(self.search, 'i');

				return searchRegex.test(user.name) || searchRegex.test(user.nickname) || searchRegex.test(user.email);
			});
		}
	},

	methods: {
		_m: function _m(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, attributes);
		},
		away: function away() {
			this.show = false;
		},
		selectUser: function selectUser(user) {
			this.selectedUser = user;
			this.show = false;
			this.search = '';

			window.events.$emit('user-picker-selected', this.selectedUser);
		},
		showIcon: function showIcon(icon) {
			return window.icon(icon);
		}
	},

	created: function created() {
		var self = this;

		if (this.selected) {
			this.selectedUser = this.selected;
		}

		axios.get(route('api.users')).then(function (response) {
			self.users = response.data;
		});

		window.events.$on('user-picker-reset', function () {
			self.selectedUser = false;
		});
	}
});

/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(76),
  /* template */
  __webpack_require__(77),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/UserAvatar.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserAvatar.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-08c45a49", Component.options)
  } else {
    hotAPI.reload("data-v-08c45a49", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_md5__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_humanize_number__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_humanize_number___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_humanize_number__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		hasLabel: { type: Boolean, default: false },
		size: { type: String, default: '' },
		type: { type: String, default: 'link' },
		user: { type: Object, required: true }
	},

	computed: {
		classes: function classes() {
			return ['avatar', this.size];
		},
		hasAfterLabel: function hasAfterLabel() {
			return this.$slots.afterLabel != null;
		},
		hasBeforeLabel: function hasBeforeLabel() {
			return this.$slots.beforeLabel != null;
		},
		profileLink: function profileLink() {
			return route('profile.show', { user: this.user.id });
		},
		url: function url() {
			return this.user.avatarImage;
		}
	}
});

/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "avatar-container"
  }, [(_vm.type == 'link') ? _c('a', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')'),
    attrs: {
      "href": _vm.profileLink
    }
  }) : _vm._e(), _vm._v(" "), (_vm.type != 'link') ? _c('div', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')')
  }) : _vm._e(), _vm._v(" "), (_vm.hasLabel) ? _c('div', [(_vm.size == 'lg') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [_c('span', {
    staticClass: "h1"
  }, [_vm._v(_vm._s(this.user.displayName))]), _vm._v(" "), _c('span', {
    staticClass: "text-muted"
  }, [_vm._t("beforeLabel"), _vm._v(" "), (_vm.hasBeforeLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), (_vm.hasAfterLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), _vm._t("afterLabel")], 2)]) : _vm._e(), _vm._v(" "), (_vm.size == 'md') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [_c('span', {
    staticClass: "h4"
  }, [_vm._v(_vm._s(this.user.displayName))]), _vm._v(" "), _c('span', {
    staticClass: "text-muted"
  }, [_vm._t("beforeLabel"), _vm._v(" "), (_vm.hasBeforeLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), (_vm.hasAfterLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), _vm._t("afterLabel")], 2)]) : _vm._e(), _vm._v(" "), (_vm.size == 'sm') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [_c('span', {
    staticClass: "h5 mb-0"
  }, [_vm._v(_vm._s(this.user.displayName))])]) : _vm._e(), _vm._v(" "), (_vm.size == 'xs') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [_c('span', {
    staticClass: "h6 mb-0"
  }, [_vm._v(_vm._s(this.user.displayName))])]) : _vm._e(), _vm._v(" "), (_vm.size == '') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [_c('span', {
    staticClass: "h6 mb-1"
  }, [_vm._v(_vm._s(this.user.displayName))]), _vm._v(" "), _c('small', {
    staticClass: "text-muted"
  }, [_vm._t("beforeLabel"), _vm._v(" "), (_vm.hasBeforeLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), (_vm.hasAfterLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), _vm._t("afterLabel")], 2)]) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-08c45a49", module.exports)
  }
}

/***/ }),
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "on-clickaway",
      rawName: "v-on-clickaway",
      value: (_vm.away),
      expression: "away"
    }],
    staticClass: "item-picker"
  }, [_c('div', {
    staticClass: "item-picker-selector"
  }, [(_vm.selectedUser) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('avatar', {
    attrs: {
      "item": _vm.selectedUser,
      "show-metadata": false,
      "show-status": false,
      "size": "sm",
      "type": "image"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })], 1), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.selectedUser.id),
      expression: "selectedUser.id"
    }],
    attrs: {
      "type": "hidden",
      "name": "user_id"
    },
    domProps: {
      "value": (_vm.selectedUser.id)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.selectedUser.id = $event.target.value
      }
    }
  })]) : _vm._e(), _vm._v(" "), (!_vm.selectedUser) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('span', {
    domProps: {
      "textContent": _vm._s(_vm._m('users-none'))
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })])]) : _vm._e(), _vm._v(" "), _vm._t("default")], 2), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show),
      expression: "show"
    }],
    staticClass: "items-menu"
  }, [_c('div', {
    staticClass: "search-group"
  }, [_c('span', {
    staticClass: "search-field"
  }, [_c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('search'))
    }
  }), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.search),
      expression: "search"
    }],
    attrs: {
      "type": "text",
      "placeholder": _vm._m('users-find')
    },
    domProps: {
      "value": (_vm.search)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.search = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('a', {
    staticClass: "clear-search ml-2",
    attrs: {
      "href": "#"
    },
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('close-alt'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.search = ''
      }
    }
  })]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.filteredUsers.length == 0),
      expression: "filteredUsers.length == 0"
    }],
    staticClass: "items-menu-alert"
  }, [_c('div', {
    staticClass: "alert alert-warning",
    domProps: {
      "textContent": _vm._s(_vm._m('users-error-not-found'))
    }
  })]), _vm._v(" "), (_vm.selectedUser != false) ? _c('div', {
    staticClass: "items-menu-item",
    domProps: {
      "textContent": _vm._s(_vm._m('users-none'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.selectUser(false)
      }
    }
  }) : _vm._e(), _vm._v(" "), _vm._l((_vm.filteredUsers), function(user) {
    return _c('div', {
      staticClass: "items-menu-item",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectUser(user)
        }
      }
    }, [_c('avatar', {
      attrs: {
        "item": user,
        "show-metadata": false,
        "show-status": false,
        "size": "sm",
        "type": "image"
      }
    })], 1)
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-67d40204", module.exports)
  }
}

/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(80),
  /* template */
  __webpack_require__(81),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/PositionPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] PositionPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d4ba1f48", Component.options)
  } else {
    hotAPI.reload("data-v-d4ba1f48", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 80 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_clickaway__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_clickaway___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_clickaway__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		items: { type: Array },
		onlyAvailable: { type: Boolean, default: true },
		selected: { type: Object, required: false }
	},

	mixins: [__WEBPACK_IMPORTED_MODULE_0_vue_clickaway__["mixin"]],

	data: function data() {
		return {
			positions: [],
			search: '',
			selectedPosition: false,
			show: false
		};
	},


	computed: {
		filteredPositions: function filteredPositions() {
			var self = this;
			var positions = this.positions;

			if (this.onlyAvailable) {
				positions = positions.filter(function (position) {
					return parseInt(position.available) > 0;
				});
			}

			return positions.filter(function (position) {
				var searchRegex = new RegExp(self.search, 'i');

				return searchRegex.test(position.name) || searchRegex.test(position.department.name);
			});
		}
	},

	methods: {
		_m: function _m(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, attributes);
		},
		away: function away() {
			this.show = false;
		},
		selectPosition: function selectPosition(position) {
			this.selectedPosition = position;
			this.show = false;
			this.search = '';
		},
		showIcon: function showIcon(icon) {
			return window.icon(icon);
		}
	},

	created: function created() {
		var self = this;

		if (this.selected) {
			this.selectedPosition = this.selected;
		}

		if (this.items && this.items.length > 0) {
			this.positions = this.items;
		} else {
			axios.get(route('api.positions')).then(function (response) {
				self.positions = response.data;
			});
		}
	}
});

/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "on-clickaway",
      rawName: "v-on-clickaway",
      value: (_vm.away),
      expression: "away"
    }],
    staticClass: "item-picker"
  }, [_c('div', {
    staticClass: "item-picker-selector"
  }, [(_vm.selectedPosition) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('div', {
    staticClass: "stacked"
  }, [_c('span', {
    domProps: {
      "textContent": _vm._s(_vm.selectedPosition.name)
    }
  }), _vm._v(" "), _c('small', {
    staticClass: "meta",
    domProps: {
      "textContent": _vm._s(_vm.selectedPosition.department.name)
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.selectedPosition.id),
      expression: "selectedPosition.id"
    }],
    attrs: {
      "type": "hidden",
      "name": "positions[]"
    },
    domProps: {
      "value": (_vm.selectedPosition.id)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.selectedPosition.id = $event.target.value
      }
    }
  })]) : _vm._e(), _vm._v(" "), (!_vm.selectedPosition) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('span', {
    domProps: {
      "textContent": _vm._s(_vm._m('genre-positions-select'))
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })])]) : _vm._e(), _vm._v(" "), _vm._t("default")], 2), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show),
      expression: "show"
    }],
    staticClass: "items-menu"
  }, [_c('div', {
    staticClass: "search-group"
  }, [_c('span', {
    staticClass: "search-field"
  }, [_c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('search'))
    }
  }), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.search),
      expression: "search"
    }],
    attrs: {
      "type": "text",
      "placeholder": _vm._m('genre-positions-find')
    },
    domProps: {
      "value": (_vm.search)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.search = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('a', {
    staticClass: "clear-search ml-2",
    attrs: {
      "href": "#"
    },
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('close-alt'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.search = ''
      }
    }
  })]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.filteredPositions.length == 0),
      expression: "filteredPositions.length == 0"
    }],
    staticClass: "items-menu-alert"
  }, [_c('div', {
    staticClass: "alert alert-warning",
    domProps: {
      "textContent": _vm._s(_vm._m('genre-positions-error-not-found'))
    }
  })]), _vm._v(" "), _vm._l((_vm.filteredPositions), function(position) {
    return _c('div', {
      staticClass: "items-menu-item stacked",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectPosition(position)
        }
      }
    }, [_c('span', {
      domProps: {
        "textContent": _vm._s(position.name)
      }
    }), _vm._v(" "), _c('small', {
      staticClass: "meta",
      domProps: {
        "textContent": _vm._s(position.department.name)
      }
    })])
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-d4ba1f48", module.exports)
  }
}

/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(83),
  /* template */
  __webpack_require__(87),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/CharacterPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CharacterPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4cb3aba2", Component.options)
  } else {
    hotAPI.reload("data-v-4cb3aba2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 83 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue__ = __webpack_require__(84);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		fieldName: { type: String, default: 'character_id' },
		filter: { type: String },
		items: { type: Array },
		selected: { type: Object },
		showStatus: { type: Boolean, default: false }
	},

	components: { CharacterAvatar: __WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue___default.a },

	mixins: [__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__["mixin"]],

	data: function data() {
		return {
			characters: [],
			search: '',
			selectedCharacter: false,
			show: false
		};
	},


	computed: {
		filteredCharacters: function filteredCharacters() {
			var self = this;
			var filteredCharacters = this.characters;

			if (this.filter == 'unassigned') {
				filteredCharacters = filteredCharacters.filter(function (character) {
					return character.user_id == null;
				});
			}

			return filteredCharacters.filter(function (character) {
				var searchRegex = new RegExp(self.search, 'i');
				var userSearch = void 0;

				if (character.user) {
					userSearch = searchRegex.test(character.user.displayName);
				}

				return searchRegex.test(character.name) || searchRegex.test(character.position.name) || userSearch;
			});
		}
	},

	methods: {
		_m: function _m(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, attributes);
		},
		away: function away() {
			this.show = false;
		},
		selectCharacter: function selectCharacter(character) {
			this.selectedCharacter = character;
			this.show = false;
			this.search = '';

			window.events.$emit('character-picker-selected', this.selectedCharacter);
		},
		showIcon: function showIcon(icon) {
			return window.icon(icon);
		},
		statusClasses: function statusClasses(character) {
			var classes = ['status', 'sm', 'mr-2'];

			if (character.user && !character.isPrimaryCharacter) {
				classes.push('secondary');
			}

			if (character.user && character.isPrimaryCharacter) {
				classes.push('primary');
			}

			return classes;
		}
	},

	created: function created() {
		var self = this;

		if (this.selected) {
			this.selectedCharacter = this.selected;
		}

		if (this.items) {
			this.characters = this.items;
		} else {
			axios.get(route('api.characters')).then(function (response) {
				self.characters = response.data;
			});
		}

		window.events.$on('character-picker-reset', function () {
			self.selectedCharacter = false;
		});
	}
});

/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(85),
  /* template */
  __webpack_require__(86),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/DVS/Sites/nova/dev3/nova/resources/assets/js/components/CharacterAvatar.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CharacterAvatar.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ed3bf226", Component.options)
  } else {
    hotAPI.reload("data-v-ed3bf226", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 85 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_md5__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		character: { type: Object, required: true },
		showContent: { type: Boolean, default: true },
		showName: { type: Boolean, default: true },
		showMetadata: { type: Boolean, default: true },
		showStatus: { type: Boolean, default: false },
		size: { type: String, default: '' },
		type: { type: String, default: 'link' },
		layout: { type: String, default: 'spread' },
		position: { type: Object }
	},

	computed: {
		classes: function classes() {
			return ['avatar', this.size];
		},
		containerClasses: function containerClasses() {
			return ['avatar-container', 'avatar-' + this.layout, 'avatar-' + this.size];
		},
		displayName: function displayName() {
			var pieces = [];

			if (this.character.rank != null) {
				pieces.push(this.character.rank.info.name);
			}

			pieces.push(this.character.name);

			return pieces.join(' ');
		},
		positionName: function positionName() {
			if (this.position) {
				return this.position.name;
			}

			if (this.character.primaryPosition) {
				return this.character.primaryPosition.name;
			}

			return null;
		},
		profileLink: function profileLink() {
			return route('characters.bio', { character: this.character.id });
		},
		statusClasses: function statusClasses() {
			var classes = ['avatar-status'];

			if (this.character.user && !this.character.isPrimaryCharacter) {
				classes.push('secondary');
			}

			if (this.character.user && this.character.isPrimaryCharacter) {
				classes.push('primary');
			}

			return classes;
		},
		statusTooltip: function statusTooltip() {
			if (window.Nova.user == null) {
				return '';
			}

			if (this.character.user) {
				if (this.character.isPrimaryCharacter) {
					return this._m('characters-primary-of', { 2: this.character.user.displayName });
				} else {
					return this._m('characters-pnpc-of', { 2: this.character.user.displayName });
				}
			}

			return this._m('characters-npc');
		},
		url: function url() {
			return this.character.avatarImage;
		}
	},

	methods: {
		_m: function _m(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window._m(key, variables);
		}
	}
});

/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    class: _vm.containerClasses
  }, [_c('div', {
    staticClass: "avatar-image"
  }, [(_vm.type == 'link') ? _c('a', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')'),
    attrs: {
      "href": _vm.profileLink
    }
  }) : _vm._e(), _vm._v(" "), (_vm.type == 'image') ? _c('div', {
    class: _vm.classes,
    style: ('background-image:url(' + _vm.url + ')')
  }) : _vm._e(), _vm._v(" "), (_vm.showStatus) ? _c('span', {
    class: _vm.statusClasses,
    attrs: {
      "title": _vm.statusTooltip,
      "data-toggle": "tooltip"
    }
  }) : _vm._e()]), _vm._v(" "), (_vm.showContent) ? _c('div', [(_vm.size == 'lg') ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h1"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "text-muted",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'md') ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "avatar-title",
    domProps: {
      "textContent": _vm._s(_vm.displayName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "avatar-meta",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'sm') ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "avatar-title",
    domProps: {
      "textContent": _vm._s(_vm.displayName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "avatar-meta",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'xs') ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "avatar-title",
    domProps: {
      "textContent": _vm._s(_vm.displayName)
    }
  }) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "avatar-meta",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == '') ? _c('div', {
    staticClass: "avatar-label"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h6 mb-1"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('small', {
    staticClass: "text-muted",
    domProps: {
      "textContent": _vm._s(_vm.positionName)
    }
  }) : _vm._e()]) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-ed3bf226", module.exports)
  }
}

/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "on-clickaway",
      rawName: "v-on-clickaway",
      value: (_vm.away),
      expression: "away"
    }],
    staticClass: "item-picker"
  }, [_c('div', {
    staticClass: "item-picker-selector"
  }, [(_vm.selectedCharacter) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('avatar', {
    attrs: {
      "item": _vm.selectedCharacter,
      "show-status": _vm.showStatus,
      "size": "sm",
      "type": "image"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })], 1), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.selectedCharacter.id),
      expression: "selectedCharacter.id"
    }],
    attrs: {
      "type": "hidden",
      "name": _vm.fieldName
    },
    domProps: {
      "value": (_vm.selectedCharacter.id)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.selectedCharacter.id = $event.target.value
      }
    }
  })]) : _vm._e(), _vm._v(" "), (!_vm.selectedCharacter) ? _c('div', {
    staticClass: "item-picker-toggle",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show = !_vm.show
      }
    }
  }, [_c('div', {
    staticClass: "item-picker-selected"
  }, [_c('span', {
    domProps: {
      "textContent": _vm._s(_vm._m('characters-none'))
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })]), _vm._v(" "), _c('input', {
    attrs: {
      "type": "hidden",
      "name": _vm.fieldName,
      "value": ""
    }
  })]) : _vm._e(), _vm._v(" "), _vm._t("default")], 2), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.show),
      expression: "show"
    }],
    staticClass: "items-menu"
  }, [_c('div', {
    staticClass: "search-group"
  }, [_c('span', {
    staticClass: "search-field"
  }, [_c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('search'))
    }
  }), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.search),
      expression: "search"
    }],
    attrs: {
      "type": "text",
      "placeholder": _vm._m('characters-find')
    },
    domProps: {
      "value": (_vm.search)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.search = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('a', {
    staticClass: "clear-search ml-2",
    attrs: {
      "href": "#"
    },
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('close-alt'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.search = ''
      }
    }
  })]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.filteredCharacters.length == 0),
      expression: "filteredCharacters.length == 0"
    }],
    staticClass: "items-menu-alert"
  }, [_c('div', {
    staticClass: "alert alert-warning",
    domProps: {
      "textContent": _vm._s(_vm._m('characters-error-not-found'))
    }
  })]), _vm._v(" "), (_vm.selectedCharacter != false) ? _c('div', {
    staticClass: "items-menu-item",
    domProps: {
      "textContent": _vm._s(_vm._m('characters-none'))
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.selectCharacter(false)
      }
    }
  }) : _vm._e(), _vm._v(" "), _vm._l((_vm.filteredCharacters), function(character) {
    return _c('div', {
      staticClass: "items-menu-item",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectCharacter(character)
        }
      }
    }, [_c('avatar', {
      attrs: {
        "item": character,
        "show-status": _vm.showStatus,
        "size": "sm",
        "type": "image"
      }
    })], 1)
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4cb3aba2", module.exports)
  }
}

/***/ }),
/* 88 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 89 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 90 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
],[26]);