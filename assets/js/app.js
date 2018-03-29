webpackJsonp([1],[
/* 0 */,
/* 1 */,
/* 2 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
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
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
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
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
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
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(189)
/* template */
var __vue_template__ = __webpack_require__(190)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/Avatar.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-909eaf4e", Component.options)
  } else {
    hotAPI.reload("data-v-909eaf4e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
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
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
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
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */,
/* 66 */,
/* 67 */,
/* 68 */,
/* 69 */,
/* 70 */,
/* 71 */,
/* 72 */,
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */,
/* 77 */,
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */,
/* 82 */,
/* 83 */,
/* 84 */,
/* 85 */,
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */,
/* 90 */,
/* 91 */,
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */,
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */,
/* 101 */,
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */,
/* 117 */,
/* 118 */,
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */,
/* 125 */,
/* 126 */,
/* 127 */,
/* 128 */,
/* 129 */,
/* 130 */,
/* 131 */,
/* 132 */,
/* 133 */,
/* 134 */,
/* 135 */,
/* 136 */,
/* 137 */,
/* 138 */,
/* 139 */,
/* 140 */,
/* 141 */,
/* 142 */,
/* 143 */,
/* 144 */,
/* 145 */,
/* 146 */,
/* 147 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(179)
/* template */
var __vue_template__ = __webpack_require__(180)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/Rank.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-03cea8a8", Component.options)
  } else {
    hotAPI.reload("data-v-03cea8a8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 148 */,
/* 149 */,
/* 150 */,
/* 151 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(152);
__webpack_require__(212);
module.exports = __webpack_require__(213);


/***/ }),
/* 152 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_Icon_vue__ = __webpack_require__(176);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_Icon_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_Icon_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_Rank_vue__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_Rank_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_Rank_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_Flash_vue__ = __webpack_require__(181);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_Flash_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_Flash_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_Avatar_vue__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_Avatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_Avatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_RankPicker_vue__ = __webpack_require__(191);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_RankPicker_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_RankPicker_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_UserPicker_vue__ = __webpack_require__(194);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_UserPicker_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__components_UserPicker_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_MediaManager_vue__ = __webpack_require__(197);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_MediaManager_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__components_MediaManager_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_PrettyToggle_vue__ = __webpack_require__(200);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_PrettyToggle_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__components_PrettyToggle_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__components_PositionPicker_vue__ = __webpack_require__(203);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__components_PositionPicker_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__components_PositionPicker_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__components_CharacterPicker_vue__ = __webpack_require__(206);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__components_CharacterPicker_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__components_CharacterPicker_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__components_PositionAvailable_vue__ = __webpack_require__(209);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__components_PositionAvailable_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__components_PositionAvailable_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_vue_js_toggle_button__ = __webpack_require__(150);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_vue_js_toggle_button___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11_vue_js_toggle_button__);
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(153);
__webpack_require__(175);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */













Vue.component('rank', Vue.extend(__WEBPACK_IMPORTED_MODULE_1__components_Rank_vue___default.a));
Vue.component('flash', Vue.extend(__WEBPACK_IMPORTED_MODULE_2__components_Flash_vue___default.a));
Vue.component('avatar', Vue.extend(__WEBPACK_IMPORTED_MODULE_3__components_Avatar_vue___default.a));
Vue.component('media-manager', Vue.extend(__WEBPACK_IMPORTED_MODULE_6__components_MediaManager_vue___default.a));
Vue.component('position-available', Vue.extend(__WEBPACK_IMPORTED_MODULE_10__components_PositionAvailable_vue___default.a));
Vue.component('icon', Vue.extend(__WEBPACK_IMPORTED_MODULE_0__components_Icon_vue___default.a));
Vue.component('toggle', Vue.extend(__WEBPACK_IMPORTED_MODULE_7__components_PrettyToggle_vue___default.a));
Vue.component('rank-picker', Vue.extend(__WEBPACK_IMPORTED_MODULE_4__components_RankPicker_vue___default.a));
Vue.component('user-picker', Vue.extend(__WEBPACK_IMPORTED_MODULE_5__components_UserPicker_vue___default.a));
Vue.component('position-picker', Vue.extend(__WEBPACK_IMPORTED_MODULE_8__components_PositionPicker_vue___default.a));
Vue.component('character-picker', Vue.extend(__WEBPACK_IMPORTED_MODULE_9__components_CharacterPicker_vue___default.a));


Vue.use(__WEBPACK_IMPORTED_MODULE_11_vue_js_toggle_button___default.a);

Vue.component('desktop', {
  template: '<div class="hidden md:block" v-cloak><slot></slot></div>'
});

Vue.component('mobile', {
  template: '<div class="sm:block md:hidden" v-cloak><slot></slot></div>'
});

/***/ }),
/* 153 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_webuiPopover, __webpack_provided_window_dot_moment) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash__ = __webpack_require__(134);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lodash__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_jquery__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_jquery__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_moment__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_jquery_confirm__ = __webpack_require__(137);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_jquery_confirm___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_jquery_confirm__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_webui_popover__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_webui_popover___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_webui_popover__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_md5__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_md5___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_md5__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_sortablejs__ = __webpack_require__(139);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_sortablejs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_sortablejs__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_sweetalert2__ = __webpack_require__(140);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_sweetalert2___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8_sweetalert2__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_axios__ = __webpack_require__(141);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9_axios__);











window._ = __WEBPACK_IMPORTED_MODULE_0_lodash___default.a;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.$ = window.jQuery = __WEBPACK_IMPORTED_MODULE_1_jquery___default.a;
	window.jconfirm = __WEBPACK_IMPORTED_MODULE_4_jquery_confirm___default.a;
	__webpack_provided_window_dot_webuiPopover = __WEBPACK_IMPORTED_MODULE_5_webui_popover___default.a;
} catch (e) {}

window.Vue = __WEBPACK_IMPORTED_MODULE_2_vue___default.a;
window.md5 = __WEBPACK_IMPORTED_MODULE_6_md5___default.a;
__webpack_provided_window_dot_moment = __WEBPACK_IMPORTED_MODULE_3_moment___default.a;
window.Sortable = __WEBPACK_IMPORTED_MODULE_7_sortablejs___default.a;
window.swal = __WEBPACK_IMPORTED_MODULE_8_sweetalert2___default.a;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __WEBPACK_IMPORTED_MODULE_9_axios___default.a;
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

window.events = new __WEBPACK_IMPORTED_MODULE_2_vue___default.a();

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

window.lang = function (key) {
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(7), __webpack_require__(0)))

/***/ }),
/* 154 */,
/* 155 */,
/* 156 */,
/* 157 */,
/* 158 */,
/* 159 */,
/* 160 */,
/* 161 */,
/* 162 */,
/* 163 */,
/* 164 */,
/* 165 */,
/* 166 */,
/* 167 */,
/* 168 */,
/* 169 */,
/* 170 */,
/* 171 */,
/* 172 */,
/* 173 */,
/* 174 */,
/* 175 */
/***/ (function(module, exports) {

/**
 * All credit goes to the folks at Bulma.io for this stuff. The simplicity
 * of this stuff is amazing and they really should consider wrapping all
 * of this up into a small Javascript companion library that works with
 * their framework!
 */

document.addEventListener('DOMContentLoaded', function () {
	/**
  * Dropdowns
  */

	var $dropdowns = getAll('.dropdown:not(.is-hoverable)');

	if ($dropdowns.length > 0) {
		$dropdowns.forEach(function ($el) {
			$el.addEventListener('click', function (event) {
				event.stopPropagation();
				$el.classList.toggle('is-active');
			});
		});

		document.addEventListener('click', function (event) {
			closeDropdowns();
		});
	}

	function closeDropdowns() {
		$dropdowns.forEach(function ($el) {
			$el.classList.remove('is-active');
		});
	}

	/**
  * Modals
  */

	var rootEl = document.documentElement;
	var $modals = getAll('.modal');
	var $modalButtons = getAll('.modal-button');
	var $modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');

	if ($modalButtons.length > 0) {
		$modalButtons.forEach(function ($el) {
			$el.addEventListener('click', function () {
				var target = $el.dataset.target;
				var $target = document.getElementById(target);
				rootEl.classList.add('is-clipped');
				$target.classList.add('is-active');
			});
		});
	}

	if ($modalCloses.length > 0) {
		$modalCloses.forEach(function ($el) {
			$el.addEventListener('click', function () {
				closeModals();
			});
		});
	}

	document.addEventListener('keydown', function (event) {
		var e = event || window.event;

		if (e.keyCode === 27) {
			closeModals();
			closeDropdowns();
		}
	});

	function closeModals() {
		rootEl.classList.remove('is-clipped');

		$modals.forEach(function ($el) {
			$el.classList.remove('is-active');
		});
	}

	/**
  * Functions
  */

	function getAll(selector) {
		return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
	}
});

/***/ }),
/* 176 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(177)
/* template */
var __vue_template__ = __webpack_require__(178)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/Icon.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7a4ca50e", Component.options)
  } else {
    hotAPI.reload("data-v-7a4ca50e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 177 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		name: { type: String, required: true },
		size: { type: String },
		wrapper: { type: Object },
		attributes: { type: Object },
		classes: { type: String }
	},

	computed: {
		wrapperAttributes: function wrapperAttributes() {
			return _.mergeWith({}, this.wrapper, { class: 'icon-wrapper' }, function (objValue, srcValue, key, object) {
				if (object.hasOwnProperty(key)) {
					return object[key].concat(' ' + srcValue);
				}
			});
		}
	},

	methods: {
		renderIcon: function renderIcon() {
			var template = Nova.iconTemplate.replace(/{icon}/g, Nova.icons[this.name]);

			var parser = new DOMParser();

			var $icon = parser.parseFromString(template, 'text/html').body.firstChild;

			var attributes = {};

			_.forEach($icon.attributes, function (a) {
				attributes[a.nodeName] = a.nodeValue;
			});

			if (this.size) {
				attributes['class'] = 'is-' + this.size + ' ' + attributes['class'];
			}

			if (this.classes) {
				attributes['class'] = this.classes + ' ' + attributes['class'];
			}

			if (this.attributes) {
				attributes = _.mergeWith({}, this.attributes, attributes, function (objValue, srcValue, key, object) {
					if (object.hasOwnProperty(key)) {
						return object[key].concat(' ' + srcValue);
					}
				});
			}

			_.forEach(attributes, function (value, name) {
				$icon.setAttribute(name, value);
			});

			return $icon.outerHTML;
		}
	}
});

