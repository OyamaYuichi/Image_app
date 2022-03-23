const mix = require('laravel-mix')

mix.browserSync({
    proxy: '0.0.0.0:8081', // アプリの起動アドレス
    open: true // ブラウザを自動で開かない
  })
  .js('resources/js/app.js', 'public/js').vue({ version: 2 })
  .version
