const SvgoConfig = require('vue-svgicon/default/svgo.js');

// We're using the <desc> elements inside SVGs to store additional metadata/alternate titles
// of SVG icons, so we have to override the default svgo config to NOT remove <desc> elements
SvgoConfig.plugins.find((plugin) => { return !!plugin.removeDesc; }).removeDesc = false;

module.exports = SvgoConfig;