/***/ }),
/* 178 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    _vm._b(
      { domProps: { innerHTML: _vm._s(_vm.renderIcon()) } },
      "div",
      _vm.wrapperAttributes,
      false
    )
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7a4ca50e", module.exports)
  }
}

/***/ }),
/* 179 */
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
/* 180 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "rank-container" }, [
    _c("div", { staticClass: "rank-overlay", style: _vm.overlayStyle() }),
    _vm._v(" "),
    _c("div", { staticClass: "rank-base", style: _vm.baseStyle() })
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-03cea8a8", module.exports)
  }
}

/***/ }),
/* 181 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(182)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(187)
/* template */
var __vue_template__ = __webpack_require__(188)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/Flash.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ad0a36c0", Component.options)
  } else {
    hotAPI.reload("data-v-ad0a36c0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 182 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(183);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(185)("7cce6257", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ad0a36c0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ad0a36c0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 183 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(184)(false);
// imports


// module
exports.push([module.i, "\n.fade-enter-active,\n.fade-leave-active {\n  -webkit-transition: opacity .5s;\n  transition: opacity .5s;\n}\n.fade-enter,\n.fade-leave-to {\n  opacity: 0;\n}\n", ""]);

// exports


/***/ }),
/* 184 */
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
/* 185 */
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

