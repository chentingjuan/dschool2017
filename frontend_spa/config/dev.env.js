'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  API_DOMAIN: '"http://dschool2017.test/"',
  HOST: "0.0.0.0",
  host: "0.0.0.0"
})
