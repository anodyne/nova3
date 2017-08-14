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
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(51),
  /* template */
  __webpack_require__(52),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\Rank.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Rank.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ca296a98", Component.options)
  } else {
    hotAPI.reload("data-v-ca296a98", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(64),
  /* template */
  __webpack_require__(65),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\UserAvatar.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserAvatar.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3ebbf38c", Component.options)
  } else {
    hotAPI.reload("data-v-3ebbf38c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 22 */,
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(69),
  /* template */
  __webpack_require__(70),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\CharacterAvatar.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CharacterAvatar.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-04d280ec", Component.options)
  } else {
    hotAPI.reload("data-v-04d280ec", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(29);
__webpack_require__(77);
__webpack_require__(78);
module.exports = __webpack_require__(79);


/***/ }),
/* 29 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button__);
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(30);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('rank', __webpack_require__(20));
Vue.component('rank-picker', __webpack_require__(53));
Vue.component('flash', __webpack_require__(56));
Vue.component('user-avatar', __webpack_require__(21));
Vue.component('user-picker', __webpack_require__(66));
Vue.component('character-avatar', __webpack_require__(23));
Vue.component('character-picker', __webpack_require__(71));
// Vue.component('media-item', require('./components/MediaItem.vue'));
Vue.component('media-manager', __webpack_require__(74));


Vue.use(__WEBPACK_IMPORTED_MODULE_0_vue_js_toggle_button___default.a);

Vue.component('desktop', {
  template: '<div class="d-none d-md-block" v-cloak><slot></slot></div>'
});

Vue.component('mobile', {
  template: '<div class="d-xs-block d-md-none" v-cloak><slot></slot></div>'
});

Vue.component('phone', {
  template: '<div class="d-xs-block d-md-none" v-cloak><slot></slot></div>'
});

Vue.component('tablet', {
  template: '<div class="d-xs-none d-sm-block d-md-none" v-cloak><slot></slot></div>'
});

/***/ }),
/* 30 */
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
	window.$ = window.jQuery = __webpack_require__(3);

	window.Popper = __WEBPACK_IMPORTED_MODULE_0_popper_js_dist_umd_popper_js___default.a;

	__webpack_require__(10);
	window.jconfirm = __webpack_require__(11);
} catch (e) {}

window.Vue = __webpack_require__(4);
window.md5 = __webpack_require__(5);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(13);
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

window.route = function (name) {
	var args = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

	// Grab the URI from the list of routes
	var uri = window.Nova.routes[name];

	// Loop through the arguments and replace the variable with its value
	Object.keys(args).map(function (a) {
		return uri = uri.replace('{' + a + '}', args[a]);
	});

	// Put the full URL back together
	return [window.Nova.system.baseUrl, uri].join('/');
};

window.icon = function (name) {
	var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

	// Grab the template
	var template = window.Nova.iconTemplate;
	var icon = window.Nova.icons[name];

	template = template.replace('%2$s', attributes);

	return template.replace('%1$s', icon);
};

/***/ }),
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
/* 51 */
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
		item: {
			type: Object
		},
		base: {
			type: String
		},
		overlay: {
			type: String
		}
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
/* 52 */
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
     require("vue-hot-reload-api").rerender("data-v-ca296a98", module.exports)
  }
}

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(54),
  /* template */
  __webpack_require__(55),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\RankPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] RankPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6b88993c", Component.options)
  } else {
    hotAPI.reload("data-v-6b88993c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 54 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Rank_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Rank_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(6);
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
/* 55 */
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
  }, [(_vm.selectedRank) ? _c('div', {
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('rank', {
    attrs: {
      "item": _vm.selectedRank
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })], 1), _vm._v(" "), _c('small', {
    staticClass: "meta"
  }, [_vm._v(_vm._s(_vm.selectedRank.info.name))]), _vm._v(" "), _c('input', {
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
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('rank'), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })], 1)]) : _vm._e(), _vm._v(" "), _c('div', {
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
      "placeholder": "Find by name or group"
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
    staticClass: "alert alert-warning"
  }, [_vm._v("No ranks found")])]), _vm._v(" "), _vm._l((_vm.filteredRanks), function(rank) {
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
     require("vue-hot-reload-api").rerender("data-v-6b88993c", module.exports)
  }
}

/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(57)
}
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(62),
  /* template */
  __webpack_require__(63),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\Flash.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Flash.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b207b2d0", Component.options)
  } else {
    hotAPI.reload("data-v-b207b2d0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(58);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(60)("ea7790e0", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b207b2d0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b207b2d0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/sass-loader/lib/loader.js!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Flash.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(59)(undefined);
// imports


// module
exports.push([module.i, "\n.fade-enter-active, .fade-leave-active {\n  transition: opacity .5s;\n}\n.fade-enter, .fade-leave-to {\n  opacity: 0;\n}\n", ""]);

// exports


/***/ }),
/* 59 */
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
/* 60 */
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