var listToStyles = __webpack_require__(186)

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
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

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
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

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
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
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
/* 186 */
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
/* 187 */
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(3)))

/***/ }),
/* 188 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "fade" } }, [
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.show,
            expression: "show"
          }
        ],
        class: _vm.classes,
        attrs: { role: "alert" }
      },
      [
        _vm.heading != ""
          ? _c("h4", { staticClass: "alert-heading" }, [
              _vm._v(_vm._s(_vm.heading))
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.heading != "" ? _c("p", [_vm._v(_vm._s(_vm.body))]) : _vm._e(),
        _vm._v(" "),
        _vm.heading == "" ? _c("p", [_vm._v(_vm._s(_vm.body))]) : _vm._e()
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-ad0a36c0", module.exports)
  }
}

/***/ }),
/* 189 */
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
			return this.item.displayName;

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

			// Character
			if (this.item.user_id !== undefined) {
				if (this.item.isPrimaryCharacter) {
					classes.push('primary');
				}

				if (this.item.user !== null && !this.item.isPrimaryCharacter) {
					classes.push('secondary');
				}

				if (this.item.status == 1) {
					classes.push('success');
				}

				if (this.item.status == 3) {
					classes.push('warning');
				}

				if (this.item.status == 4) {
					classes.push('danger');
				}
			}

			// User
			if (this.item.primary_character !== undefined) {
				if (this.item.status == 1) {
					classes.push('success');
				}

				if (this.item.status == 2) {
					classes.push('primary');
				}

				if (this.item.status == 3) {
					classes.push('warning');
				}

				if (this.item.status == 4) {
					classes.push('danger');
				}
			}

			return classes;
		},
		statusTooltip: function statusTooltip() {
			if (window.Nova.user == null) {
				return null;
			}

			if (this.isCharacter) {
				if (this.item.user && this.item.status == 2) {
					if (this.item.isPrimaryCharacter) {
						return this.lang('characters-primary-of', { 2: this.item.user.displayName });
					} else {
						return this.lang('characters-character-of', { 2: this.item.user.displayName });
					}
				}

				if (this.item.status == 1) {
					return this.lang('characters-pending');
				}

				if (this.item.status == 3) {
					return this.lang('characters-inactive');
				}

				if (this.item.status == 4) {
					return this.lang('characters-removed');
				}

				return this.lang('characters-npc');
			}

			return null;
		}
	},

	methods: {
		lang: function lang(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, variables);
		}
	}
});

