/*
 * This file is part of «Letters of Russian sovereigns to the Republic of Venice» database.
 *
 * Copyright (c) Department of Linguistic and Literary Studies of the University of Padova
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is free software:
 * you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, version 3.
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is distributed
 * in the hope  that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. If you have not received
 * a copy of the GNU General Public License along with
 * «Letters of Russian sovereigns to the Republic of Venice» database,
 * see <http://www.gnu.org/licenses/>.
 */

const Encore = require('@symfony/webpack-encore');

var CopyWebpackPlugin = require('copy-webpack-plugin');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableBuildNotifications()
    .enableSassLoader()
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .addStyleEntry('css/person/list', './assets/scss/pages/person/list.scss')
    .addStyleEntry('css/person/show', './assets/scss/pages/person/show.scss')
    .addStyleEntry('css/letter/list', './assets/scss/pages/letter/list.scss')
    .addStyleEntry('css/letter/show', './assets/scss/pages/letter/show.scss')
    .addStyleEntry('css/bibliography/list', './assets/scss/pages/bibliography/list.scss')
    .addPlugin(new CopyWebpackPlugin([
        {
            from: './assets/fonts',
            to: 'fonts'
        }
    ]))
;

module.exports = Encore.getWebpackConfig();
