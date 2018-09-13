module.exports = {
	'extends': [
		'airbnb-base',
		'plugin:vue/recommended',
	],

	'parserOptions': {
		'ecmaVersion': 6
	},

	'globals': {
		'Nova': true,
		'route': true
	},

	'rules': {
		'arrow-body-style': ['error', 'always'],
		'comma-dangle': ['error', 'never'],
		'indent': ['error', 4],
		'quotes': ['error', 'single'],
		'space-before-function-paren': ['error', 'always'],
		'vue/html-indent': ['error', 4],
		'vue/html-closing-bracket-newline': ['error', {
			'singleline': 'never',
			'multiline': 'always',
		}]
	}
}