/***/ }),
/* 190 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { class: _vm.containerClasses }, [
    _c("div", { staticClass: "avatar-image" }, [
      _vm.type == "link"
        ? _c("a", {
            class: _vm.imageClasses,
            style: "background-image:url(" + _vm.imageUrl + ")",
            attrs: { href: _vm.link }
          })
        : _vm._e(),
      _vm._v(" "),
      _vm.type == "image"
        ? _c("div", {
            class: _vm.imageClasses,
            style: "background-image:url(" + _vm.imageUrl + ")"
          })
        : _vm._e(),
      _vm._v(" "),
      _vm.showStatus
        ? _c("span", {
            class: _vm.statusClasses,
            attrs: { title: _vm.statusTooltip, "data-toggle": "tooltip" }
          })
        : _vm._e()
    ]),
    _vm._v(" "),
    _vm.showContent
      ? _c("div", { staticClass: "avatar-label" }, [
          _vm.showName
            ? _c("span", {
                staticClass: "avatar-title",
                domProps: { textContent: _vm._s(_vm.displayName) }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showMetadata
            ? _c(
                "span",
                { staticClass: "avatar-meta" },
                [_vm._t("default", [_vm._v(_vm._s(_vm.positionName))])],
                2
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-909eaf4e", module.exports)
  }
}

/***/ }),
/* 191 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(192)
/* template */
var __vue_template__ = __webpack_require__(193)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/RankPicker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-262b0b4c", Component.options)
  } else {
    hotAPI.reload("data-v-262b0b4c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 192 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Rank_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(4);
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
		character: { type: Object, required: false, default: null },
		initialRanks: { type: Array, required: false, default: null },
		selected: { type: Object, required: false, default: null }
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
		away: function away() {
			this.show = false;
		},
		lang: function lang(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, attributes);
		},
		selectRank: function selectRank(rank) {
			this.selectedRank = rank;
			this.show = false;
			this.search = '';

			window.events.$emit('rank-picker-selected', this.selectedRank, this.character);
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

		if (this.initialRanks != null) {
			this.ranks = this.initialRanks;
		} else {
			axios.get(route('api.ranks')).then(function (response) {
				self.ranks = response.data;
			});
		}
	}
});

/***/ }),
/* 193 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "on-clickaway",
          rawName: "v-on-clickaway",
          value: _vm.away,
          expression: "away"
        }
      ],
      staticClass: "item-picker"
    },
    [
      _c(
        "div",
        { staticClass: "item-picker-selector" },
        [
          _vm.selectedRank
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c("div", { staticClass: "item-picker-selected" }, [
                    _c(
                      "div",
                      { staticClass: "spread" },
                      [
                        _c("rank", { attrs: { item: _vm.selectedRank } }),
                        _vm._v(" "),
                        _c("small", {
                          staticClass: "meta",
                          domProps: {
                            textContent: _vm._s(_vm.selectedRank.info.name)
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "ml-3",
                      domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                    })
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selectedRank.id,
                        expression: "selectedRank.id"
                      }
                    ],
                    attrs: { type: "hidden", name: "rank_id" },
                    domProps: { value: _vm.selectedRank.id },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.selectedRank, "id", $event.target.value)
                      }
                    }
                  })
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.selectedRank
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c(
                    "div",
                    { staticClass: "item-picker-selected" },
                    [
                      _c("rank"),
                      _vm._v(" "),
                      _c("div", {
                        staticClass: "ml-3",
                        domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                      })
                    ],
                    1
                  )
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._t("default")
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.show,
              expression: "show"
            }
          ],
          staticClass: "items-menu"
        },
        [
          _c("div", { staticClass: "search-group" }, [
            _c("span", { staticClass: "search-field" }, [
              _c("div", {
                domProps: { innerHTML: _vm._s(_vm.showIcon("search")) }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search,
                    expression: "search"
                  }
                ],
                attrs: {
                  type: "text",
                  placeholder: _vm.lang("genre-ranks-find")
                },
                domProps: { value: _vm.search },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.search = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("a", {
              staticClass: "clear-search ml-2",
              attrs: { href: "#" },
              domProps: { innerHTML: _vm._s(_vm.showIcon("close-alt")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.search = ""
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.filteredRanks.length == 0,
                  expression: "filteredRanks.length == 0"
                }
              ],
              staticClass: "items-menu-alert"
            },
            [
              _c("div", {
                staticClass: "alert alert-warning",
                domProps: {
                  textContent: _vm._s(_vm.lang("genre-ranks-error-not-found"))
                }
              })
            ]
          ),
          _vm._v(" "),
          _vm.selectedRank != false
            ? _c(
                "div",
                {
                  staticClass: "items-menu-item",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.selectRank(false)
                    }
                  }
                },
                [
                  _c("rank"),
                  _vm._v(" "),
                  _c("small", {
                    staticClass: "meta",
                    domProps: {
                      textContent: _vm._s(_vm.lang("genre-ranks-none"))
                    }
                  })
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._l(_vm.filteredRanks, function(rank) {
            return _c(
              "div",
              {
                staticClass: "items-menu-item",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectRank(rank)
                  }
                }
              },
              [
                _c("rank", { attrs: { item: rank } }),
                _vm._v(" "),
                _c("small", { staticClass: "meta" }, [
                  _vm._v(_vm._s(rank.info.name))
                ])
              ],
              1
            )
          })
        ],
        2
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-262b0b4c", module.exports)
  }
}

/***/ }),
/* 194 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(195)
/* template */
var __vue_template__ = __webpack_require__(196)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/UserPicker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-24bc5f39", Component.options)
  } else {
    hotAPI.reload("data-v-24bc5f39", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 195 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Avatar_vue__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Avatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Avatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(4);
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
		fieldName: { type: String, default: 'user_id' },
		items: { type: Array },
		selected: { type: Object }
	},

	components: { Avatar: __WEBPACK_IMPORTED_MODULE_0__Avatar_vue___default.a },

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
		away: function away() {
			this.show = false;
		},
		fetch: function fetch() {
			var self = this;

			if (this.items) {
				this.users = this.items;
			} else {
				axios.get(route('api.users')).then(function (response) {
					self.users = response.data;
				});
			}
		},
		lang: function lang(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, attributes);
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

		this.fetch();

		window.events.$on('user-picker-refresh', function () {
			self.fetch();
		});

		window.events.$on('user-picker-reset', function () {
			self.selectedUser = false;
		});
	}
});