var listToStyles = __webpack_require__(61)

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
/* 61 */
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
/* 62 */
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
/* 63 */
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
     require("vue-hot-reload-api").rerender("data-v-b207b2d0", module.exports)
  }
}

/***/ }),
/* 64 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_md5__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_humanize_number__ = __webpack_require__(22);
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
			return '/profile/' + this.user.id;
		},
		url: function url() {
			return this.user.avatarImage;
		}
	}
});

/***/ }),
/* 65 */
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
    staticClass: "avatar-label ml-3"
  }, [_c('span', {
    staticClass: "h1"
  }, [_vm._v(_vm._s(this.user.displayName))]), _vm._v(" "), _c('span', {
    staticClass: "text-muted"
  }, [_vm._t("beforeLabel"), _vm._v(" "), (_vm.hasBeforeLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), (_vm.hasAfterLabel) ? _c('span', {
    staticClass: "px-1"
  }, [_vm._v("•")]) : _vm._e(), _vm._v(" "), _vm._t("afterLabel")], 2)]) : _vm._e(), _vm._v(" "), (_vm.size == 'md') ? _c('div', {
    staticClass: "avatar-label ml-3"
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
    staticClass: "avatar-label ml-3"
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
     require("vue-hot-reload-api").rerender("data-v-3ebbf38c", module.exports)
  }
}

/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(67),
  /* template */
  __webpack_require__(68),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\UserPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-020d9841", Component.options)
  } else {
    hotAPI.reload("data-v-020d9841", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__UserAvatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(6);
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
		away: function away() {
			this.show = false;
		},
		selectUser: function selectUser(user) {
			this.selectedUser = user;
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
			this.selectedUser = this.selected;
		}

		axios.get(route('api.users')).then(function (response) {
			self.users = response.data;
		});
	}
});

/***/ }),
/* 68 */
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
  }, [(_vm.selectedUser) ? _c('div', {
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('user-avatar', {
    attrs: {
      "user": _vm.selectedUser,
      "has-label": true,
      "size": "xs",
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
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('span', [_vm._v("No user")]), _vm._v(" "), _c('span', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })])]) : _vm._e(), _vm._v(" "), _c('div', {
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
      "placeholder": "Find by name or email"
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
    staticClass: "alert alert-warning"
  }, [_vm._v("No users found")])]), _vm._v(" "), (_vm.selectedUser != false) ? _c('div', {
    staticClass: "items-menu-item",
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.selectUser(false)
      }
    }
  }, [_vm._v("\n\t\t\tNo user\n\t\t")]) : _vm._e(), _vm._v(" "), _vm._l((_vm.filteredUsers), function(user) {
    return _c('div', {
      staticClass: "items-menu-item",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectUser(user)
        }
      }
    }, [_c('user-avatar', {
      attrs: {
        "user": user,
        "has-label": true,
        "size": "xs",
        "type": "image"
      }
    })], 1)
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-020d9841", module.exports)
  }
}

/***/ }),
/* 69 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_md5__ = __webpack_require__(5);
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
		character: {
			type: Object,
			required: true
		},
		hasContent: {
			type: Boolean,
			default: true
		},
		showName: {
			type: Boolean,
			default: true
		},
		showMetadata: {
			type: Boolean,
			default: true
		},
		size: {
			type: String,
			default: ''
		},
		type: {
			type: String,
			default: 'link'
		}
	},

	computed: {
		classes: function classes() {
			return ['avatar', this.size];
		},
		displayName: function displayName() {
			var pieces = [];

			if (this.character.rank) {
				pieces.push(this.character.rank.info.name);
			}

			pieces.push(this.character.name);

			return pieces.join(' ');
		},
		profileLink: function profileLink() {
			return '/character/' + this.character.id;
		},
		url: function url() {
			return this.character.avatarImage;
		}
	}
});

/***/ }),
/* 70 */
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
  }) : _vm._e(), _vm._v(" "), (_vm.hasContent) ? _c('div', [(_vm.size == 'lg') ? _c('div', {
    staticClass: "avatar-label ml-3"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h1"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "text-muted"
  }, [_vm._v(_vm._s(this.character.position.name))]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'md') ? _c('div', {
    staticClass: "avatar-label ml-3"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h4"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('span', {
    staticClass: "text-muted"
  }, [_vm._v(_vm._s(this.character.position.name))]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'sm') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h5 mb-0"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == 'xs') ? _c('div', {
    staticClass: "avatar-label ml-2"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h6 mb-0"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.size == '') ? _c('div', {
    staticClass: "avatar-label ml-3"
  }, [(_vm.showName) ? _c('span', {
    staticClass: "h6 mb-1"
  }, [_vm._v(_vm._s(this.displayName))]) : _vm._e(), _vm._v(" "), (_vm.showMetadata) ? _c('small', {
    staticClass: "text-muted"
  }, [_vm._v("\n\t\t\t\t" + _vm._s(this.character.position.name) + "\n\t\t\t")]) : _vm._e()]) : _vm._e()]) : _vm._e()])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-04d280ec", module.exports)
  }
}

