mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
   .js('node_modules/select2/dist/js/select2.min.js', 'public/js')
   .sass('node_modules/select2/dist/css/select2.min.css', 'public/css')
   .sass('resources/sass/app.scss', 'public/css')
   .scripts([
       'node_modules/jquery/dist/jquery.js'
   ], 'public/js/jquery.js');
   mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/select2/dist/css/select2.min.css', 'public/css')
   .copy('node_modules/select2/dist/js/select2.min.js', 'public/js');