/***/ }),
/* 196 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "on-clickaway",
          rawName: "v-on-clickaway",
          value: _vm.away,
          expression: "away"
        }
      ],
      staticClass: "item-picker"
    },
    [
      _c(
        "div",
        { staticClass: "item-picker-selector" },
        [
          _vm.selectedUser
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c(
                    "div",
                    { staticClass: "item-picker-selected" },
                    [
                      _c("avatar", {
                        attrs: {
                          item: _vm.selectedUser,
                          "show-metadata": false,
                          "show-status": false,
                          size: "sm",
                          type: "image"
                        }
                      }),
                      _vm._v(" "),
                      _c("div", {
                        staticClass: "ml-3",
                        domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selectedUser.id,
                        expression: "selectedUser.id"
                      }
                    ],
                    attrs: { type: "hidden", name: _vm.fieldName },
                    domProps: { value: _vm.selectedUser.id },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.selectedUser, "id", $event.target.value)
                      }
                    }
                  })
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.selectedUser
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c("div", { staticClass: "item-picker-selected" }, [
                    _c("span", {
                      domProps: { textContent: _vm._s(_vm.lang("users-none")) }
                    }),
                    _vm._v(" "),
                    _c("span", {
                      staticClass: "ml-3",
                      domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                    })
                  ])
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._t("default")
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.show,
              expression: "show"
            }
          ],
          staticClass: "items-menu"
        },
        [
          _c("div", { staticClass: "search-group" }, [
            _c("span", { staticClass: "search-field" }, [
              _c("div", {
                domProps: { innerHTML: _vm._s(_vm.showIcon("search")) }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search,
                    expression: "search"
                  }
                ],
                attrs: { type: "text", placeholder: _vm.lang("users-find") },
                domProps: { value: _vm.search },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.search = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("a", {
              staticClass: "clear-search ml-2",
              attrs: { href: "#" },
              domProps: { innerHTML: _vm._s(_vm.showIcon("close-alt")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.search = ""
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.filteredUsers.length == 0,
                  expression: "filteredUsers.length == 0"
                }
              ],
              staticClass: "items-menu-alert"
            },
            [
              _c("div", {
                staticClass: "alert alert-warning",
                domProps: {
                  textContent: _vm._s(_vm.lang("users-error-not-found"))
                }
              })
            ]
          ),
          _vm._v(" "),
          _vm.selectedUser != false
            ? _c("div", {
                staticClass: "items-menu-item",
                domProps: { textContent: _vm._s(_vm.lang("users-none")) },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectUser(false)
                  }
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm._l(_vm.filteredUsers, function(user) {
            return _c(
              "div",
              {
                staticClass: "items-menu-item",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectUser(user)
                  }
                }
              },
              [
                _c("avatar", {
                  attrs: {
                    item: user,
                    "show-metadata": false,
                    "show-status": false,
                    size: "sm",
                    type: "image"
                  }
                })
              ],
              1
            )
          })
        ],
        2
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-24bc5f39", module.exports)
  }
}

/***/ }),
/* 197 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(198)
/* template */
var __vue_template__ = __webpack_require__(199)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/MediaManager.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-32358029", Component.options)
  } else {
    hotAPI.reload("data-v-32358029", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 198 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_croppie__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_pluralize__ = __webpack_require__(149);
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
				title: self.lang('media-confirm-delete-title'),
				content: self.lang('media-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: self.lang('delete'),
						btnClass: "btn-danger",
						action: function action() {
							axios.delete(route('media.destroy', { media: id })).then(function (response) {
								var index = _.findIndex(self.files, function (f) {
									return f.id == id;
								});

								self.files.splice(index, 1);

								flash(self.lang('media-flash-deleted-message'), self.lang('media-flash-deleted-title'));
							});
						}
					},
					cancel: {
						text: self.lang('cancel')
					}
				}
			});
		},
		isPrimary: function isPrimary(file) {
			return file.primary === 1;
		},
		lang: function lang(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, variables);
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
				flash(self.lang('error-unauthorized-explain'), self.lang('error-unauthorized'), 'error');
			});

			_.each(this.files, function (file) {
				if (file.id != id) {
					file.primary = 0;
				} else {
					file.primary = 1;
				}
			});

			flash(self.lang('media-flash-primary-image-updated-message'), self.lang('media-flash-primary-image-updated-title'));
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

					flash(self.lang('media-flash-saved-message'), self.lang('media-flash-saved-title'), 'success');
				}).catch(function (error) {
					flash(self.lang('error-unauthorized-explain'), self.lang('error-unauthorized'), 'error');
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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(3)))