/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(72),
  /* template */
  __webpack_require__(73),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\CharacterPicker.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CharacterPicker.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7e2f3782", Component.options)
  } else {
    hotAPI.reload("data-v-7e2f3782", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 72 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__CharacterAvatar_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(6);
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




/* harmony default export */ __webpack_exports__["default"] = ({
	props: {
		selected: { type: Object }
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

			return this.characters.filter(function (character) {
				var searchRegex = new RegExp(self.search, 'i');

				return searchRegex.test(character.name) || searchRegex.test(character.user.displayName) || searchRegex.test(character.position.name);
			});
		}
	},

	methods: {
		away: function away() {
			this.show = false;
		},
		selectCharacter: function selectCharacter(character) {
			this.selectedCharacter = character;
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
			this.selectedCharacter = this.selected;
		}

		axios.get(route('api.characters')).then(function (response) {
			self.characters = response.data;
		});
	}
});

/***/ }),
/* 73 */
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
  }, [(_vm.selectedCharacter) ? _c('div', {
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('character-avatar', {
    attrs: {
      "character": _vm.selectedCharacter,
      "size": "xs",
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
      "name": "character_id"
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
    staticClass: "selected-toggle",
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
    staticClass: "selected-item"
  }, [_c('span', [_vm._v("No character")]), _vm._v(" "), _c('div', {
    staticClass: "ml-3",
    domProps: {
      "innerHTML": _vm._s(_vm.showIcon('more'))
    }
  })])]) : _vm._e(), _vm._v(" "), _c('div', {
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
      "placeholder": "Find characters..."
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
    staticClass: "alert alert-warning"
  }, [_vm._v("No characters found")])]), _vm._v(" "), (_vm.selectedCharacter != false) ? _c('div', {
    staticClass: "items-menu-item",
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.selectCharacter(false)
      }
    }
  }, [_vm._v("\n\t\t\tNo character\n\t\t")]) : _vm._e(), _vm._v(" "), _vm._l((_vm.filteredCharacters), function(character) {
    return _c('div', {
      staticClass: "items-menu-item",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.selectCharacter(character)
        }
      }
    }, [_c('character-avatar', {
      attrs: {
        "character": character,
        "size": "xs",
        "type": "image"
      }
    })], 1)
  })], 2)])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-7e2f3782", module.exports)
  }
}

/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(75),
  /* template */
  __webpack_require__(76),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "C:\\mamp\\htdocs\\nova3\\nova\\resources\\assets\\js\\components\\MediaManager.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MediaManager.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-001c9731", Component.options)
  } else {
    hotAPI.reload("data-v-001c9731", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 75 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($, Sortable) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_pluralize__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_pluralize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_pluralize__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
			this.crop = $('#crop').croppie({
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

				self.crop.croppie('bind', {
					url: self.uploadedFile
				});
			};

			reader.readAsDataURL(file);
		},
		deleteFile: function deleteFile(id) {
			var self = this;

			$.confirm({
				title: "Delete Media",
				content: "Are you sure you want to delete this media?",
				theme: "dark",
				buttons: {
					confirm: {
						text: "Delete",
						btnClass: "btn-danger",
						action: function action() {
							axios.delete(route('media.destroy', { media: id })).then(function (response) {
								var index = _.findIndex(self.files, function (f) {
									return f.id == id;
								});

								self.files.splice(index, 1);

								flash('The media has been deleted', '');
							});
						}
					},
					cancel: {
						text: "Cancel"
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
			return [window.Nova.baseUrl, 'storage', 'app', 'public', __WEBPACK_IMPORTED_MODULE_0_pluralize___default()(this.type), file.filename].join('/');
		},
		makePrimary: function makePrimary(id) {
			axios.patch(route('media.update', { media: id }));

			_.each(this.files, function (file) {
				if (file.id != id) {
					file.primary = 0;
				} else {
					file.primary = 1;
				}
			});

			flash('Primary image updated', '', 'success');
		},
		reset: function reset() {
			document.getElementById('file-upload').value = '';
			this.image = '';
		},
		saveFile: function saveFile() {
			var self = this;

			this.crop.croppie('result', 'canvas').then(function (canvas) {
				axios.post(route('media.store'), {
					image: canvas,
					location: __WEBPACK_IMPORTED_MODULE_0_pluralize___default()(self.type),
					id: self.item.id,
					type: self.type
				}).then(function (response) {
					flash('Media saved', 'File saved', 'success');
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
					var order = new Array();

					$(event.from).children().each(function () {
						var id = $(this).data('id');

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
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(3), __webpack_require__(24)))

/***/ }),
/* 76 */
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
     require("vue-hot-reload-api").rerender("data-v-001c9731", module.exports)
  }
}

/***/ }),
/* 77 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 78 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 79 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
],[28]);