/***/ }),
/* 199 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "form-group" }, [
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: !_vm.uploadedFile,
            expression: "!uploadedFile"
          }
        ]
      },
      [
        _vm.allowMultiple || (!_vm.allowMultiple && _vm.files.length == 0)
          ? _c("div", [
              _c("label", {
                staticClass: "btn btn-secondary",
                attrs: { for: "file-upload" },
                domProps: { innerHTML: _vm._s(_vm.showIcon("add")) }
              }),
              _vm._v(" "),
              _c("input", {
                staticClass: "hidden",
                attrs: { type: "file", id: "file-upload", name: "file" },
                on: { change: _vm.processFile }
              })
            ])
          : _vm._e(),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "row mt-3", attrs: { id: "sortable" } },
          _vm._l(_vm.files, function(file) {
            return _c(
              "div",
              {
                staticClass: "col-sm-6 col-lg-3 draggable-item",
                attrs: { "data-id": file.id }
              },
              [
                _c("div", { staticClass: "card" }, [
                  _c("img", {
                    staticClass: "card-img-top",
                    attrs: { src: _vm.getFile(file) }
                  }),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "card-footer d-flex justify-content-between"
                    },
                    [
                      _c("div", [
                        _vm.allowMultiple
                          ? _c("span", [
                              !_vm.isPrimary(file)
                                ? _c("a", {
                                    staticClass: "card-link mr-2",
                                    attrs: { href: "#" },
                                    domProps: {
                                      innerHTML: _vm._s(_vm.showIcon("star"))
                                    },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        _vm.makePrimary(file.id)
                                      }
                                    }
                                  })
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.isPrimary(file)
                                ? _c("span", {
                                    staticClass: "card-link text-warning mr-2",
                                    domProps: {
                                      innerHTML: _vm._s(_vm.showIcon("star"))
                                    }
                                  })
                                : _vm._e()
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("a", {
                          staticClass: "card-link text-danger",
                          attrs: { href: "#" },
                          domProps: {
                            innerHTML: _vm._s(_vm.showIcon("delete"))
                          },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              _vm.deleteFile(file.id)
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _vm.allowMultiple
                        ? _c("div", [
                            _c("div", {
                              staticClass:
                                "card-link text-subtle sortable-handle",
                              domProps: {
                                innerHTML: _vm._s(_vm.showIcon("bars"))
                              }
                            })
                          ])
                        : _vm._e()
                    ]
                  )
                ])
              ]
            )
          })
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.uploadedFile,
            expression: "uploadedFile"
          }
        ]
      },
      [
        _c("div", { attrs: { id: "crop" } }),
        _vm._v(" "),
        _c("div", { staticClass: "d-flex justify-content-around" }, [
          _c("span", [
            _c("button", {
              staticClass: "btn btn-success",
              domProps: { innerHTML: _vm._s(_vm.showIcon("upload")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.saveFile($event)
                }
              }
            }),
            _vm._v(" "),
            _c("button", {
              staticClass: "btn btn-secondary ml-2",
              domProps: { innerHTML: _vm._s(_vm.showIcon("close")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.reset($event)
                }
              }
            })
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-32358029", module.exports)
  }
}

/***/ }),
/* 200 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(201)
/* template */
var __vue_template__ = __webpack_require__(202)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/PrettyToggle.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-591807ea", Component.options)
  } else {
    hotAPI.reload("data-v-591807ea", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 201 */
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

/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		type: { type: String, required: true },
		name: { type: String, required: true },
		value: { type: String, required: true }
	},

	computed: {
		stateClasses: function stateClasses() {
			var pieces = ['state'];

			if (this.type == 'switch') {
				pieces.push('p-success');
			}

			return pieces;
		},
		wrapperClasses: function wrapperClasses() {
			var pieces = ['pretty', 'p-smooth'];

			if (this.type == 'checkbox') {
				pieces.push('p-default');
				pieces.push('p-curve');
				pieces.push('p-thick');
			}

			if (this.type == 'radio') {
				pieces.push('p-default');
				pieces.push('p-round');
				pieces.push('p-thick');
			}

			if (this.type == 'switch') {
				pieces.push('p-switch');
				pieces.push('p-fill');
			}

			return pieces;
		}
	}
});

/***/ }),
/* 202 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { class: _vm.wrapperClasses }, [
    _vm.type == "checkbox" || _vm.type == "switch"
      ? _c("input", {
          attrs: { type: "checkbox", name: _vm.name },
          domProps: { value: _vm.value }
        })
      : _vm._e(),
    _vm._v(" "),
    _vm.type == "radio"
      ? _c("input", {
          attrs: { type: "radio", name: _vm.name },
          domProps: { value: _vm.value }
        })
      : _vm._e(),
    _vm._v(" "),
    _c(
      "div",
      { class: _vm.stateClasses },
      [_vm._t("icon"), _vm._v(" "), _vm._t("label")],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-591807ea", module.exports)
  }
}

/***/ }),
/* 203 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(204)
/* template */
var __vue_template__ = __webpack_require__(205)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/PositionPicker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7758bb17", Component.options)
  } else {
    hotAPI.reload("data-v-7758bb17", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 204 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_clickaway__ = __webpack_require__(4);
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
		away: function away() {
			this.show = false;
		},
		lang: function lang(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, attributes);
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
/* 205 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "on-clickaway",
          rawName: "v-on-clickaway",
          value: _vm.away,
          expression: "away"
        }
      ],
      staticClass: "item-picker"
    },
    [
      _c(
        "div",
        { staticClass: "item-picker-selector" },
        [
          _vm.selectedPosition
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c("div", { staticClass: "item-picker-selected" }, [
                    _c("div", { staticClass: "stacked" }, [
                      _c("span", {
                        domProps: {
                          textContent: _vm._s(_vm.selectedPosition.name)
                        }
                      }),
                      _vm._v(" "),
                      _c("small", {
                        staticClass: "meta",
                        domProps: {
                          textContent: _vm._s(
                            _vm.selectedPosition.department.name
                          )
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "ml-3",
                      domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                    })
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selectedPosition.id,
                        expression: "selectedPosition.id"
                      }
                    ],
                    attrs: { type: "hidden", name: "positions[]" },
                    domProps: { value: _vm.selectedPosition.id },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.selectedPosition,
                          "id",
                          $event.target.value
                        )
                      }
                    }
                  })
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.selectedPosition
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c("div", { staticClass: "item-picker-selected" }, [
                    _c("span", {
                      domProps: {
                        textContent: _vm._s(_vm.lang("genre-positions-select"))
                      }
                    }),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "ml-3",
                      domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                    })
                  ])
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._t("default")
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.show,
              expression: "show"
            }
          ],
          staticClass: "items-menu"
        },
        [
          _c("div", { staticClass: "search-group" }, [
            _c("span", { staticClass: "search-field" }, [
              _c("div", {
                domProps: { innerHTML: _vm._s(_vm.showIcon("search")) }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search,
                    expression: "search"
                  }
                ],
                attrs: {
                  type: "text",
                  placeholder: _vm.lang("genre-positions-find")
                },
                domProps: { value: _vm.search },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.search = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("a", {
              staticClass: "clear-search ml-2",
              attrs: { href: "#" },
              domProps: { innerHTML: _vm._s(_vm.showIcon("close-alt")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.search = ""
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.filteredPositions.length == 0,
                  expression: "filteredPositions.length == 0"
                }
              ],
              staticClass: "items-menu-alert"
            },
            [
              _c("div", {
                staticClass: "alert alert-warning",
                domProps: {
                  textContent: _vm._s(
                    _vm.lang("genre-positions-error-not-found")
                  )
                }
              })
            ]
          ),
          _vm._v(" "),
          _vm._l(_vm.filteredPositions, function(position) {
            return _c(
              "div",
              {
                staticClass: "items-menu-item stacked",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectPosition(position)
                  }
                }
              },
              [
                _c("span", {
                  domProps: { textContent: _vm._s(position.name) }
                }),
                _vm._v(" "),
                _c("small", {
                  staticClass: "meta",
                  domProps: { textContent: _vm._s(position.department.name) }
                })
              ]
            )
          })
        ],
        2
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7758bb17", module.exports)
  }
}

/***/ }),
/* 206 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(207)
/* template */
var __vue_template__ = __webpack_require__(208)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/CharacterPicker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-bc918f72", Component.options)
  } else {
    hotAPI.reload("data-v-bc918f72", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 207 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Avatar_vue__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Avatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Avatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(4);
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

	components: { Avatar: __WEBPACK_IMPORTED_MODULE_0__Avatar_vue___default.a },

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

				return searchRegex.test(character.displayName) || searchRegex.test(character.primaryPosition.name) || userSearch;
			});
		}
	},

	methods: {
		away: function away() {
			this.show = false;
		},
		fetch: function fetch() {
			var self = this;

			if (this.items) {
				this.characters = this.items;
			} else {
				axios.get(route('api.characters')).then(function (response) {
					self.characters = response.data;
				});
			}
		},
		lang: function lang(key) {
			var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, attributes);
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

		this.fetch();

		window.events.$on('character-picker-refresh', function () {
			self.fetch();
		});

		window.events.$on('character-picker-reset', function () {
			self.selectedCharacter = false;
		});
	}
});

/***/ }),
/* 208 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "on-clickaway",
          rawName: "v-on-clickaway",
          value: _vm.away,
          expression: "away"
        }
      ],
      staticClass: "item-picker"
    },
    [
      _c(
        "div",
        { staticClass: "item-picker-selector" },
        [
          _vm.selectedCharacter
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c(
                    "div",
                    { staticClass: "item-picker-selected" },
                    [
                      _c("avatar", {
                        attrs: {
                          item: _vm.selectedCharacter,
                          "show-status": _vm.showStatus,
                          size: "sm",
                          type: "image"
                        }
                      }),
                      _vm._v(" "),
                      _c("div", {
                        staticClass: "ml-3",
                        domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selectedCharacter.id,
                        expression: "selectedCharacter.id"
                      }
                    ],
                    attrs: { type: "hidden", name: _vm.fieldName },
                    domProps: { value: _vm.selectedCharacter.id },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.selectedCharacter,
                          "id",
                          $event.target.value
                        )
                      }
                    }
                  })
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.selectedCharacter
            ? _c(
                "div",
                {
                  staticClass: "item-picker-toggle",
                  attrs: { role: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.show = !_vm.show
                    }
                  }
                },
                [
                  _c("div", { staticClass: "item-picker-selected" }, [
                    _c("span", {
                      domProps: {
                        textContent: _vm._s(_vm.lang("characters-none"))
                      }
                    }),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "ml-3",
                      domProps: { innerHTML: _vm._s(_vm.showIcon("more")) }
                    })
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: _vm.fieldName, value: "" }
                  })
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._t("default")
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.show,
              expression: "show"
            }
          ],
          staticClass: "items-menu"
        },
        [
          _c("div", { staticClass: "search-group" }, [
            _c("span", { staticClass: "search-field" }, [
              _c("div", {
                domProps: { innerHTML: _vm._s(_vm.showIcon("search")) }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search,
                    expression: "search"
                  }
                ],
                attrs: {
                  type: "text",
                  placeholder: _vm.lang("characters-find")
                },
                domProps: { value: _vm.search },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.search = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("a", {
              staticClass: "clear-search ml-2",
              attrs: { href: "#" },
              domProps: { innerHTML: _vm._s(_vm.showIcon("close-alt")) },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.search = ""
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.filteredCharacters.length == 0,
                  expression: "filteredCharacters.length == 0"
                }
              ],
              staticClass: "items-menu-alert"
            },
            [
              _c("div", {
                staticClass: "alert alert-warning",
                domProps: {
                  textContent: _vm._s(_vm.lang("characters-error-not-found"))
                }
              })
            ]
          ),
          _vm._v(" "),
          _vm.selectedCharacter != false
            ? _c("div", {
                staticClass: "items-menu-item",
                domProps: { textContent: _vm._s(_vm.lang("characters-none")) },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectCharacter(false)
                  }
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm._l(_vm.filteredCharacters, function(character) {
            return _c(
              "div",
              {
                staticClass: "items-menu-item",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.selectCharacter(character)
                  }
                }
              },
              [
                _c("avatar", {
                  attrs: {
                    item: character,
                    "show-status": _vm.showStatus,
                    size: "sm",
                    type: "image"
                  }
                })
              ],
              1
            )
          })
        ],
        2
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-bc918f72", module.exports)
  }
}

/***/ }),
/* 209 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(210)
/* template */
var __vue_template__ = __webpack_require__(211)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "nova/resources/assets/js/components/PositionAvailable.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a954ef60", Component.options)
  } else {
    hotAPI.reload("data-v-a954ef60", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 210 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(8);
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



/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		layout: { type: String, default: 'spread' },
		position: { type: Object, required: true },
		showContent: { type: Boolean, default: true },
		showImage: { type: Boolean, default: true },
		showName: { type: Boolean, default: true },
		showMetadata: { type: Boolean, default: true },
		size: { type: String, default: '' },
		type: { type: String, default: 'link' }
	},

	computed: {
		containerClasses: function containerClasses() {
			return ['avatar-container', 'avatar-' + this.layout, 'avatar-' + this.size];
		},
		imageClasses: function imageClasses() {
			return ['avatar', this.size];
		},
		imageUrl: function imageUrl() {
			return [window.Nova.system.baseUrl, 'nova', 'resources', 'assets', 'svg', 'no-avatar.svg'].join('/');
		},
		joinLink: function joinLink() {
			return route('join');
		},
		positionName: function positionName() {
			return this.position.name;
		}
	},

	methods: {
		lang: function lang(key) {
			var variables = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

			return window.lang(key, variables);
		}
	}
});

/***/ }),
/* 211 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { class: _vm.containerClasses }, [
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.showImage,
            expression: "showImage"
          }
        ],
        staticClass: "avatar-image"
      },
      [
        _vm.type == "link"
          ? _c("a", {
              class: _vm.imageClasses,
              style: "background-image:url(" + _vm.imageUrl + ")",
              attrs: { href: _vm.joinLink }
            })
          : _vm._e(),
        _vm._v(" "),
        _vm.type == "image"
          ? _c("div", {
              class: _vm.imageClasses,
              style: "background-image:url(" + _vm.imageUrl + ")"
            })
          : _vm._e()
      ]
    ),
    _vm._v(" "),
    _vm.showContent
      ? _c("div", { staticClass: "avatar-label" }, [
          _vm.showName
            ? _c("span", {
                staticClass: "avatar-title",
                domProps: { textContent: _vm._s(_vm.positionName) }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showMetadata
            ? _c(
                "span",
                { staticClass: "avatar-meta" },
                [
                  _vm._t("default", [
                    _c(
                      "a",
                      {
                        staticClass: "text-muted",
                        attrs: { href: _vm.joinLink }
                      },
                      [_vm._v("Apply Now")]
                    )
                  ])
                ],
                2
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a954ef60", module.exports)
  }
}

/***/ }),
/* 212 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 213 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
],[151]);